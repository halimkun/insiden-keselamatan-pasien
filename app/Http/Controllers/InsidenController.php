<?php

namespace App\Http\Controllers;

use App\Helpers\TelegramHelper;
use App\Models\Unit;
use App\Models\Grading;
use App\Models\Insiden;
use App\Models\Tindakan;
use Illuminate\View\View;
use App\Models\JenisInsiden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user()->load('detail'); // Load relasi 'detail' dengan lazy eager loading.

        // Inisialisasi query insiden.
        $insidenQuery = Insiden::query();

        // Cek permission pengguna untuk membatasi data insiden berdasarkan unit.
        if ($user->can('lihat_unit_insiden')) {
            $unitId = $user->detail?->unit_id ?? 0; // Default ke 0 jika unit_id null.
            $insidenQuery->where('unit_id', $unitId);
        } else {
            $insidenQuery->orderBy('created_at', 'desc');
        }

        // Paginate hasil query.
        $insidens = $insidenQuery->paginate(10);

        return view('insiden.index', compact('insidens'))->with('i', ($request->input('page', 1) - 1) * $insidens->perPage());
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
            'created_by'    => Auth::id(),
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

                if (!$request->grading_risiko) {
                    $probability = \App\Helpers\InsidenHelper::getProbabilityLevel($request->jenis_insiden_id, $request->unit_id);
                    $impact      = \App\Helpers\InsidenHelper::getImpactLevel($request->dampak_insiden);
                    $riskGrading = \App\Helpers\InsidenHelper::getRiskGrading($probability, $impact);

                    $grading = Grading::create([
                        'grading_risiko' => \App\Helpers\InsidenHelper::riskGradingToColor($riskGrading),
                        'created_by'     => null,
                    ]);

                    $insiden['grading_id'] = $grading->id;
                }

                TelegramHelper::sendMessage("✅", "INSIDEN CREATED", array_merge(
                    $request->has('act') && $request->act == 'tambah' ? [
                        "Pasien"          => $pasienData['nama'] ?? 'N/A',
                        "No. Rekam Medis" => $pasienData['no_rekam_medis'] ?? 'N/A',
                    ] : [],
                    [
                        "Tindakan"        => $tindakanData,
                        "Insiden"         => $insiden,
                    ]
                ));

                Insiden::create($insiden);
            }, 5);
        } catch (\Throwable $th) {
            TelegramHelper::sendMessage("❌", "INSIDEN FAILED", array_merge(
                $request->has('act') && $request->act == 'tambah' ? [
                    "Pasien"          => $pasienData['nama'] ?? 'N/A',
                    "No. Rekam Medis" => $pasienData['no_rekam_medis'] ?? 'N/A',
                ] : [],
                [
                    "Tindakan"        => $tindakanData,
                    "Insiden"         => $insiden,
                ]
            ));

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

        $probability = \App\Helpers\InsidenHelper::getProbabilityLevel($insiden->jenis_insiden_id, $insiden->unit_id);
        $impact = \App\Helpers\InsidenHelper::getImpactLevel($insiden->dampak_insiden);

        $riskGrading = \App\Helpers\InsidenHelper::getRiskGrading($probability, $impact);

        return view('insiden.show', compact('insiden', 'probability', 'impact', 'riskGrading'));
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
            'created_by'    => Auth::id(),
        ]);

        $tindakanData = [
            'tindakan' => $request->tindakan ?? '',
            'oleh'     => $request->oleh,
            'detail'   => $request->oleh == 'tim' ? $request->oleh_tim : ($request->oleh == 'petugas' ? $request->oleh_petugas : null),
        ];

        try {

            $insiden->update($request->except('tindakan', 'oleh', 'oleh_tim', 'oleh_petugas', 'grading_risiko'));

            if (!$insiden->grading) {
                $grading = Grading::create($request->only('grading_risiko', 'created_by'));
                $insiden->grading_id = $grading->id;
                $insiden->save();
            } else {
                $insiden->grading->update($request->only('grading_risiko', 'created_by'));
            }

            if (!$insiden->tindakan) {
                $tindakan = Tindakan::create($tindakanData);
                $insiden->tindakan_id = $tindakan->id;
                $insiden->save();
            } else {
                $insiden->tindakan->update($tindakanData);
            }

            // Kirim log keberhasilan ke Telegram
            TelegramHelper::sendMessage("✅", "INSIDEN UPDATED", [
                "insiden"  => $insiden->toArray(),
                "grading"  => !$insiden->grading ? $grading->toArray() : $insiden->grading->toArray(),
                "tindakan" => !$insiden->tindakan ? $tindakan->toArray() : $insiden->tindakan->toArray(),
            ]);

            return Redirect::route('insiden.index')->with('success', 'Insiden updated successfully');
        } catch (\Exception $e) {
            TelegramHelper::sendMessage("⚠️", "INSIDEN UPDATE FAILED", [
                "insiden"  => $insiden->toArray(),
                "grading"  => !$insiden->grading ? $request->only('grading_risiko', 'created_by') : $insiden->grading->toArray(),
                "tindakan" => !$insiden->tindakan ? $tindakanData : $insiden->tindakan->toArray(),
                "error"    => $e->getMessage(),
            ]);

            return Redirect::route('insiden.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    public function destroy($id): RedirectResponse
    {
        try {
            $insiden = Insiden::find($id);
            $insiden->delete();

            TelegramHelper::sendMessage("❌", "INSIDEN DELETED", [
                "insiden" => $insiden->toArray(),
            ]);
        } catch (\Throwable $th) {
            TelegramHelper::sendMessage("❌", "INSIDEN DELETE FAILED", [
                "insiden" => $insiden->toArray(),
                "error"   => $th->getMessage(),
            ]);

            return Redirect::route('insiden.index')->with('error', 'An error occurred: ' . $th->getMessage());
        }

        return Redirect::route('insiden.index')->with('success', 'Insiden deleted successfully');
    }
}
