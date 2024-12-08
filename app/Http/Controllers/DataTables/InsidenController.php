<?php

namespace App\Http\Controllers\DataTables;

use App\DataTables\Insiden;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InsidenController extends Controller
{
    public function index(Request $request, Insiden $dataTable)
    {
        if ($request->ajax()) {
            return $dataTable->ajax();
        } else {
            throw new \Exception('Request must be Ajax');
        }
    }
}
