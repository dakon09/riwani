<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmkmImportLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'total_row',
        'success_row',
        'failed_row',
        'imported_by',
        'imported_at',
        'note',
    ];

    protected $casts = [
        'total_row' => 'integer',
        'success_row' => 'integer',
        'failed_row' => 'integer',
        'imported_at' => 'datetime',
    ];

    public function importedBy()
    {
        return $this->belongsTo(User::class, 'imported_by');
    }
}
