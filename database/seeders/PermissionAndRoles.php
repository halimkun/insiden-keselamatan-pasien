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
                'create_master_data',  // Membuat data master (penanggung biaya, jenis insiden, dll.)
                'view_master_data',    // Melihat data master
                'edit_master_data',    // Mengedit data master
                'delete_master_data',  // Menghapus data master
                
                'create_karyawan',     // Menambah data karyawan
                'view_karyawan',       // Melihat data karyawan
                'edit_karyawan',       // Mengedit data karyawan
                'delete_karyawan',     // Menghapus data karyawan
                
                'manage_roles_permissions',  // Mengatur role dan permission
                'configure_system',    // Mengatur konfigurasi sistem
                
                'view_all_reports',    // Melihat semua laporan insiden
                'edit_all_reports',    // Mengedit semua laporan insiden
                'delete_all_reports',  // Menghapus semua laporan insiden

                'create_report',       // Membuat laporan insiden
                'view_patient_data',   // Melihat data pasien
                'edit_patient_data',   // Mengedit data pasien
                'delete_patient_data', // Menghapus data pasien
            ],
            'komite-mutu' => [
                'view_all_reports',          // Melihat semua laporan insiden
                'analyze_reports',           // Menganalisis laporan berdasarkan grading risiko
                'generate_recommendations',  // Memberikan rekomendasi terhadap insiden
                'view_statistics',           // Melihat statistik insiden di seluruh unit
                'view_patient_data',         // Melihat data pasien
            ],
            'direksi' => [
                'view_unit_reports',   // Melihat laporan insiden yang terkait dengan unitnya
                'approve_actions',     // Memberikan persetujuan atau catatan untuk tindakan perbaikan
                'view_statistics',     // Melihat statistik insiden di unitnya
                'view_patient_data',   // Melihat data pasien
            ],
            'pelapor' => [
                'create_report',       // Membuat laporan insiden
                'view_own_reports',    // Melihat laporan yang dibuat oleh dirinya
                'edit_own_reports',    // Mengedit laporan yang dibuat oleh dirinya
                'delete_own_reports',  // Menghapus laporan yang dibuat oleh dirinya (opsional)
                'create_patient_data', // Menambah data pasien
                'view_patient_data',   // Melihat data pasien
                'edit_patient_data',   // Mengedit data pasien
                'delete_patient_data', // Menghapus data pasien
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
