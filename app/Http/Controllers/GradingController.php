<?php

namespace App\Http\Controllers;

use App\Models\Grading;
use App\Models\Insiden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
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
                    'created_by'     => auth()->id(),
                ]);
            } else {
                $grading = Grading::create([
                    'grading_risiko' => $request->grading_risiko,
                    'created_by'     => auth()->id(),
                ]);

                $insiden->grading_id = $grading->id;
                $insiden->save();
            }

            $insiden->pernah_terjadi = $request->pernah_terjadi;
            $insiden->save();

            DB::commit();

            return redirect()->back()->with('success', 'Grading berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan grading: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
