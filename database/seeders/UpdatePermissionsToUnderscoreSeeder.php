<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UpdatePermissionsToUnderscoreSeeder extends Seeder
{
    public function run(): void
    {
        $permissionMap = [
            'master-user' => 'master_user',
            'master-role' => 'master_role',
            'master-permission' => 'master_permission',
            'umkm.index' => 'umkm_index',
            'umkm.create' => 'umkm_create',
            'umkm.edit' => 'umkm_edit',
            'umkm.delete' => 'umkm_delete',
            'umkm.import' => 'umkm_import',
            'dashboard' => 'dashboard',
        ];

        foreach ($permissionMap as $oldName => $newName) {
            $permission = Permission::where('name', $oldName)->first();
            if ($permission) {
                $permission->name = $newName;
                $permission->save();
                echo "Updated: {$oldName} -> {$newName}\n";
            }
        }
    }
}
