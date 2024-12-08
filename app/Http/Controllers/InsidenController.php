<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Grading;
use App\Models\Insiden;
use App\Models\Tindakan;
use Illuminate\View\View;
use App\Models\JenisInsiden;
use Illuminate\Http\Request;
use App\Http\Requests\InsidenRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class InsidenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $insidens = Insiden::paginate();

        return view('insiden.index', compact('insidens'))
            ->with('i', ($request->input('page', 1) - 1) * $insidens->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View | RedirectResponse
    {
        // if in request not has query string, add default query string is step = 1
        if (! $request->has('step')) {
            return Redirect::route('insiden.create', ['step' => 1]);
        }

        $pasien = null;

        if ($request->has('pasien') && $request->step == 1) {
            try {
                $pkode = base64_decode(base64_decode($request->pasien));
                if (!$pkode) {
                    return Redirect::route('insiden.create', ['step' => 1])->with('error', 'Pasien tidak valid, pastikan pilih pasien yang benar');
                }
            } catch (\Exception $e) {
                return Redirect::route('insiden.create', ['step' => 1])->with('error', 'Pasien tidak valid');
            }
        }

        // if has step and step is 2 and has pasien
        if ($request->has('pasien') && $request->step == 2) {
            try {
                $pkode = base64_decode(base64_decode($request->pasien));
                if (!$pkode) {
                    return Redirect::route('insiden.create', ['step' => 1])->with('error', 'Pasien tidak valid, pastikan pilih pasien yang benar');
                }

                $pasien = \App\Models\Pasien::where('no_rekam_medis', $pkode)->first();
                if (!$pasien) {
                    return Redirect::route('insiden.create', ['step' => 1])->with('error', 'Pasien tidak valid, pastikan pilih pasien yang benar');
                }
            } catch (\Exception $e) {
                return Redirect::route('insiden.create', ['step' => 1])->with('error', 'Pasien tidak valid');
            }
        }

        $insiden = new Insiden();
        $jenisInsiden = JenisInsiden::all();
        $units = Unit::all();

        return view('insiden.create', compact('insiden', 'jenisInsiden', 'units', 'pasien'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InsidenRequest $request)
    {
        $request->merge([
            'kasus_insiden' => implode(', ', $request->kasus_insiden),
            'created_by'    => auth()->user()->id,
        ]);

        $pasienData = [];
        if ($request->has('act') && $request->act == 'tambah') {
            $request->validate([
                'no_rekam_medis' => 'unique:pasien,no_rekam_medis',
            ]);

            $pasienData = [
                'nama'           => $request->nama,
                'nik'            => $request->nik ?? null,
                'no_rekam_medis' => $request->no_rekam_medis,
                'tempat_lahir'   => $request->tempat_lahir,
                'tanggal_lahir'  => $request->tanggal_lahir,
                'jenis_kelamin'  => $request->jenis_kelamin,
                'no_telp'        => $request->no_telp ?? null,
                'email'          => $request->email ?? null,
                'alamat'         => $request->alamat ?? null,
            ];
        }
        
        $tindakanData = [
            'tindakan' => $request->tindakan ?? '',
            'oleh'     => $request->oleh,
            'detail'   => $request->oleh == 'tim' ? $request->oleh_tim : ($request->oleh == 'petugas' ? $request->oleh_petugas : null),
        ];

        $insiden = $request->except(array_merge(array_keys($pasienData), ['tindakan', 'oleh', 'oleh_tim', 'oleh_petugas', 'act', 'grading_risiko']));

        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($request, $pasienData, $tindakanData, $insiden) {
                if ($request->has('act') && $request->act == 'tambah') {
                    $pasien = \App\Models\Pasien::create($pasienData);
                    $insiden['pasien_id'] = $pasien->id;
                } else {
                    $insiden['pasien_id'] = $request->pasien_id;
                }
                
                $tindakan = Tindakan::create($tindakanData);
                $insiden['tindakan_id'] = $tindakan->id;

                $grading = Grading::create($request->only('grading_risiko', 'created_by'));
                $insiden['grading_id'] = $grading->id;

                Insiden::create($insiden);
            },5 );
        } catch (\Throwable $th) {
            return Redirect::back()->with('error', 'Gagal menyimpan data insiden : ' . $th->getMessage())->withInput();
        }

        return Redirect::route('insiden.index')->with('success', 'Insiden created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $insiden = Insiden::with(['oleh', 'pasien', 'jenis', 'unit', 'tindakan', 'grading.user'])->find($id);

        return view('insiden.show', compact('insiden'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $units = Unit::all();
        $insiden = Insiden::with(['pasien', 'tindakan'])->find($id);
        $jenisInsiden = JenisInsiden::all();

        return view('insiden.edit', compact('insiden', 'jenisInsiden', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InsidenRequest $request, Insiden $insiden): RedirectResponse
    {
        $request->merge([
            'kasus_insiden' => implode(', ', $request->kasus_insiden),
            'created_by'    => auth()->user()->id,
        ]);
        
        $tindakanData = [
            'tindakan' => $request->tindakan ?? '',
            'oleh'     => $request->oleh,
            'detail'   => $request->oleh == 'tim' ? $request->oleh_tim : ($request->oleh == 'petugas' ? $request->oleh_petugas : null),
        ];
        
        $insiden->update($request->except('tindakan', 'oleh', 'oleh_tim', 'oleh_petugas', 'grading_risiko'));

        $insiden->grading->update($request->only('grading_risiko', 'created_by'));
        
        $insiden->tindakan->update($tindakanData);

        return Redirect::route('insiden.index')
            ->with('success', 'Insiden updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Insiden::find($id)->delete();

        return Redirect::route('insiden.index')
            ->with('success', 'Insiden deleted successfully');
    }
}
