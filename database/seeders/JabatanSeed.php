<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatans = [
            "Direktur",
            "Wakil Direktur",
            "Manajer",
            "Asisten Manajer",
            "Dokter",
            "Dokter Spesialis",
            "Bidan",
            "Apoteker",
            "Asisten Apoteker",
            
            "Satpam/Penjaga Malam",

            "Ketua Komite Mutu",
            "Komite Mutu"
        ];

        foreach ($jabatans as $jabatan) {
            \App\Models\Jabatan::create([
                'kode' => \Str::slug($jabatan),
                'nama' => $jabatan,
                'deskripsi' => "Jabatan $jabatan"
            ]);
        }

        $units = \App\Models\Unit::all();
        foreach ($units as $key => $value) {
            $jabatan = \App\Models\Jabatan::where('nama', "Kepala Unit $value->nama_unit")->first();
            if (!$jabatan) {
                \App\Models\Jabatan::create([
                    'kode'      => \Str::slug("Kepala Unit $value->nama_unit"),
                    'nama'      => "Kepala Unit $value->nama_unit",
                    'deskripsi' => "Jabatan Kepala Unit $value->nama_unit"
                ]);
            }
        }
    }
}
