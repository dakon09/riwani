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

        try {
            $umkm = new Umkm([
                'umkm_code' => Umkm::generateUmkmCode(),
                'nama_usaha' => $namaUsaha,
                'jenis_usaha' => $jenisUsaha,
                'sektor_usaha' => $row['sektor_usaha'] ?? null,
                'tahun_berdiri' => $row['tahun_berdiri'] ?? null,
                'alamat_usaha' => $row['alamat_usaha'] ?? null,
                'provinsi_id' => $this->getRegionId(\Laravolt\Indonesia\Models\Province::class, $row['provinsi'] ?? null),
                'kabupaten_id' => $this->getRegionId(\Laravolt\Indonesia\Models\City::class, $row['kabupaten'] ?? null),
                'kecamatan_id' => $this->getRegionId(\Laravolt\Indonesia\Models\District::class, $row['kecamatan'] ?? null),
                'kelurahan_id' => $this->getRegionId(\Laravolt\Indonesia\Models\Village::class, $row['kelurahan'] ?? null),
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

    private function getRegionId($modelClass, $name)
    {
        if (!$name)
            return null;

        // Try exact match first
        $region = $modelClass::where('name', $name)->first();
        if ($region)
            return $region->code;

        // Try loose match
        $region = $modelClass::where('name', 'like', '%' . $name . '%')->first();
        if ($region)
            return $region->code;

        return null;
    }
}
