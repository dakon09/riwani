<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UmkmInputSheet implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $data;

    public function __construct()
    {
        $this->data = [];
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'nama_usaha',
            'jenis_usaha',
            'sektor_usaha',
            'tahun_berdiri',
            'alamat_usaha',
            'provinsi',
            'kabupaten',
            'kecamatan',
            'kelurahan',
            'kode_pos',
            'nama_pemilik',
            'nik_pemilik',
            'no_hp',
            'email',
            'alamat_pemilik',
            'bentuk_badan_usaha',
            'npwp',
            'nib',
            'izin_usaha',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F81BD'],
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Input Data';
    }
}
