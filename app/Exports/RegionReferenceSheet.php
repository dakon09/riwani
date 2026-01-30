<?php

namespace App\Exports;

use Laravolt\Indonesia\Models\Village;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RegionReferenceSheet implements FromQuery, WithHeadings, WithTitle, ShouldAutoSize
{
    public function query()
    {
        return Village::query()
            ->join('indonesia_districts', 'indonesia_villages.district_code', '=', 'indonesia_districts.code')
            ->join('indonesia_cities', 'indonesia_districts.city_code', '=', 'indonesia_cities.code')
            ->join('indonesia_provinces', 'indonesia_cities.province_code', '=', 'indonesia_provinces.code')
            ->select(
                'indonesia_provinces.name as provinsi',
                'indonesia_cities.name as kabupaten_kota',
                'indonesia_districts.name as kecamatan',
                'indonesia_villages.name as kelurahan'
            )
            ->orderBy('indonesia_provinces.name')
            ->orderBy('indonesia_cities.name')
            ->orderBy('indonesia_districts.name')
            ->orderBy('indonesia_villages.name');
    }

    public function headings(): array
    {
        return [
            'Provinsi',
            'Kabupaten/Kota',
            'Kecamatan',
            'Kelurahan',
        ];
    }

    public function title(): string
    {
        return 'Referensi Wilayah';
    }
}
