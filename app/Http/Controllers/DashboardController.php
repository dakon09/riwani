<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticationProvider;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function mfa()
    {
        return view('mfa');
    }

    public function twoFaChallenge()
    {
        return view('auth.verify-2fa');
    }

    public function confirm2fA(Request $request, TwoFactorAuthenticationProvider $provider)
    {
        $user = Auth::user();
        $code = $request->input('code');

        if ($provider->verify(decrypt($user->two_factor_secret), $code)) {
            session(['2fa_verified_at' => now()]);
            return redirect()->intended();
        }

        return back()->withErrors(['code' => 'Wrong OTP Code']);
    }
}
