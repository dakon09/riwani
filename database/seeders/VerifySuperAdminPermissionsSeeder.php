<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class VerifySuperAdminPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('=== Verifikasi Permission Super Admin ===');

        $superAdmin = User::where('username', 'superadmin')->first();

        if (! $superAdmin) {
            $this->command->error('User superadmin tidak ditemukan!');

            return;
        }

        $this->command->info('User: '.$superAdmin->name.' (ID: '.$superAdmin->id.')');

        // Cek roles
        $roles = $superAdmin->roles;
        $this->command->info('Total roles: '.$roles->count());
        foreach ($roles as $role) {
            $this->command->info('  - Role: '.$role->name);
        }

        // Cek permissions langsung dari user
        $userPermissions = $superAdmin->getAllPermissions();
        $this->command->info('Total permissions via user: '.$userPermissions->count());

        // Cek all permissions di database
        $allDbPermissions = Permission::all();
        $this->command->info('Total permissions di database: '.$allDbPermissions->count());

        $missingPermissions = $allDbPermissions->diff($userPermissions);
        if ($missingPermissions->count() > 0) {
            $this->command->error('Permissions yang TIDAK dimiliki user:');
            foreach ($missingPermissions as $perm) {
                $this->command->error('  - '.$perm->name);
            }

            $this->command->info('Meng-assign permission yang hilang...');
            $superAdmin->givePermissionTo($missingPermissions);
        } else {
            $this->command->info('✅ User sudah memiliki SEMUA permissions di database');
        }

        // Refresh permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('✅ Permission cache telah di-refresh');
        $this->command->info('=== END Verifikasi ===');
        $this->command->newLine();
    }
}
