<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Helpers\TelegramHelper;
use App\Models\PenanggungBiaya;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PenanggungBiayaRequest;

class PenanggungBiayaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $penanggungBiayas = PenanggungBiaya::paginate();

        return view('penanggung-biaya.index', compact('penanggungBiayas'))->with('i', ($request->input('page', 1) - 1) * $penanggungBiayas->perPage());
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
        try {
            $penanggungBiaya = PenanggungBiaya::create($request->validated());

            // Send Telegram message
            TelegramHelper::sendMessage('✅', 'PENANGGUNG BIAYA CREATED', $penanggungBiaya->toArray());
            return Redirect::route('penanggung-biaya.index')->with('success', 'Penanggung Biaya created successfully.');
        } catch (\Exception $e) {
            TelegramHelper::sendMessage('❌', 'PENANGGUNG BIAYA CREATE FAILED', ['request' => $request->validated(), 'error' => $e->getMessage()]);
            return Redirect::route('penanggung-biaya.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
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
        try {
            $penanggungBiaya->update($request->validated());

            // Send Telegram message
            TelegramHelper::sendMessage('✅', 'PENANGGUNG BIAYA UPDATED', $penanggungBiaya->toArray());
            return Redirect::route('penanggung-biaya.index')->with('success', 'Penanggung Biaya updated successfully');
        } catch (\Exception $e) {
            TelegramHelper::sendMessage('❌', 'PENANGGUNG BIAYA UPDATE FAILED', ['id' => $penanggungBiaya->id, 'request' => $request->validated(), 'error' => $e->getMessage()]);
            return Redirect::route('penanggung-biaya.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $pb = PenanggungBiaya::find($id);
            $pb->delete();

            // Send Telegram message
            TelegramHelper::sendMessage('✅', 'PENANGGUNG BIAYA DELETED', ['id' => $id, 'penanggung_biaya' => $pb->toArray()]);
            return Redirect::route('penanggung-biaya.index')->with('success', 'Penanggung Biaya deleted successfully');
        } catch (\Exception $e) {
            TelegramHelper::sendMessage('❌', 'PENANGGUNG BIAYA DELETE FAILED', ['id' => $id, 'error' => $e->getMessage()]);
            return Redirect::route('penanggung-biaya.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
