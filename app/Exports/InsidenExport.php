<?php

namespace App\Exports;

use App\Models\Insiden;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InsidenExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $user = auth()->user();
        $data = Insiden::with(['oleh', 'pasien.penanggungBiaya', 'jenis', 'unit', 'tindakan', 'grading.oleh', 'penerima']);

        if ($user->can('lihat_semua_insiden')) {
            $data = $data->get();
        } elseif ($user->can('lihat_unit_insiden')) {
            $data = $data->where('unit_id', $user->detail->unit_id)->get();
        } else {
            $data = $data->where('created_by', $user->id)->get();
        }

        $finalData = $data->map(function ($item, $index) {
            return [
                "No"                          => $index + 1,
                "Nama Pasien"                 => $item->pasien->nama,
                "Nomor Rekam Medis"           => $item->pasien->no_rekam_medis,
                "Tanggal Lahir"               => $item->pasien->tanggal_lahir,
                "Jenis Kelamin"               => $item->pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
                "Usia"                        => $item->pasien->tanggal_lahir->age . " Tahun",
                "Penanggung Biaya"            => $item->pasien->penanggungBiaya->jenis_penanggung,

                "Tanggal Masuk Pasien"        => $item->tgl_pasien_masuk->format('d-m-Y'),
                "Tanggal Insiden"             => $item->tanggal_insiden->format('d-m-Y') . " " . $item->waktu_insiden,
                "Insiden"                     => $item->insiden,
                "Jenis Insiden"               => $item->jenis->nama_jenis_insiden,
                "Kronologi"                   => $item->kronologi,
                "Yang Melaporkan"             => $item->jenis_pelapor_lainnya ? $item->jenis_pelapor_lainnya : $item->jenis_pelapor,
                "Korban"                      => $item->korban_insiden_lainnya ? $item->korban_insiden_lainnya : $item->korban_insiden,
                "Insiden Menyangkut Pasien"   => \Str::upper($item->layanan_insiden_lainnya ? $item->layanan_insiden_lainnya : $item->layanan_insiden),
                "Insiden terjadi pada pasien" => $item->kasus_insiden_lainnya ? $item->kasus_insiden_lainnya : $item->kasus_insiden,

                "Tempat Terjadinya Insiden"   => $item->tempat_kejadian,
                "Unit"                        => $item->unit->nama_unit,
                "Dampak Terhadap Pasien"      => $item->dampak_insiden,

                "Tindakan"                    => $item->tindakan?->tindakan ?? "-",
                "Tindakan Oleh"               => $item->tindakan?->oleh ?? "-",
                "Penindak Detail"             => $item->tindakan?->detail ?? "-",

                "Grading"                     => $item->grading?->grading_risiko ?? "-",
                "Grading Oleh"                => $item->grading?->oleh?->name ?? "-",

                "Investigasi Sederhana"       => $item->investigasi_sederhana,

                "Pembuat Laporan"             => $item->oleh->name,
                "Status Pelapor"              => $item->status_pelapor,

                "Laporan Diterima Oleh"       => $item->penerima?->name ?? "-",
                "Tanggal Laporan Diterima"    => $item->received_at?->format('d-m-Y') ?? "-",
            ];
        });

        return $finalData;
    }

    /**
     * @return array
     */
    public function headings(): array {
        return [
            "No", "Nama Pasien", "Nomor Rekam Medis", "Tanggal Lahir", "Jenis Kelamin", "Usia", "Penanggung Biaya",
            "Tanggal Masuk Pasien", "Tanggal Insiden", "Insiden Terjadi", "Jenis Insiden", "Kronologi", "Yang Melaporkan", "Korban", "Insiden Menyangkut Pasien", "Insiden terjadi pada pasien",
            "Tempat Terjadinya Insiden", "Unit", "Dampak Terhadap Pasien",
            "Tindakan", "Tindakan Oleh", "Penindak Detail",
            "Grading", "Grading Oleh",
            "Investigasi Sederhana",
            "Pembuat Laporan", "Status Pelapor",
            "Laporan Diterima Oleh", "Tanggal Laporan Diterima",
        ];
    }
}
