<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isNotLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Memeriksa apakah pengguna sudah login
        if (auth()->check()) {
            // Jika sudah login, redirect ke halaman yang sesuai
            if (auth()->user()->role === 'GUEST') {
                return redirect()->route('report')->with('failed', 'Anda sudah login, anda tidak bisa masuk ke halaman login lagi!');
            }
            if (auth()->user()->role === 'STAFF') {
                return redirect()->route('')->with('failed', 'Anda sudah login, anda tidak bisa masuk ke halaman login lagi!');
            }
            if (auth()->user()->role === 'HEAD_STAFF') {
                return redirect()->route('')->with('failed', 'Anda sudah login, anda tidak bisa masuk ke halaman login lagi!');
            }
        }
        return $next($request);
    }
}
