<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionAndRoles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // package: spatie/laravel-permission
        $permissionsAndRoles = [
            'administrator' => [
                'hapus_profil',

                'lihat_karyawan',
                'edit_karyawan',
                'hapus_karyawan',
                'tambah_karyawan',
                'ubah_password_karyawan',
                'set_permission_karyawan',

                'lihat_master_data',
                'edit_master_data',
                'hapus_master_data',
                'tambah_master_data',

                'lihat_pasien',
                'edit_pasien',
                'hapus_pasien',
                'tambah_pasien',

                'lihat_semua_insiden',          // Semua insiden
                'lihat_unit_insiden',           // Insiden yang terkait dengan unit tertentu
                'lihat_insiden_pribadi',        // Insiden yang dibuat oleh dirinya
                'lihat_insiden',                // Detail Insiden
                'edit_insiden',
                'hapus_insiden',
                'tambah_insiden',
                'grading_insiden',
            ],
            'komite-mutu' => [
                'lihat_semua_insiden',          // Semua insiden
                'lihat_insiden',                // Detail Insiden
            ],
            'tim-ikp' => [
                'lihat_semua_insiden',          // Semua insiden
                'lihat_insiden',                // Detail Insiden
                'edit_insiden',
                'hapus_insiden',
                'tambah_insiden',
                'grading_insiden',

                'lihat_pasien',
                'edit_pasien',
                'hapus_pasien',
                'tambah_pasien',

                'lihat_master_data',
                'edit_master_data',
                'hapus_master_data',
                'tambah_master_data',
            ],
            'pelapor' => [
                'lihat_unit_insiden',           // Semua insiden
                'lihat_insiden_pribadi',        // Insiden yang dibuat oleh dirinya
                'lihat_insiden',                // Detail Insiden
                'edit_insiden',
                'hapus_insiden',
                'tambah_insiden',
                'tambah_pasien',
            ],
        ];

        foreach ($permissionsAndRoles as $role => $permissions) {
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
            }

            $r = Role::create(['name' => $role]);
            $r->givePermissionTo($permissions);
        }
    }
}
