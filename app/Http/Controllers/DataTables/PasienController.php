<?php

namespace App\Http\Controllers\DataTables;

use Illuminate\Http\Request;
use App\DataTables\Pasien;
use App\Http\Controllers\Controller;

class PasienController extends Controller
{
    public function index(Request $request, Pasien $dataTable)
    {
        if ($request->ajax()) {
            return $dataTable->ajax();
        } else {
            throw new \Exception('Request must be Ajax');
        }
    }
}
