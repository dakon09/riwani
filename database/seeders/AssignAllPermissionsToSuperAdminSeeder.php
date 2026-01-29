<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignAllPermissionsToSuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = Role::where('name', 'Super Admin')->first();

        if (! $superAdminRole) {
            $this->command->error('Role "Super Admin" tidak ditemukan!');

            return;
        }

        $allPermissions = Permission::all();

        $existingPermissions = $superAdminRole->permissions->pluck('name')->toArray();

        $superAdminRole->syncPermissions($allPermissions);

        $this->command->info('Semua permission telah di-assign ke role "Super Admin"');
        $this->command->info('Jumlah permission yang di-assign: '.$allPermissions->count());
        $this->command->info('Daftar permission:');
        foreach ($allPermissions as $permission) {
            $this->command->info('  - '.$permission->name);
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
