<?php

namespace App\Http\Controllers;

use App\Models\PenanggungBiaya;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PenanggungBiayaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PenanggungBiayaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $penanggungBiayas = PenanggungBiaya::paginate();

        return view('penanggung-biaya.index', compact('penanggungBiayas'))
            ->with('i', ($request->input('page', 1) - 1) * $penanggungBiayas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $penanggungBiaya = new PenanggungBiaya();

        return view('penanggung-biaya.create', compact('penanggungBiaya'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PenanggungBiayaRequest $request): RedirectResponse
    {
        PenanggungBiaya::create($request->validated());

        return Redirect::route('penanggung-biaya.index')
            ->with('success', 'PenanggungBiaya created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $penanggungBiaya = PenanggungBiaya::find($id);

        return view('penanggung-biaya.show', compact('penanggungBiaya'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $penanggungBiaya = PenanggungBiaya::find($id);

        return view('penanggung-biaya.edit', compact('penanggungBiaya'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PenanggungBiayaRequest $request, PenanggungBiaya $penanggungBiaya): RedirectResponse
    {
        $penanggungBiaya->update($request->validated());

        return Redirect::route('penanggung-biaya.index')
            ->with('success', 'PenanggungBiaya updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        PenanggungBiaya::find($id)->delete();

        return Redirect::route('penanggung-biaya.index')
            ->with('success', 'PenanggungBiaya deleted successfully');
    }
}
