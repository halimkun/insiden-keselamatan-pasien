<?php

namespace App\Http\Controllers\DataTables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\InvestigasiDataTable;

class InvestigasiController extends Controller
{
    public function index(Request $request, InvestigasiDataTable $dataTable)
    {
        if ($request->ajax()) {
            return $dataTable->ajax();
        } else {
            throw new \Exception('Request must be Ajax');
        }
    }
}
