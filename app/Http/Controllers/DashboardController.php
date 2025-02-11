<?php

namespace App\Http\Controllers;

use App\Models\Insiden;
use Illuminate\Http\Request;
use App\Helpers\CustomHelper;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $default_grading_key = ['biru', 'hijau', 'kuning', 'merah'];

    public function index(Request $request)
    {
        $year = $request->get('year') ?? now()->year;

        $trendData = $this->getTrendData($year);
        $gradingCount = $this->getGradingCount($year);
        $jenisInsiden = $this->getInsidenByJenis($year);

        return view('dashboard', [
            'trendData'         => $trendData,
            'gradingCount'      => $gradingCount,
            'jenisInsiden'      => $jenisInsiden,
            'year'              => $year,
        ]);
    }

    protected function getInsidenByJenis($year = null)
    {
        // Tentukan tahun yang digunakan, default ke tahun sekarang jika null
        $year = $year ?? now()->year;

        // Ambil data jenis insiden, dan gunakan 'alias' sebagai key
        $jenisInsiden = \App\Models\JenisInsiden::all(); // Menggunakan alias sebagai key

        // Ambil data insiden yang dikelompokkan berdasarkan jenis_insiden_id dan hitung jumlahnya
        $insidenCountByJenis = Insiden::with('jenis')->selectRaw('jenis_insiden_id, COUNT(*) as total')
            ->whereYear('tanggal_insiden', $year) // Filter berdasarkan tahun
            ->groupBy('jenis_insiden_id'); // Kelompokkan berdasarkan jenis_insiden_id
        
        if (Auth::user()->can('lihat_semua_insiden')) {
            $insidenCountByJenis = $insidenCountByJenis;
        } else if (Auth::user()->can('lihat_unit_insiden')) {
            $insidenCountByJenis->where('unit_id', Auth::user()->unit_id)->orWhere('created_by', Auth::id());
        } else {
            $insidenCountByJenis->where('created_by', Auth::id());
        }
        
        $insidenCountByJenis = $insidenCountByJenis->get(); // Ambil hasilnya

        // Kembalikan hasil sebagai koleksi untuk mempermudah manipulasi
        $insidenCount = $insidenCountByJenis->mapWithKeys(function ($item) {
            return [$item->jenis->alias => $item->total];
        });


        // Gabungkan dengan data jenis insiden, tambahkan 0 jika tidak ada data insiden untuk jenis tersebut
        $result = $jenisInsiden->mapWithKeys(function ($jenis) use ($insidenCount) {
            // Jika data insiden tidak ada, maka akan diisi dengan 0
            return [$jenis->alias => [
                'count' => $insidenCount->get($jenis->alias, 0),
                'name' => $jenis->nama_jenis_insiden,
            ]];
        });

        return $result;
    }


    protected function getGradingCount($year = null)
    {
        // Ambil data dan kelompokkan berdasarkan grading risiko (non-case-sensitive)
        $groupedInsiden = Insiden::with('grading')
            ->whereYear('tanggal_insiden', $year ?? now()->year);

        if (Auth::user()->can('lihat_semua_insiden')) {
            $groupedInsiden = $groupedInsiden;
        } else if (Auth::user()->can('lihat_unit_insiden')) {
            $groupedInsiden->where('unit_id', Auth::user()->unit_id)->orWhere('created_by', Auth::id());
        } else {
            $groupedInsiden->where('created_by', Auth::id());
        }

        $groupedInsiden = $groupedInsiden->get()
            ->groupBy(fn($item) => strtolower($item->grading->grading_risiko ?? ''));

        // Jika tidak ada data, langsung kembalikan hasil default
        if ($groupedInsiden->isEmpty()) {
            return collect($this->default_grading_key)
                ->mapWithKeys(fn($key) => [$key => 0])
                ->merge(['belum di grading' => 0]);
        }

        // Hitung jumlah insiden berdasarkan grading risiko
        $groupedInsidenCount = $groupedInsiden->map(fn($group) => $group->count());

        // Inisialisasi hasil dengan default grading key
        $result = collect($this->default_grading_key)
            ->mapWithKeys(fn($key) => [$key => 0]);

        // Tambahkan grading yang tidak ada dalam default grading key ke "belum di grading"
        $otherGrading = $groupedInsidenCount->filter(fn($count, $key) => !in_array($key, $this->default_grading_key));
        $groupedInsidenCount = $groupedInsidenCount
            ->filter(fn($count, $key) => in_array($key, $this->default_grading_key))
            ->merge(['belum di grading' => $otherGrading->sum()]);

        // Gabungkan hasil akhir
        return $result->merge($groupedInsidenCount);
    }

    protected function getTrendData($year = null)
    {
        // Gunakan tahun saat ini jika $year null
        $year = $year ?? now()->year;

        $data = Insiden::selectRaw('MONTH(tanggal_insiden) as month, COUNT(*) as count')
            ->whereYear('tanggal_insiden', $year)
            ->groupBy('month')
            ->orderBy('month');

        if (Auth::user()->can('lihat_semua_insiden')) {
            $data = $data;
        } else if (Auth::user()->can('lihat_unit_insiden')) {
            $data->where('unit_id', Auth::user()->unit_id)->orWhere('created_by', Auth::id());
        } else {
            $data->where('created_by', Auth::id());
        }

        $data = $data->get()
            ->mapWithKeys(function ($item) {
                return [CustomHelper::getShortMonthName($item->month) => $item->count];
            })->toArray();

        // Ambil data insiden berdasarkan bulan untuk tahun yang dipilih
        return $data;
    }
}
