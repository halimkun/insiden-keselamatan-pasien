<?php

namespace App\Http\Controllers\DataTables;

use Illuminate\Http\Request;
use App\DataTables\Unit;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{
    public function index(Request $request, Unit $dataTable)
    {
        if ($request->ajax()) {
            return $dataTable->ajax();
        } else {
            throw new \Exception('Request must be Ajax');
        }
    }
}
