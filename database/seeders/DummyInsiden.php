<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use GeminiAPI\Laravel\Facades\Gemini;
use Illuminate\Database\Seeder;

class DummyInsiden extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "insiden"                => "Salah pemberian obat pada pasien",
                "kronologi"              => "Perawat memberikan obat tanpa mengecek label nama pasien, sehingga pasien A menerima obat pasien B.",
                "jenis_insiden_alias"    => "KTC",
                "tempat_kejadian"        => "Ruang rawat inap",
                "tindakan_pasca_insiden" => "Dilakukan evaluasi SOP pemberian obat, pelatihan ulang untuk staf, dan revisi sistem label obat pasien."
            ],
            [
                "insiden"                => "Pasien jatuh dari tempat tidur",
                "kronologi"              => "Pasien berusaha turun sendiri dari tempat tidur tanpa pengawasan, karena tombol panggil tidak berfungsi.",
                "jenis_insiden_alias"    => "KTD",
                "tempat_kejadian"        => "Ruang ICU",
                "tindakan_pasca_insiden" => "Perbaikan tombol panggil, penambahan staf jaga malam, dan pemasangan pagar pengaman tempat tidur."
            ],
            [
                "insiden"                => "Operasi pada sisi tubuh yang salah",
                "kronologi"              => "Tim bedah tidak melakukan verifikasi sisi tubuh yang akan dioperasi sebelum prosedur dimulai.",
                "jenis_insiden_alias"    => "SENTINEL",
                "tempat_kejadian"        => "Ruang operasi",
                "tindakan_pasca_insiden" => "Implementasi checklist WHO surgical safety, briefing wajib tim sebelum operasi, dan audit rutin SOP."
            ],
            [
                "insiden"                => "Salah diagnosis laboratorium",
                "kronologi"              => "Spesimen pasien tercampur dengan pasien lain di laboratorium.",
                "jenis_insiden_alias"    => "KNC",
                "tempat_kejadian"        => "Laboratorium diagnostik",
                "tindakan_pasca_insiden" => "Pelabelan ulang spesimen, pengenalan barcode otomatis, dan pelatihan tata kelola spesimen."
            ],
            [
                "insiden"                => "Alat bantu napas gagal berfungsi saat darurat",
                "kronologi"              => "Ventilator tidak diperiksa secara rutin, sehingga rusak ketika pasien membutuhkannya.",
                "jenis_insiden_alias"    => "SENTINEL",
                "tempat_kejadian"        => "Ruang ICU",
                "tindakan_pasca_insiden" => "Audit rutin perangkat medis dan pelatihan teknis kepada teknisi peralatan kesehatan."
            ],
            [
                "insiden"                => "Salah pemberian transfusi darah",
                "kronologi"              => "Darah diberikan tanpa konfirmasi golongan darah pasien.",
                "jenis_insiden_alias"    => "SENTINEL",
                "tempat_kejadian"        => "Unit transfusi darah",
                "tindakan_pasca_insiden" => "SOP baru dengan dua kali verifikasi sebelum transfusi dan penggunaan sistem identifikasi elektronik."
            ],
            [
                "insiden"                => "Luka bakar akibat cairan panas",
                "kronologi"              => "Air panas untuk kompres tidak diperiksa suhunya, sehingga menyebabkan luka bakar pada pasien.",
                "jenis_insiden_alias"    => "KTD",
                "tempat_kejadian"        => "Ruang perawatan luka",
                "tindakan_pasca_insiden" => "Standarisasi penggunaan alat pengukur suhu air dan edukasi ulang kepada perawat."
            ],
            [
                "insiden"                => "Pasien alergi obat mendapat obat yang memicu reaksi",
                "kronologi"              => "Riwayat alergi pasien tidak tercatat dalam sistem elektronik rumah sakit.",
                "jenis_insiden_alias"    => "KTD",
                "tempat_kejadian"        => "Instalasi farmasi",
                "tindakan_pasca_insiden" => "Update sistem elektronik dengan riwayat alergi wajib, dan sosialisasi pentingnya konfirmasi alergi."
            ],
            [
                "insiden"                => "Bayi tertukar di ruang bersalin",
                "kronologi"              => "Staf tidak memberikan label identifikasi pada bayi segera setelah lahir.",
                "jenis_insiden_alias"    => "SENTINEL",
                "tempat_kejadian"        => "Ruang bersalin",
                "tindakan_pasca_insiden" => "Implementasi label bayi segera setelah lahir dan pengawasan ketat oleh supervisor."
            ],
            [
                "insiden"                => "Infeksi luka pasca operasi",
                "kronologi"              => "Prosedur sterilisasi alat bedah tidak dilakukan sesuai standar.",
                "jenis_insiden_alias"    => "KTD",
                "tempat_kejadian"        => "Ruang bedah",
                "tindakan_pasca_insiden" => "Evaluasi prosedur sterilisasi, pembelian alat sterilisasi baru, dan inspeksi ketat alat-alat medis."
            ],
            [
                "insiden"                => "Salah pemasangan alat infus",
                "kronologi"              => "Perawat memasang alat infus di tangan pasien tanpa memastikan lokasi pembuluh darah yang tepat, sehingga menyebabkan pembengkakan.",
                "jenis_insiden_alias"    => "KTD",
                "tempat_kejadian"        => "Ruang rawat inap",
                "tindakan_pasca_insiden" => "Pelatihan ulang prosedur pemasangan infus dan penambahan pengawasan oleh supervisor."
            ],
            [
                "insiden"                => "Kesalahan dosis obat",
                "kronologi"              => "Pasien anak-anak diberikan dosis obat dewasa akibat kesalahan input resep di sistem.",
                "jenis_insiden_alias"    => "SENTINEL",
                "tempat_kejadian"        => "Apotek rumah sakit",
                "tindakan_pasca_insiden" => "Revisi sistem elektronik dengan fitur peringatan dosis dan edukasi ulang kepada petugas farmasi."
            ],
            [
                "insiden"                => "Terjadinya kebakaran kecil di ruang operasi",
                "kronologi"              => "Alat listrik di ruang operasi mengalami korsleting saat digunakan, menyebabkan percikan api.",
                "jenis_insiden_alias"    => "KPC",
                "tempat_kejadian"        => "Ruang operasi",
                "tindakan_pasca_insiden" => "Pemeriksaan berkala peralatan listrik dan pelatihan evakuasi untuk tim operasi."
            ],
            [
                "insiden"                => "Pasien terlambat mendapatkan tindakan darurat",
                "kronologi"              => "Pasien mengalami serangan jantung, namun tim medis terlambat tiba karena kesalahan komunikasi antar unit.",
                "jenis_insiden_alias"    => "SENTINEL",
                "tempat_kejadian"        => "Unit gawat darurat",
                "tindakan_pasca_insiden" => "Optimalisasi sistem komunikasi darurat dan simulasi rutin untuk respons cepat."
            ],
            [
                "insiden"                => "Pasien salah mendapatkan makanan",
                "kronologi"              => "Pasien diabetes diberi makanan tinggi gula akibat kesalahan daftar diet di dapur rumah sakit.",
                "jenis_insiden_alias"    => "KTC",
                "tempat_kejadian"        => "Dapur rumah sakit",
                "tindakan_pasca_insiden" => "Peningkatan sistem pencatatan diet pasien dan sosialisasi kepada staf dapur."
            ],
            [
                "insiden"                => "Terjadinya reaksi alergi akibat bahan perban",
                "kronologi"              => "Pasien dengan riwayat alergi lateks mengalami ruam setelah luka diperban dengan bahan lateks.",
                "jenis_insiden_alias"    => "KTD",
                "tempat_kejadian"        => "Ruang perawatan luka",
                "tindakan_pasca_insiden" => "Pengadaan bahan perban bebas lateks dan pencatatan alergi pada semua pasien."
            ],
            [
                "insiden"                => "Pasien tidak mendapatkan pemeriksaan sesuai jadwal",
                "kronologi"              => "Kesalahan jadwal di sistem informasi menyebabkan pasien menunggu lebih dari 5 jam untuk pemeriksaan CT scan.",
                "jenis_insiden_alias"    => "KTD",
                "tempat_kejadian"        => "Unit radiologi",
                "tindakan_pasca_insiden" => "Optimalisasi sistem manajemen jadwal pasien dan pengawasan administratif."
            ],
            [
                "insiden"                => "Kesalahan pemberian injeksi",
                "kronologi"              => "Pasien menerima injeksi intramuskular di lokasi yang salah, menyebabkan rasa sakit berkepanjangan.",
                "jenis_insiden_alias"    => "KTD",
                "tempat_kejadian"        => "Ruang rawat inap",
                "tindakan_pasca_insiden" => "Edukasi ulang kepada perawat dan pengawasan ketat pemberian injeksi."
            ],
            [
                "insiden"                => "Pasien mengalami cedera saat pemindahan",
                "kronologi"              => "Pasien mengalami memar saat dipindahkan dari tempat tidur ke kursi roda akibat kurangnya koordinasi tim.",
                "jenis_insiden_alias"    => "KTD",
                "tempat_kejadian"        => "Ruang perawatan",
                "tindakan_pasca_insiden" => "Pelatihan teknik pemindahan pasien yang aman untuk semua staf."
            ],
            [
                "insiden"                => "Pasien tidak diberi informasi lengkap tentang prosedur",
                "kronologi"              => "Pasien menolak tindakan medis karena tidak diberi penjelasan yang memadai tentang risiko dan manfaatnya.",
                "jenis_insiden_alias"    => "KPC",
                "tempat_kejadian"        => "Poliklinik bedah",
                "tindakan_pasca_insiden" => "Edukasi staf medis untuk memberikan informed consent secara lengkap kepada pasien."
            ]
        ];

        $kasusInsiden = [
            'Penyakit Dalam dan Subspesialiasinya',
            'Anak dan Subspesialiasinya',
            'Bedah dan Subspesialiasinya',
            'Obstetri Gynekologi dan Subspesialiasinya',
            'THT dan Subspesialiasinya',
            'Mata dan Subspesialiasinya',
            'Safar dan Subspesialiasinya',
            'Anastesi dan Subspesialiasinya',
            'Kulit & Kelamin dan Subspesialiasinya',
            'Jantung dan Subspesialiasinya',
            'Paru Dalam dan Subspesialiasinya',
            'Jiwa Dalam dan Subspesialiasinya',
            'Orthopedi Dalam dan Subspesialiasinya'
        ];

        $faker = \Faker\Factory::create('id_ID');

        foreach ($data as $item) {
            // Pasien baru
            $pasien = \App\Models\Pasien::create([
                'nama'           => $faker->name,
                'nik'            => $faker->nik ?? null,
                'no_rekam_medis' => $faker->unique()->randomNumber(8),
                'tempat_lahir'   => $faker->city,
                'tanggal_lahir'  => $faker->date('Y-m-d'),
                'jenis_kelamin'  => $faker->randomElement(['L', 'P']),
                'no_telp'        => $faker->phoneNumber,
                'email'          => $faker->email,
                'alamat'         => $faker->address,
            ]);

            // Tindakan Pasca Insiden
            $tindakanOleh = $faker->randomElement(['dokter', 'perawat', 'tim', 'petugas']);
            $tindakan = \App\Models\Tindakan::create([
                'tindakan' => $item['tindakan_pasca_insiden'],
                'oleh'     => $tindakanOleh,
                'detail'   => in_array($tindakanOleh, ['tim', 'petugas']) ? $faker->name : null,
            ]);

            // Jenis Insiden
            $jenisInsiden = \App\Models\JenisInsiden::where('alias', $item['jenis_insiden_alias'])->first();

            // Masuk Pasien
            $masukPasie = $faker->dateTimeBetween('2024-07-01', 'now');

            $insiden = [
                "pasien_id"               => $pasien->id,
                'tgl_pasien_masuk'        => $masukPasie->format('Y-m-d'),
                "jenis_insiden_id"        => $jenisInsiden->id,
                "tanggal_insiden"         => $faker->dateTimeBetween($masukPasie, (clone $masukPasie)->modify('+5 days'))->format('Y-m-d'),
                "waktu_insiden"           => $faker->time(),
                "insiden"                 => $item['insiden'],
                "kronologi"               => $item['kronologi'],
                "jenis_pelapor"           => $faker->randomElement(['karyawan', 'pengunjung', 'pasien', 'keluarga']),
                "jenis_pelapor_lainnya"   => null,
                "korban_insiden"          => 'pasien',
                "korban_insiden_lainnya"  => null,
                "layanan_insiden"         => $faker->randomElement(['ranap', 'ralan', 'ugd']),
                "layanan_insiden_lainnya" => null,
                "kasus_insiden"           => $faker->randomElement($kasusInsiden),
                "kasus_insiden_lainnya"   => null,
                "tempat_kejadian"         => $item['tempat_kejadian'],
                "unit_id"                 => \App\Models\Unit::all()->random()->id,
                "dampak_insiden"          => $item['jenis_insiden_alias'] == 'SENTINEL' ? 'mayor' : $faker->randomElement(['minor', 'moderat']),
                "tindakan_id"             => $tindakan->id,
                "pernah_terjadi"          => $faker->randomElement([0, 1]),
                "status_pelapor"          => $faker->randomElement(['Penemu Insiden', 'Terlibat Langsung']),
                "grading_id"              => null,
                "created_by"              => \App\Models\User::permission('tambah_insiden')->get()->random()->id,
            ];

            try {
                $investigasi_sederhana = Gemini::generateText("Saya ingin anda mejadi seorang yang pandai analisa kejadian dan insiden, anda juga seorang tim komite mutu yang pandai dalam membuat analisa. saya ingin anda membuat investigasi sederhana terkait insiden keselamatan pasien, hindari penggunaan informasi yang berlebihan dan informasi sensitif seperti id, password dan yang lain,. penggunaan informasi dasar seperti nama, nomor rekam medis tanggal lahir tidak masalah. buat hanya investigasi sederhana saja, tidak diperlukan pengulangan detail seperti detail pasien, dan detail insiden, berikut ini data insiden yang perlu anda investigasi: " . json_encode($insiden) . ", dan ini adalah detail pasien yang terlibat: " . json_encode($pasien) . ", data data tersebut saya memerlukan hal berikut ini, investigasi sederhana dalam 1-3 paragraf, rekomendasi, tindakan perbaikan bila diperlukan dan kesimpulan investigasi. terima kasih.");
                $insiden['investigasi_sederhana'] = $investigasi_sederhana;
            } catch (\Throwable $th) {
                $insiden['investigasi_sederhana'] = "-";
            }

            // Insiden
            $insiden = \App\Models\Insiden::create($insiden);
        }
    }
}
