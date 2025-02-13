<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\JabatanRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $jabatans = Jabatan::paginate();

        return view('jabatan.index', compact('jabatans'))
            ->with('i', ($request->input('page', 1) - 1) * $jabatans->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $jabatan = new Jabatan();

        return view('jabatan.create', compact('jabatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JabatanRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['kode'] = \Str::slug($data['nama']);

        Jabatan::create($data);

        return Redirect::route('jabatan.index')
            ->with('success', 'Jabatan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $jabatan = Jabatan::find($id);

        return view('jabatan.show', compact('jabatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $jabatan = Jabatan::find($id);

        return view('jabatan.edit', compact('jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JabatanRequest $request, Jabatan $jabatan): RedirectResponse
    {
        $data = $request->validated();
        $data['kode'] = \Str::slug($data['nama']);

        $jabatan->update($data);

        return Redirect::route('jabatan.index')
            ->with('success', 'Jabatan updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Jabatan::find($id)->delete();

        return Redirect::route('jabatan.index')
            ->with('success', 'Jabatan deleted successfully');
    }
}
