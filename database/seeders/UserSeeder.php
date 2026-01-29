<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'dashboard',
            'master_user',
            'master_role',
            'master_permission',
            'umkm_index',
            'umkm_create',
            'umkm_edit',
            'umkm_delete',
            'umkm_import',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // create role and assign permissions
        $role = Role::firstOrCreate(['name' => 'Super Admin']);
        $role->givePermissionTo(Permission::all());

        // create user and assign role
        $user = User::firstOrCreate(
            [
                'email' => 'admin@boilerplate.com',
                'username' => 'superadmin',
            ],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('123123123'),
                'email_verified_at' => now(),
            ]
        );

        $user->assignRole($role);
    }
}
