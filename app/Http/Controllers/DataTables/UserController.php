<?php

namespace App\Http\Controllers\DataTables;

use App\DataTables\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Blade;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request, User $dataTable)
    {
        if ($request->ajax()) {
            return $dataTable->ajax();
        } else {
            throw new \Exception('Request must be Ajax');
        }
    }
}
