<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\UmkmProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::guard('umkm')->user();
        if (!$user) {
            return redirect()->route('portal.login');
        }

        $umkm = $user->umkm()->with(['province', 'city', 'district', 'village', 'user'])->first();

        if (!$umkm) {
            Auth::guard('umkm')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('portal.login')->withErrors([
                'login' => 'Akun belum terhubung ke data UMKM.',
            ]);
        }

        return view('portal.umkm.profile', [
            'data' => $umkm,
        ]);
    }

    public function edit(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::guard('umkm')->user();
        if (!$user) {
            return redirect()->route('portal.login');
        }

        $umkm = $user->umkm()->with(['province', 'city', 'district', 'village', 'user'])->first();

        // If no UMKM data, redirect (should be handled by middleware/login flow generally but good safety)
        if (!$umkm) {
            return redirect()->route('portal.profile');
        }

        return view('portal.umkm.edit', [
            'data' => $umkm,
        ]);
    }

    public function update(UmkmProfileUpdateRequest $request)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::guard('umkm')->user();
        if (!$user) {
            return redirect()->route('portal.login');
        }

        $umkm = $user->umkm;

        if (!$umkm) {
            return redirect()->route('portal.login')->withErrors([
                'login' => 'Akun belum terhubung ke data UMKM.',
            ]);
        }

        $data = $request->validated();

        $user->name = $data['nama_pemilik'] ?? $data['nama_usaha'];
        $user->username = $data['username'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        unset($data['username'], $data['password']);
        $umkm->fill($data);
        $umkm->save();

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }
}
