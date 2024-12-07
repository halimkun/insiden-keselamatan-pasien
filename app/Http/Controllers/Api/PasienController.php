<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PasienController extends Controller
{
    public function search(Request $request)
    {
        if (!$request->has('keyword')) {
            return response()->json([
                'message' => 'Parameter keyword tidak ditemukan'
            ], 422);
        }

        if (empty($request->keyword)) {
            return response()->json([]);
        }

        $keyword = $request->keyword;

        $pasiens = \App\Models\Pasien::where('nama', 'like', '%' . $keyword . '%')
            ->orWhere('nik', 'like', '%' . $keyword . '%')
            ->orWhere('no_rekam_medis', 'like', '%' . $keyword . '%')
            ->get();

        return response()->json($pasiens);
    }
}