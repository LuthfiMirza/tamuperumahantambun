<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthSatpamController extends Controller
{
    /**
     * Menampilkan halaman login satpam
     */
    public function showLoginForm()
    {
        return view('satpam.login-satpam');
    }

    /**
     * Proses login satpam
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'email' => $request->username, // Menggunakan email sebagai username
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Cek apakah user memiliki role satpam
            if ($user->nama_role === 'satpam') {
                $request->session()->regenerate();
                // Tambahkan flash message untuk notifikasi welcome
                session()->flash('login_success', true);
                return redirect()->intended(route('satpam.dashboard'));
            } else {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Anda tidak memiliki akses sebagai satpam.',
                ]);
            }
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    /**
     * Proses logout satpam
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('satpam.login');
    }
}