<?php

namespace App\Http\Controllers;

use App\Helpers\TelegramHelper;
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

        return view('pasien.index', compact('pasiens'))->with('i', ($request->input('page', 1) - 1) * $pasiens->perPage());
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
        try {
            $pasien = Pasien::create($request->validated());

            TelegramHelper::sendMessage('✅', 'PASIEN CREATED', $pasien->toArray());
        } catch (\Throwable $th) {
            TelegramHelper::sendMessage('❌', 'PASIEN CREATE FAILED', [
                'request' => $request->validated(),
                'error'   => $th->getMessage()
            ]);

            return Redirect::route('pasien.index')->with('error', 'An error occurred: ' . $th->getMessage());
        }

        return Redirect::route('pasien.index')->with('success', 'Pasien created successfully.');
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
        try {
            $pasien->update($request->validated());

            TelegramHelper::sendMessage('✅', 'PASIEN UPDATED', $pasien->toArray());
        } catch (\Throwable $th) {
            TelegramHelper::sendMessage('❌', 'PASIEN UPDATE FAILED', [
                'request' => $request->validated(),
                'error'   => $th->getMessage()
            ]);

            return Redirect::route('pasien.index')->with('error', 'An error occurred: ' . $th->getMessage());
        }

        return Redirect::route('pasien.index')
            ->with('success', 'Pasien updated successfully');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id, Request $request): RedirectResponse
    {
        try {
            $pasien = Pasien::onlyTrashed()->find($id);
            $pasien->restore();

            TelegramHelper::sendMessage('✅', 'PASIEN RESTORED', $pasien->toArray());
        } catch (\Throwable $th) {
            TelegramHelper::sendMessage('❌', 'PASIEN RESTORE FAILED', [
                'request' => $request->all(),
                'error'   => $th->getMessage()
            ]);

            return Redirect::route('pasien.index')->with('error', 'An error occurred: ' . $th->getMessage());
        }
        
        return Redirect::route('pasien.index')->with('error', 'User not found');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $pasien = Pasien::find($id);
            $pasien->delete();

            TelegramHelper::sendMessage('✅', 'PASIEN DELETED', ['id' => $id, 'pasien' => $pasien]);
        } catch (\Throwable $th) {
            TelegramHelper::sendMessage('❌', 'PASIEN DELETE FAILED', ['id' => $id, 'error' => $th->getMessage()]);

            return Redirect::route('pasien.index')->with('error', 'An error occurred: ' . $th->getMessage());
        }

        return Redirect::route('pasien.index')
            ->with('success', 'Pasien deleted successfully');
    }
}
