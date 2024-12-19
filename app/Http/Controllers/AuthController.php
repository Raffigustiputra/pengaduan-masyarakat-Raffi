<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function showLogin()
    {
        return view('auth.login');
    }

    public function authLogin(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $action = $request->input('action');
        $email = $request->input('email');
        $password = $request->input('password');

        if ($action === 'login') {
            // Proses login
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                $request->session()->regenerate();
                $role = Auth::user()->role;
                if ($role === 'GUEST') {
                    return redirect()->route('report')->with('success', 'Login berhasil. Selamat datang ' . Auth::user()->email . '!');
                } elseif ($role === 'STAFF') {
                    return redirect()->route('')->with('success', 'Login berhasil. Selamat datang ' . Auth::user()->email . '!');
                } elseif ($role === 'HEAD_STAFF') {
                    return redirect()->route('headstaff.page')->with('success', 'Login berhasil. Selamat datang ' . Auth::user()->email . '!');
                }
                
                return redirect()->route('report')->with('success', 'Login berhasil. Selamat datang ' . Auth::user()->email . '!');
            } else {
                // Cek apakah akun ada di database
                $userExists = User::where('email', $email)->exists();
                if (!$userExists) {
                    // Jika akun belum ada, tampilkan alert
                    return back()->with('failed', 'Akun Anda belum terdaftar. Silakan buat akun terlebih dahulu.');
                }
                // Jika akun ada tetapi password salah
                return back()->with('failed', 'Login gagal. Password salah.');
            }
        } elseif ($action === 'register') {
            // Proses pembuatan akun
            $userExists = User::where('email', $email)->exists();
            if ($userExists) {
                return back()->with('failed', 'Akun dengan email ini sudah terdaftar.');
            }

            $user = User::create([
                'email' => $email,
                'password' => bcrypt($password),
            ]);

            Auth::login($user);
            return redirect()->route('report')->with('success', 'Akun Anda berhasil dibuat dan Anda sudah login.');
        }

        return back()->with('failed', 'Terjadi kesalahan.');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('dashboard')->with('success', 'Logout successful');
    }
}
