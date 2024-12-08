<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PasienRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $pasiens = Pasien::paginate();

        return view('pasien.index', compact('pasiens'))
            ->with('i', ($request->input('page', 1) - 1) * $pasiens->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $pasien = new Pasien();
        $penanggungBiaya = \App\Models\PenanggungBiaya::orderBy('jenis_penanggung', 'asc')->get();

        return view('pasien.create', compact('pasien', 'penanggungBiaya'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PasienRequest $request): RedirectResponse
    {
        Pasien::create($request->validated());

        return Redirect::route('pasien.index')
            ->with('success', 'Pasien created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $pasien = Pasien::with('penanggungBiaya')->find($id);

        return view('pasien.show', compact('pasien'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $pasien = Pasien::find($id);
        $penanggungBiaya = \App\Models\PenanggungBiaya::orderBy('jenis_penanggung', 'asc')->get();

        return view('pasien.edit', compact('pasien', 'penanggungBiaya'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PasienRequest $request, Pasien $pasien): RedirectResponse
    {
        $pasien->update($request->validated());

        return Redirect::route('pasien.index')
            ->with('success', 'Pasien updated successfully');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id, Request $request): RedirectResponse
    {
        // validate the request
        $user = Pasien::onlyTrashed()->find($id);
        if ($user) {
            $user->restore();
            return Redirect::route('pasien.index')
                ->with('success', 'User restored successfully');
        }

        return Redirect::route('pasien.index')
            ->with('error', 'User not found');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        Pasien::find($id)->delete();

        return Redirect::route('pasien.index')
            ->with('success', 'Pasien deleted successfully');
    }
}
