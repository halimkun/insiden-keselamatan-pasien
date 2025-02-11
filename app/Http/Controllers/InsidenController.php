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

        $insiden      = new Insiden();
        $jenisInsiden = JenisInsiden::all();
        $units        = Unit::all();
        $karyawan     = \App\Models\User::all();

        return view('insiden.create', compact('insiden', 'jenisInsiden', 'units', 'pasien', 'karyawan'));
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
        $units        = Unit::all();
        $insiden      = Insiden::with(['pasien', 'tindakan', 'grading'])->find($id);
        $jenisInsiden = JenisInsiden::all();
        $karyawan     = \App\Models\User::all();

        return view('insiden.edit', compact('insiden', 'jenisInsiden', 'units', 'karyawan'));
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

        // validasi created_sign is valid image base64
        if ($request->has('created_sign') && !preg_match('/^data:image\/(\w+);base64,/', $request->created_sign)) {
            return Redirect::back()->with('error', 'Tanda tangan pembuat insiden tidak valid');
        }


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

    /**
     * Remove the specified resource from storage.
     */
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

    /**
     * Get insiden terkait by jenis insiden id and unit id.
     */
    public function getInsidenTerkait(Request $request)
    {
        $request->validate([
            'jenis_insiden_id' => 'required|exists:jenis_insiden,id',
            'unit_id'          => 'nullable|exists:unit,id',
        ]);

        $insiden = \App\Helpers\InsidenHelper::getOtherUnitIncident($request->jenis_insiden_id, $request->unit_id, true);

        if ($insiden > 0) {
            $html = "
                <details class='collapse bg-base-200 collapse-arrow'>
                    <summary class='collapse-title text-lg font-medium px-6'>Insiden di unit lain dengan jenis insiden yang sama ( " . \App\Helpers\InsidenHelper::getJenisIncidenById($request->jenis_insiden_id) . " )</summary>
                    <div class='collapse-content'>
                        <div class='max-h-[250px] overflow-y-auto'>
                            " . \App\Helpers\InsidenHelper::getOtherUnitIncident($request->jenis_insiden_id, $request->unit_id) . "
                        </div>
                    </div>
                </details>
            ";
        } else {
            $html = "<p class='text-center text-lg font-medium'>Tidak ada insiden terkait</p>";
        }

        return response()->json([
            'pernah_terjadi_unit_lain' => $insiden,
            'html'                     => $html,
        ]);
    }

    public function ttd(Request $request, Insiden $insiden): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'type' => 'required|string',
            'ttd'  => 'required',
        ]);

        try {
            $type = $request->input('type');
            $sign_base64 = $request->input('ttd');

            // update insiden type is penerima dan pembuat,
            // jika type penerima, maka update received_by, received_sign, received_at
            // jika type pembuat, maka update created_by, created_sign

            if ($type == 'penerima') {
                $insiden->received_by   = Auth::id();
                $insiden->received_sign = $sign_base64;
                $insiden->received_at   = now();
            } else {
                $insiden->created_by = Auth::id();
                $insiden->created_sign = $sign_base64;
            }

            $insiden->save();

            TelegramHelper::sendMessage("✅", "INSIDEN TTD", [
                "insiden" => $insiden->toArray(),
                "type"    => $type,
            ]);

            return response()->json(['success' => true, 'message' => 'Tanda tangan berhasil disimpan', 'data' => $insiden]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function pdf(Request $request, int $insiden)
    {
        $insiden = Insiden::with(['oleh', 'pasien', 'jenis', 'unit', 'tindakan', 'grading.user'])->find($insiden);

        if ($insiden && $insiden->pernah_terjadi) {
            $terkait = Insiden::with(['tindakan'])
                ->where('jenis_insiden_id', $insiden->jenis_insiden_id)
                ->where('unit_id', '!=', $insiden->unit_id)
                ->orderBy('created_at', 'desc')
                ->limit(3)->get();
        }

        $probability = \App\Helpers\InsidenHelper::getProbabilityLevel($insiden->jenis_insiden_id, $insiden->unit_id);
        $impact = \App\Helpers\InsidenHelper::getImpactLevel($insiden->dampak_insiden);

        $riskGrading = \App\Helpers\InsidenHelper::getRiskGrading($probability, $impact);

        // $html = view('insiden.pdf', [
        //     'insiden'     => $insiden,
        //     'probability' => $probability,
        //     'impact'      => $impact,
        //     'riskGrading' => $riskGrading,
        //     'terkait'     => $terkait ?? null,
        // ])->render();

        // save created_sign and received_sign from $insiden to storage
        $insiden->created_sign = $this->saveBase64ImageSign($insiden->created_sign, 'created_sign_' . $insiden->id);
        $insiden->received_sign = $this->saveBase64ImageSign($insiden->received_sign, 'received_sign_' . $insiden->id);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('insiden.pdf', [
            'insiden'     => $insiden,
            'probability' => $probability,
            'impact'      => $impact,
            'riskGrading' => $riskGrading,
            'terkait'     => $terkait ?? null,
        ]);

        return $pdf->stream('insiden.pdf');
    }

    public function print(Request $request, int $insiden): View
    {
        $insiden = Insiden::with(['oleh', 'pasien', 'jenis', 'unit', 'tindakan', 'grading.user'])->find($insiden);

        if ($insiden && $insiden->pernah_terjadi) {
            $terkait = Insiden::with(['tindakan'])
                ->where('jenis_insiden_id', $insiden->jenis_insiden_id)
                ->where('unit_id', '!=', $insiden->unit_id)
                ->orderBy('created_at', 'desc')
                ->limit(3)->get();
        }

        $probability = \App\Helpers\InsidenHelper::getProbabilityLevel($insiden->jenis_insiden_id, $insiden->unit_id);
        $impact = \App\Helpers\InsidenHelper::getImpactLevel($insiden->dampak_insiden);

        $riskGrading = \App\Helpers\InsidenHelper::getRiskGrading($probability, $impact);

        return view('insiden.print', [
            'insiden'     => $insiden,
            'probability' => $probability,
            'impact'      => $impact,
            'riskGrading' => $riskGrading,
            'terkait'     => $terkait ?? null,
        ]);
    }

    function saveBase64ImageSign($base64String, $filename)
    {
        // Pisahkan metadata Base64
        list($type, $base64Data) = explode(';', $base64String);
        list(, $base64Data) = explode(',', $base64Data);
        $imageData = base64_decode($base64Data);

        // Tentukan ekstensi berdasarkan format Base64
        $extension = str_replace('data:image/', '', $type);

        // Buat nama file unik
        $fileName = 'images/sign/' . $filename . '.' . $extension;

        // check if folder not exists, create folder
        if (!file_exists(public_path('images/sign'))) {
            mkdir(public_path('images/sign'), 0777, true);
        }

        // Simpan ke Storage (dalam /public/images/sign 
        file_put_contents(public_path($fileName), $imageData);

        return $fileName; // Path untuk database
    }
}
