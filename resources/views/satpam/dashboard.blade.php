@extends('layouts.satpam')

@php
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Tamu;
use App\Models\PenjadwalanSatpam;

// Ambil data tamu hari ini
$today = Carbon::today();
$tamuHariIni = Tamu::whereDate('tanggal', $today)->get();
$tamuMasuk = $tamuHariIni->where('posisi', 'sedang didalam')->count();
$tamuKeluar = $tamuHariIni->where('posisi', 'sudah keluar')->count();
$totalTamu = $tamuHariIni->count();

// Ambil jadwal satpam untuk 3 hari ke depan
$user = Auth::user();
$jadwalSatpam = PenjadwalanSatpam::where('nama', $user->name)->first();
$hariIni = strtolower(Carbon::now()->locale('id')->dayName);
$besok = strtolower(Carbon::tomorrow()->locale('id')->dayName);
$lusa = strtolower(Carbon::tomorrow()->addDay()->locale('id')->dayName);
@endphp

@section('content')
<div class="content mobile-scroll-container">
    <!-- Notifikasi Welcome -->
    @if(session()->has('login_success'))
        <div id="welcome-alert" class="alert alert-success mb-4 animate__animated animate__fadeIn" style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; border-left: 5px solid #28a745; margin-bottom: 20px;"> 
            <i class="fas fa-bell mr-2"></i> Selamat datang, <strong>{{ Auth::user()->name }}</strong>! Anda berhasil login sebagai Satpam. 
        </div>
    
        <script>
            setTimeout(function() {
                const welcomeAlert = document.getElementById('welcome-alert');
                if (welcomeAlert) {
                    welcomeAlert.classList.remove('animate__fadeIn');
                    welcomeAlert.classList.add('animate__fadeOut');
                    setTimeout(() => welcomeAlert.remove(), 1000);
                }
            }, 10000);
        </script>
    @endif

    <!-- Dashboard Content -->
    <div class="page-content active" id="dashboard-content">
        <link rel="stylesheet" href="{{ asset('css/satpam/dashboard.css') }}">
        <h1 class="page-title">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard
        </h1>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalTamu }}</h3>
                    <p>Tamu Hari Ini</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $tamuMasuk }}</h3>
                    <p>sedang didalam</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-user-times"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $tamuKeluar }}</h3>
                    <p>Tamu Keluar</p>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tamu Terbaru Hari Ini</h3>
                <div class="card-tools">
                    <button class="btn btn-outline btn-sm" onclick="window.location.reload()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Jenis Tamu</th>
                                <th>Tujuan</th>
                                <th>Status</th>
                                <th>Plat Nomor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tamuHariIni->sortByDesc('created_at')->take(5) as $tamu)
                            <tr>
                                <td>{{ Carbon::parse($tamu->jam_masuk)->format('H:i') }}</td>
                                <td>{{ $tamu->jenis_tamu }}</td>
                                <td>{{ $tamu->tujuan }}</td>
                                <td><span class="badge badge-{{ $tamu->posisi == 'masuk' ? 'success' : 'warning' }}">{{ ucfirst($tamu->posisi) }}</span></td>
                                <td>{{ $tamu->plat_nomor }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada tamu hari ini</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Jadwal Jaga Card --> 
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0"><i class="fas fa-calendar-alt mr-2"></i> Jadwal Jaga Anda</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>Hari</th>
                                <th>Shift</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>({{ ucfirst($hariIni) }})</strong> </td>
                                <td>{{ $jadwalSatpam ? $jadwalSatpam->$hariIni : '-' }}</td>
                                <td>
                                    @if($jadwalSatpam && $jadwalSatpam->$hariIni)
                                        <span class="badge badge-success">Terjadwal</span>
                                    @else
                                        <span class="badge badge-secondary">Tidak ada jadwal</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>({{ ucfirst($besok) }})</strong> </td>
                                <td>{{ $jadwalSatpam ? $jadwalSatpam->$besok : '-' }}</td>
                                <td>
                                    @if($jadwalSatpam && $jadwalSatpam->$besok)
                                        <span class="badge badge-info">Terjadwal</span>
                                    @else
                                        <span class="badge badge-secondary">Tidak ada jadwal</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>({{ ucfirst($lusa) }})</strong> </td>
                                <td>{{ $jadwalSatpam ? $jadwalSatpam->$lusa : '-' }}</td>
                                <td>
                                    @if($jadwalSatpam && $jadwalSatpam->$lusa)
                                        <span class="badge badge-info">Terjadwal</span>
                                    @else
                                        <span class="badge badge-secondary">Tidak ada jadwal</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</div>

<style>
/* Mobile scrolling fix for dashboard */
.mobile-scroll-container {
    height: auto;
    overflow: visible;
}

@media (max-width: 768px) {
    /* Ensure main content area is scrollable */
    #main-content {
        height: 100vh !important;
        overflow-y: auto !important;
        -webkit-overflow-scrolling: touch !important;
    }
    
    /* Content padding adjustment */
    #main-content .p-6 {
        padding: 1rem !important;
        height: calc(100vh - 80px) !important;
        overflow-y: auto !important;
        -webkit-overflow-scrolling: touch !important;
        padding-bottom: 4rem !important;
    }
    
    /* Mobile scrolling fixes */
    .mobile-scroll-container {
        height: auto !important;
        max-height: none !important;
        overflow: visible !important;
        padding-bottom: 4rem !important;
        margin-bottom: 2rem !important;
    }
    
    .content {
        overflow: visible !important;
        padding-bottom: 3rem !important;
    }
    
    /* Stats grid responsive */
    .stats-grid {
        display: grid !important;
        grid-template-columns: 1fr !important;
        gap: 1rem !important;
        margin-bottom: 2rem !important;
    }
    
    .stat-card {
        margin-bottom: 1rem !important;
        overflow: visible !important;
    }
    
    /* Card responsive */
    .card {
        margin-bottom: 1.5rem !important;
        overflow: visible !important;
    }
    
    .card-body {
        overflow: visible !important;
        padding: 1rem !important;
    }
    
    /* Table responsive */
    .table-responsive {
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        margin: 0 -1rem !important;
        padding: 0 1rem !important;
    }
    
    .table-responsive table {
        width: 100% !important;
        white-space: nowrap !important;
    }
    
    /* Page title responsive */
    .page-title {
        font-size: 1.5rem !important;
        margin-bottom: 1.5rem !important;
    }
    
    /* Welcome alert responsive */
    #welcome-alert {
        margin-bottom: 1.5rem !important;
        padding: 1rem !important;
        font-size: 0.875rem !important;
    }
    
    /* Row and column responsive */
    .row {
        margin: 0 !important;
    }
    
    .col-12 {
        padding: 0 !important;
    }
    
    /* Extra small screens (390px and below) */
    @media (max-width: 390px) {
        .mobile-scroll-container {
            padding-bottom: 5rem !important;
        }
        
        .content {
            padding-bottom: 4rem !important;
        }
        
        #main-content .p-6 {
            padding-bottom: 6rem !important;
        }
        
        .stats-grid {
            gap: 0.75rem !important;
        }
        
        .stat-card {
            padding: 1rem !important;
        }
        
        .card-body {
            padding: 0.75rem !important;
        }
        
        .page-title {
            font-size: 1.25rem !important;
        }
    }
}

/* Desktop - ensure normal behavior */
@media (min-width: 769px) {
    .mobile-scroll-container {
        height: auto !important;
        overflow: visible !important;
    }
    
    #main-content .p-6 {
        height: auto !important;
        overflow: visible !important;
        padding-bottom: 1.5rem !important;
    }
}
</style>

@endsection
