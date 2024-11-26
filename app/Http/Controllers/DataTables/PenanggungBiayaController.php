<?php

namespace App\Http\Controllers\DataTables;

use App\DataTables\PenanggungBiaya;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenanggungBiayaController extends Controller
{
    public function index(Request $request, PenanggungBiaya $dataTable)
    {
        if ($request->ajax()) {
            return $dataTable->ajax();
        } else {
            throw new \Exception('Request must be Ajax');
        }
    }
}
