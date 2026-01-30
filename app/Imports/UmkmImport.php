<?php

namespace App\Imports;

use App\Models\Umkm;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UmkmImport implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    private $totalRow = 0;

    private $successRow = 0;

    private $failedRow = 0;

    private $errors = [];

    public function model(array $row)
    {
        $this->totalRow++;

        $namaUsaha = $row['nama_usaha'] ?? null;
        $noHp = $row['no_hp'] ?? null;

        if (!$namaUsaha || !$noHp) {
            $this->failedRow++;
            $this->errors[] = [
                'row' => $this->totalRow,
                'nama_usaha' => $namaUsaha,
                'message' => 'Nama usaha dan No HP wajib diisi',
            ];

            return null;
        }

        $jenisUsaha = $row['jenis_usaha'] ?? null;
        if (!in_array($jenisUsaha, ['Jasa', 'Dagang', 'Manufaktur'])) {
            $this->failedRow++;
            $this->errors[] = [
                'row' => $this->totalRow,
                'nama_usaha' => $namaUsaha,
                'message' => 'Jenis usaha tidak valid (Jasa/Dagang/Manufaktur)',
            ];

            return null;
        }

        $existing = Umkm::where('nama_usaha', $namaUsaha)
            ->where('no_hp', $noHp)
            ->first();

        if ($existing) {
            $this->failedRow++;
            $this->errors[] = [
                'row' => $this->totalRow,
                'nama_usaha' => $namaUsaha,
                'message' => 'Data sudah ada (Nama Usaha + No HP duplikat)',
            ];

            return null;
        }

        // Strict Regional Validation
        $province = \Laravolt\Indonesia\Models\Province::where('name', $row['provinsi'])->first();
        if (!$province) {
            $this->failedRow++;
            $this->errors[] = [
                'row' => $this->totalRow,
                'nama_usaha' => $namaUsaha,
                'message' => "Provinsi '{$row['provinsi']}' tidak ditemukan. Pastikan penulisan sesuai master data.",
            ];
            return null;
        }

        $city = \Laravolt\Indonesia\Models\City::where('province_code', $province->code)
            ->where('name', $row['kabupaten'])
            ->first();
        if (!$city) {
            $this->failedRow++;
            $this->errors[] = [
                'row' => $this->totalRow,
                'nama_usaha' => $namaUsaha,
                'message' => "Kabupaten/Kota '{$row['kabupaten']}' tidak ditemukan di Provinsi '{$province->name}'.",
            ];
            return null;
        }

        $district = \Laravolt\Indonesia\Models\District::where('city_code', $city->code)
            ->where('name', $row['kecamatan'])
            ->first();
        if (!$district) {
            $this->failedRow++;
            $this->errors[] = [
                'row' => $this->totalRow,
                'nama_usaha' => $namaUsaha,
                'message' => "Kecamatan '{$row['kecamatan']}' tidak ditemukan di Kabupaten '{$city->name}'.",
            ];
            return null;
        }

        $village = \Laravolt\Indonesia\Models\Village::where('district_code', $district->code)
            ->where('name', $row['kelurahan'])
            ->first();
        if (!$village) {
            $this->failedRow++;
            $this->errors[] = [
                'row' => $this->totalRow,
                'nama_usaha' => $namaUsaha,
                'message' => "Kelurahan '{$row['kelurahan']}' tidak ditemukan di Kecamatan '{$district->name}'.",
            ];
            return null;
        }

        try {
            $umkm = new Umkm([
                'umkm_code' => Umkm::generateUmkmCode(),
                'nama_usaha' => $namaUsaha,
                'jenis_usaha' => $jenisUsaha,
                'sektor_usaha' => $row['sektor_usaha'] ?? null,
                'tahun_berdiri' => $row['tahun_berdiri'] ?? null,
                'alamat_usaha' => $row['alamat_usaha'] ?? null,
                'provinsi_id' => $province->code,
                'kabupaten_id' => $city->code,
                'kecamatan_id' => $district->code,
                'kelurahan_id' => $village->code,
                'kode_pos' => $row['kode_pos'] ?? null,
                'status_umkm' => 'REGISTERED',
                'source_input' => 'IMPORT',
                'nama_pemilik' => $row['nama_pemilik'] ?? null,
                'nik_pemilik' => $row['nik_pemilik'] ?? null,
                'no_hp' => $noHp,
                'email' => $row['email'] ?? null,
                'alamat_pemilik' => $row['alamat_pemilik'] ?? null,
                'bentuk_badan_usaha' => $row['bentuk_badan_usaha'] ?? 'Perorangan',
                'npwp' => $row['npwp'] ?? null,
                'nib' => $row['nib'] ?? null,
                'izin_usaha' => $row['izin_usaha'] ?? null,
                'status_legalitas' => 'BELUM',
                'user_id' => null,
                'created_by' => auth()->id(),
                'verified_by' => null,
            ]);

            $this->successRow++;

            return $umkm;
        } catch (\Exception $e) {
            $this->failedRow++;
            $this->errors[] = [
                'row' => $this->totalRow,
                'nama_usaha' => $namaUsaha,
                'message' => 'Error: ' . $e->getMessage(),
            ];

            return null;
        }
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function getTotalRow()
    {
        return $this->totalRow;
    }

    public function getSuccessRow()
    {
        return $this->successRow;
    }

    public function getFailedRow()
    {
        return $this->failedRow;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
