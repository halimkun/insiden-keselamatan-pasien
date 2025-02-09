<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Insiden;
use Illuminate\View\View;
use App\Models\Investigasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\InvestigasiRequest;

class InvestigasiController extends Controller
{
    protected $jenisJangkaWaktu = ['pendek', 'menengah', 'panjang'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $investigasis = Investigasi::with(['insiden', 'grading'])->latest()->paginate(5);

        return view('investigasi.index', compact('investigasis'))
            ->with('i', ($request->input('page', 1) - 1) * $investigasis->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Insiden $insiden): View
    {
        $investigasi = new Investigasi();
        $insiden     = $insiden->load(['jenis', 'pasien']);
        $karyawan    = User::all();

        return view('investigasi.create', compact('investigasi', 'insiden', 'karyawan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Insiden $insiden, InvestigasiRequest $request): RedirectResponse
    {
        $investigasiData = collect($request->validated())->except('grading')->merge(['insiden_id' => $insiden->id])->toArray();
        $gradingData     = collect($request->validated())->only('grading')->merge(['created_by' => Auth::user()->id])->toArray();
        $rekomendasiData = collect($request->all())->except(array_keys($investigasiData))->except(array_keys($gradingData))->except('_token')->toArray();

        $rekomendasiRules = [];
        foreach ($this->jenisJangkaWaktu as $key) {
            $rekomendasiRules["rekomendasi_{$key}"] = 'required|string';
            $rekomendasiRules["pj_{$key}"]          = 'required|exists:users,id';
            $rekomendasiRules["batas_waktu_{$key}"] = 'required|date';
        }

        $request->validate($rekomendasiRules);
        $rekomendasiDataValidated = collect($rekomendasiData)->only(array_keys($rekomendasiRules))->toArray();

        try {
            DB::transaction(function () use ($investigasiData, $gradingData, $rekomendasiDataValidated) {
                $grading = \App\Models\Grading::create($gradingData);

                $investigasiData = array_merge($investigasiData, ['grading_id' => $grading->id]);
                $investigasi = \App\Models\Investigasi::create($investigasiData);

                $jangkaWaktuList = ['pendek', 'menengah', 'panjang'];

                $rekomendasiData = array_map(function ($jangka) use ($rekomendasiDataValidated, $investigasi) {
                    return [
                        'investigasi_id' => $investigasi->id,
                        'rekomendasi'    => $rekomendasiDataValidated["rekomendasi_$jangka"] ?? null,
                        'jangka_waktu'   => $jangka,
                        'batas_waktu'    => $rekomendasiDataValidated["batas_waktu_$jangka"] ?? null,
                        'pj'             => $rekomendasiDataValidated["pj_$jangka"] ?? null,
                    ];
                }, $jangkaWaktuList);

                // Simpan ke database (bisa pakai insert untuk banyak data sekaligus)
                \App\Models\Rekomendasi::insert($rekomendasiData);
            }, 3);
        } catch (\Throwable $th) {
            return Redirect::back()->with('error', 'Investigasi failed to create. -- ' . $th->getMessage())->withInput();
        }

        return Redirect::route('investigasi.index')->with('success', 'Investigasi created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Insiden $insiden, $id): View
    {
        $investigasi = Investigasi::with(['grading', 'rekomendasi'])->find($id);
        $insiden     = $insiden->load(['jenis', 'pasien']);

        return view('investigasi.show', compact('investigasi', 'insiden'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Insiden $insiden, $id): View
    {
        $investigasi = Investigasi::with(['grading', 'rekomendasi'])->find($id);
        $insiden     = $insiden->load(['jenis', 'pasien']);
        $karyawan   = User::all();
        
        return view('investigasi.edit', compact('investigasi', 'insiden', 'karyawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvestigasiRequest $request, Insiden $insiden, Investigasi $investigasi): RedirectResponse
    {
        $investigasiData = collect($request->validated())->except('grading')->merge(['insiden_id' => $insiden->id])->toArray();
        $gradingData     = collect($request->validated())->only('grading')->merge(['created_by' => Auth::user()->id])->toArray();
        $rekomendasiData = collect($request->all())->except(array_keys($investigasiData))->except(array_keys($gradingData))->except(['_token', '_method'])->toArray();

        $rekomendasiRules = [];
        foreach ($this->jenisJangkaWaktu as $key) {
            $rekomendasiRules["rekomendasi_{$key}"] = 'required|string';
            $rekomendasiRules["pj_{$key}"]          = 'required|exists:users,id';
            $rekomendasiRules["batas_waktu_{$key}"] = 'required|date';
        }

        $request->validate($rekomendasiRules);
        $rekomendasiDataValidated = collect($rekomendasiData)->only(array_keys($rekomendasiRules))->toArray();

        try {
            DB::transaction(function () use ($investigasi, $investigasiData, $gradingData, $rekomendasiDataValidated) {
                $grading = \App\Models\Grading::updateOrCreate(['id' => $investigasi->grading_id], $gradingData);
                
                $investigasiData = array_merge($investigasiData, ['grading_id' => $grading->id]);
                $investigasi = \App\Models\Investigasi::updateOrCreate(['id' => $investigasi->id], $investigasiData);

                $jangkaWaktuList = ['pendek', 'menengah', 'panjang'];

                $rekomendasiData = array_map(function ($jangka) use ($rekomendasiDataValidated, $investigasi) {
                    return [
                        'investigasi_id' => $investigasi->id,
                        'rekomendasi'    => $rekomendasiDataValidated["rekomendasi_$jangka"] ?? null,
                        'jangka_waktu'   => $jangka,
                        'batas_waktu'    => $rekomendasiDataValidated["batas_waktu_$jangka"] ?? null,
                        'pj'             => $rekomendasiDataValidated["pj_$jangka"] ?? null,
                    ];
                }, $jangkaWaktuList);

                // Simpan ke database (bisa pakai insert untuk banyak data sekaligus)
                \App\Models\Rekomendasi::where('investigasi_id', $investigasi->id)->delete();
                \App\Models\Rekomendasi::insert($rekomendasiData);
            }, 3);
        } catch (\Throwable $th) {
            return Redirect::back()->with('error', 'Investigasi failed to create. -- ' . $th->getMessage())->withInput();
        }

        return Redirect::route('investigasi.index')
            ->with('success', 'Investigasi updated successfully');
    }

    public function destroy(Insiden $insiden, $id): RedirectResponse
    {
        Investigasi::where('id', $id)->where('insiden_id', $insiden->id)->delete();

        return Redirect::route('investigasi.index')->with('success', 'Investigasi deleted successfully');
    }
}
