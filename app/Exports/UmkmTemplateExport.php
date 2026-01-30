<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UmkmTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new UmkmInputSheet(),
            // new RegionReferenceSheet(), // Disabled due to size/timeout
        ];
    }
}
