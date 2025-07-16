<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tamu;
use App\Models\PenjadwalanSatpam;
use App\Models\LogAktivitas;
use App\Exports\TamuExport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class SatpamController extends Controller
{
    /**
     * Menampilkan daftar tamu
     */
    public function daftarTamu(Request $request)
    {
        $query = Tamu::query();
        
        // Filter berdasarkan hari ini jika parameter filter=today
        if ($request->has('filter') && $request->filter === 'today') {
            $today = Carbon::today()->format('Y-m-d');
            $query->whereDate('tanggal', $today);
        }
        
        // Ambil data tamu dan urutkan berdasarkan tanggal terbaru
        $daftarTamu = $query->orderBy('tanggal', 'desc')
                           ->orderBy('jam_masuk', 'desc')
                           ->paginate(10);
        
        return view('satpam.daftar-tamu', compact('daftarTamu'));
    }
    
    /**
     * Export data tamu ke PDF atau Excel
     */
    public function exportTamu(Request $request, $type)
    {
        $filter = $request->get('filter', 'all');
        
        try {
            if ($type === 'excel') {
                $filename = 'data-tamu-' . ($filter === 'today' ? 'hari-ini-' : '') . date('Y-m-d-H-i-s') . '.xlsx';
                return Excel::download(new TamuExport($filter === 'today' ? 'today' : null), $filename);
                
            } elseif ($type === 'pdf') {
                $query = Tamu::query();
                
                if ($filter === 'today') {
                    $query->whereDate('tanggal', today());
                    $title = 'Data Tamu Hari Ini - ' . Carbon::today('Asia/Jakarta')->format('d/m/Y');
                } else {
                    $title = 'Semua Data Tamu';
                }
                
                $tamus = $query->orderBy('tanggal', 'desc')
                              ->orderBy('jam_masuk', 'desc')
                              ->get();
                
                $pdf = Pdf::loadView('exports.tamu-pdf', [
                    'tamus' => $tamus,
                    'title' => $title,
                    'filter' => $filter
                ]);
                
                $pdf->setPaper('A4', 'landscape');
                
                $filename = 'data-tamu-' . ($filter === 'today' ? 'hari-ini-' : '') . date('Y-m-d-H-i-s') . '.pdf';
                return $pdf->download($filename);
                
            } else {
                return redirect()->back()->with('error', 'Tipe export tidak valid');
            }
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat export: ' . $e->getMessage());
        }
    }
    
    /**
     * Logout tamu (mengubah status tamu menjadi sudah keluar)
     */
    public function logoutTamu(Request $request, $id)
    {
        $tamu = Tamu::findOrFail($id);
        $tamu->update([
            'posisi' => 'sudah keluar',
            'jam_keluar' => now()
        ]);

        try {
            // Log aktivitas logout tamu
            LogAktivitas::catatLogoutTamu(
                strval(Auth::id()), // Convert to string
                $tamu
            );

            return redirect()->route('satpam.daftar-tamu')
                ->with('success', 'Tamu berhasil logout.');
        } catch (\Exception $e) {
            
            
            return redirect()->route('satpam.daftar-tamu')
                ->with('error', 'Terjadi kesalahan saat mencatat aktivitas logout: ' . $e->getMessage());
        }
    }
    
    /**
     * Simpan data tamu baru
     */
    public function tambahTamu(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'jenis_tamu' => 'required|string',
            'plat_nomor' => 'required|string',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required',
            'posisi' => 'required|string',
            'tujuan' => 'required|string'
        ]);

        // Handle file upload
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarPath = $gambar->store('tamu-images', 'public');
        }

        // Create new guest record
        $tamu = Tamu::create([
            'gambar' => $gambarPath,
            'jenis_tamu' => $request->jenis_tamu,
            'plat_nomor' => $request->plat_nomor,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'posisi' => $request->posisi,
            'tujuan' => $request->tujuan
        ]);

        // Log aktivitas tambah tamu
        LogAktivitas::catatTambahTamu(Auth::id(), $tamu);

        return response()->json([
            'success' => true,
            'message' => 'Tamu berhasil ditambahkan',
            'data' => $tamu
        ]);
    }
    
    /**
     * Mengambil data tamu baru untuk notifikasi
     */
    public function getNewGuests()
    {
        $lastChecked = session('last_notification_check', now()->subMinutes(30));
        
        $newGuests = Tamu::where('created_at', '>', $lastChecked)
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        session(['last_notification_check' => now()]);
        
        return response()->json([
            'success' => true,
            'data' => $newGuests,
            'count' => $newGuests->count()
        ]);
    }
    
    /**
     * Mengambil jadwal satpam untuk notifikasi
     */
    public function getJadwalSatpam()
    {
        $jadwal = [];
        $user = auth()->user();
        
        // Ambil jadwal satpam berdasarkan nama user yang login
        $penjadwalan = PenjadwalanSatpam::where('nama', $user->name)->first();
        
        if ($penjadwalan) {
            $jadwal = [
                'senin' => $penjadwalan->senin,
                'selasa' => $penjadwalan->selasa,
                'rabu' => $penjadwalan->rabu,
                'kamis' => $penjadwalan->kamis,
                'jumat' => $penjadwalan->jumat,
                'sabtu' => $penjadwalan->sabtu,
                'minggu' => $penjadwalan->minggu
            ];
        }
        
        return response()->json([
            'success' => true,
            'jadwal' => $jadwal
        ]);
    }

    /**
     * Update data tamu
     */
    public function editTamu(Request $request, $id)
    {
        $tamu = Tamu::findOrFail($id);

        $request->validate([
            'jenis_tamu' => 'required|string',
            'plat_nomor' => 'required|string',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required',
            'posisi' => 'required|string',
            'tujuan' => 'required|string'
        ]);

        // Update guest record
        $tamu->update([
            'jenis_tamu' => $request->jenis_tamu,
            'plat_nomor' => $request->plat_nomor,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'posisi' => $request->posisi,
            'tujuan' => $request->tujuan
        ]);

        // Log aktivitas edit tamu
        LogAktivitas::catatEditTamu(Auth::id(), $tamu);

        return response()->json([
            'success' => true,
            'message' => 'Data tamu berhasil diperbarui',
            'data' => $tamu
        ]);
    }
}