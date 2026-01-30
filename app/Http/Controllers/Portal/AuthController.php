<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('portal.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');
        $login = trim($credentials['username']);

        $attempted = Auth::guard('umkm')->attempt([
            'username' => $login,
            'password' => $credentials['password'],
        ], $remember);

        if (! $attempted && str_contains($login, '@')) {
            $attempted = Auth::guard('umkm')->attempt([
                'email' => strtolower($login),
                'password' => $credentials['password'],
            ], $remember);
        }

        if (! $attempted) {
            return back()->withErrors([
                'login' => 'Username atau password tidak sesuai.',
            ])->withInput($request->only('username'));
        }

        $request->session()->regenerate();

        $user = Auth::guard('umkm')->user();
        if (! $user?->umkm) {
            Auth::guard('umkm')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'login' => 'Akun belum terhubung ke data UMKM.',
            ])->withInput($request->only('username'));
        }

        if ($user->umkm->status_umkm !== 'ACTIVE') {
            Auth::guard('umkm')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'login' => 'Akun UMKM belum aktif. Status saat ini: '.$user->umkm->status_umkm.'. Silakan hubungi admin.',
            ])->withInput($request->only('username'));
        }

        return redirect()->route('portal.profile');
    }

    public function logout(Request $request)
    {
        Auth::guard('umkm')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('portal.login');
    }
}
