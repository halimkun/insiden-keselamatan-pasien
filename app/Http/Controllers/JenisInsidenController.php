<?php

namespace App\Http\Controllers;

use App\Models\JenisInsiden;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\JenisInsidenRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class JenisInsidenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $jenisInsidens = JenisInsiden::paginate();

        return view('jenis-insiden.index', compact('jenisInsidens'))
            ->with('i', ($request->input('page', 1) - 1) * $jenisInsidens->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $jenisInsiden = new JenisInsiden();

        return view('jenis-insiden.create', compact('jenisInsiden'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JenisInsidenRequest $request): RedirectResponse
    {
        JenisInsiden::create($request->validated());

        return Redirect::route('jenis-insiden.index')
            ->with('success', 'JenisInsiden created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $jenisInsiden = JenisInsiden::find($id);

        return view('jenis-insiden.show', compact('jenisInsiden'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $jenisInsiden = JenisInsiden::find($id);

        return view('jenis-insiden.edit', compact('jenisInsiden'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JenisInsidenRequest $request, JenisInsiden $jenisInsiden): RedirectResponse
    {
        $jenisInsiden->update($request->validated());

        return Redirect::route('jenis-insiden.index')
            ->with('success', 'JenisInsiden updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        JenisInsiden::find($id)->delete();

        return Redirect::route('jenis-insiden.index')
            ->with('success', 'JenisInsiden deleted successfully');
    }
}
