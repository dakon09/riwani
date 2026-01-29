<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UmkmPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'umkm.index',
            'umkm.create',
            'umkm.edit',
            'umkm.delete',
            'umkm.import',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
