<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionAndRoles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionsByCategory = [
            'Profil'           => ['hapus_profil'],
            'Karyawan'         => ['lihat', 'edit', 'hapus', 'tambah', 'ubah_password', 'set_permission'],
            'Pasien'           => ['lihat', 'edit', 'hapus', 'tambah'],
            'Unit'             => ['lihat', 'edit', 'hapus', 'tambah'],
            'Jenis Insiden'    => ['lihat', 'edit', 'hapus', 'tambah'],
            'Penanggung Biaya' => ['lihat', 'edit', 'hapus', 'tambah'],
            'Insiden'          => ['lihat_semua', 'lihat_unit', 'lihat_pribadi', 'lihat', 'edit', 'edit_unit', 'edit_semua', 'hapus', 'hapus_unit', 'hapus_semua', 'tambah', 'grading'],
            'Investigasi'      => ['lihat_semua', 'lihat', 'tambah', 'edit', 'edit_semua', 'hapus', 'hapus_semua'],
        ];

        $permissions = [];
        foreach ($permissionsByCategory as $category => $actions) {
            foreach ($actions as $action) {
                $permissions[] = strtolower("{$action}_" . str_replace(' ', '_', strtolower($category)));
            }
        }

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $rolesWithPermissions = [
            'administrator' => $permissions,
            'komite-mutu' => [
                'lihat_karyawan', 'lihat_pasien', 'lihat_semua_insiden', 'lihat_insiden',
                'lihat_semua_investigasi', 'lihat_investigasi'
            ],
            'pelapor' => [
                'lihat_unit_insiden', 'lihat_pribadi_insiden', 'lihat_insiden', 
                'edit_insiden', 'edit_unit_insiden', 'hapus_insiden', 'hapus_unit_insiden', 'tambah_insiden',
                
                'lihat_investigasi', 'edit_investigasi',
                
                'lihat_pasien', 'edit_pasien', 'tambah_pasien',
                'grading_insiden'
            ]
        ];

        foreach ($rolesWithPermissions as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->givePermissionTo($rolePermissions);
        }
    }
}
