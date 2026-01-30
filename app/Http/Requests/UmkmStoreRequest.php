<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UmkmStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|min:4|max:50|unique:users,username',
            'password' => 'required|string|min:6',
            'nama_usaha' => 'required|string|max:255',
            'jenis_usaha' => 'required|in:Jasa,Dagang,Manufaktur',
            'sektor_usaha' => 'required|string|max:100',
            'tahun_berdiri' => 'nullable|digits:4|integer|min:1900|max:'.date('Y'),
            'alamat_usaha' => 'required|string',
            'provinsi_id' => 'required|exists:indonesia_provinces,code',
            'kabupaten_id' => 'required|exists:indonesia_cities,code',
            'kecamatan_id' => 'nullable|exists:indonesia_districts,code',
            'kelurahan_id' => 'nullable|exists:indonesia_villages,code',
            'kode_pos' => 'nullable|string|max:10',
            'status_umkm' => 'nullable|in:DRAFT,REGISTERED,ACTIVE,INACTIVE',
            'nama_pemilik' => 'required|string|max:255',
            'nik_pemilik' => 'nullable|digits:16',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:users,email',
            'alamat_pemilik' => 'nullable|string',
            'bentuk_badan_usaha' => 'nullable|in:Perorangan,CV,PT',
            'npwp' => 'nullable|string|max:20',
            'nib' => 'nullable|string|max:20',
            'izin_usaha' => 'nullable|string|max:255',
            'status_legalitas' => 'nullable|in:LENGKAP,BELUM',
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'nama_usaha.required' => 'Nama usaha harus diisi',
            'jenis_usaha.required' => 'Jenis usaha harus dipilih',
            'jenis_usaha.in' => 'Jenis usaha tidak valid',
            'sektor_usaha.required' => 'Sektor usaha harus diisi',
            'alamat_usaha.required' => 'Alamat usaha harus diisi',
            'provinsi_id.required' => 'Provinsi harus dipilih',
            'kabupaten_id.required' => 'Kabupaten harus dipilih',
            'nama_pemilik.required' => 'Nama pemilik harus diisi',
            'no_hp.required' => 'Nomor HP harus diisi',
            'nik_pemilik.digits' => 'NIK harus 16 digit',
            'email.email' => 'Format email tidak valid',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah digunakan',
            'tahun_berdiri.digits' => 'Tahun berdiri harus 4 digit',
            'tahun_berdiri.min' => 'Tahun berdiri tidak valid',
            'tahun_berdiri.max' => 'Tahun berdiri tidak boleh melebihi tahun sekarang',
        ];
    }
}
