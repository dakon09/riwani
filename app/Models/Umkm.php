<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Umkm extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'umkm';

    protected $fillable = [
        'umkm_code',
        'nama_usaha',
        'jenis_usaha',
        'sektor_usaha',
        'tahun_berdiri',
        'alamat_usaha',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
        'kode_pos',
        'status_umkm',
        'source_input',
        'nama_pemilik',
        'nik_pemilik',
        'no_hp',
        'email',
        'alamat_pemilik',
        'bentuk_badan_usaha',
        'npwp',
        'nib',
        'izin_usaha',
        'status_legalitas',
        'user_id',
        'created_by',
        'verified_by',
    ];

    protected $casts = [
        'tahun_berdiri' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function province()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\Province::class, 'provinsi_id');
    }

    public function city()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\City::class, 'kabupaten_id');
    }

    public function district()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\District::class, 'kecamatan_id');
    }

    public function village()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\Village::class, 'kelurahan_id');
    }

    public static function generateUmkmCode()
    {
        $lastCode = self::withTrashed()->max('umkm_code');

        if (!$lastCode) {
            return 'UMKM001';
        }

        $number = intval(substr($lastCode, 4)) + 1;

        return 'UMKM' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public function scopeManual($query)
    {
        return $query->where('source_input', 'MANUAL');
    }

    public function scopeImported($query)
    {
        return $query->where('source_input', 'IMPORT');
    }

    public function scopeActive($query)
    {
        return $query->where('status_umkm', 'ACTIVE');
    }

    public function scopeRegistered($query)
    {
        return $query->where('status_umkm', 'REGISTERED');
    }
}
