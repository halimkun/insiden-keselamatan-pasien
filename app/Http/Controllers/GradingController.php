<?php

namespace App\Http\Controllers;

use App\Helpers\InsidenHelper;
use App\Models\Grading;
use App\Models\Insiden;
use Illuminate\Http\Request;
use App\Helpers\TelegramHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GradingController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'insiden_id'     => 'required|exists:insiden,id',
            'grading_risiko' => 'required|in:hijau,biru,kuning,merah',
            'pernah_terjadi' => 'required|boolean',
        ]);

        try {
            DB::beginTransaction();

            $insiden = Insiden::find($request->insiden_id);

            if (!$insiden) {
                return redirect()->back()->with('error', 'Insiden tidak ditemukan');
            }

            if ($insiden->grading) {
                $insiden->grading->update([
                    'grading_risiko' => $request->grading_risiko,
                    'created_by'     => Auth::id(),
                ]);
            } else {
                $grading = Grading::create([
                    'grading_risiko' => $request->grading_risiko,
                    'created_by'     => Auth::id(),
                ]);

                $insiden->grading_id = $grading->id;
                $insiden->save();
            }

            $insiden->pernah_terjadi = $request->pernah_terjadi;
            $insiden->save();

            DB::commit();

            TelegramHelper::sendMessage('✅', $insiden->grading ? 'GRADING UPDATED' : 'GRADING CREATED', [
                'insiden' => $insiden->toArray(),
                'grading' => $insiden->grading ? $insiden->grading->toArray() : $request->except("_token"),
            ]);

            return redirect()->back()->with('success', 'Grading berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();

            TelegramHelper::sendMessage('❌', 'GRADING ACTION FAILED', [
                'request' => $request->except("_token"),
                'error'   => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan grading: ' . $e->getMessage());
        }
    }

    /**
     * Get grading component.
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function getGradingByData(Request $request)
    {
        $request->validate([
            'unit_id'     => 'required|exists:unit,id',
            'jenis_id'    => 'required|exists:jenis_insiden,id',
            'impact'      => 'required|string|in:tidak signifikan,minor,moderat,mayor,katastropik',
        ]);

        $probabilitas = InsidenHelper::getProbabilityLevel($request->jenis_id, $request->unit_id);
        $impact       = InsidenHelper::getImpactLevel($request->impact);
        $riskGrading  = InsidenHelper::getRiskGrading($probabilitas, $impact);

        $html = view('components.grading-info', [
            'title'            => 'Auto Grading System',
            'riskGrading'      => $riskGrading,
            'jenis_insiden_id' => $request->jenis_id,
            'unit_id'          => $request->unit_id,
        ])->with('slot', '<p class="text-sm font-base">Berdasarkan data yang telah diinput (jenis insiden, unit, dan dampak insiden). <br>Sistem memberikan grading insiden ini sebagai <span class="font-bold underline capitalize grading-text">' . \App\Helpers\InsidenHelper::riskGradingToColor($riskGrading) . '</span>.</p>')->render();

        return response()->json([
            'html'  => $html,
            'color' => \App\Helpers\InsidenHelper::riskGradingToColor($riskGrading),
        ]);
    }

    /**
     * Display the specified resource.
     * 
     * @param string $id
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param string $id
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param string $id
     */
    public function destroy(string $id)
    {
        //
    }
}
