<?php

namespace App\Http\Controllers\DataTables;

use App\DataTables\JenisInsiden;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JenisInsidenController extends Controller
{
    public function index(Request $request, JenisInsiden $dataTable)
    {
        if ($request->ajax()) {
            return $dataTable->ajax();
        } else {
            throw new \Exception('Request must be Ajax');
        }
    }
}
