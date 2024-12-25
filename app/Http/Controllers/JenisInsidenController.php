<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\JenisInsiden;
use Illuminate\Http\Request;
use App\Helpers\TelegramHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\JenisInsidenRequest;

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
        try {
            $jenisInsiden = JenisInsiden::create($request->validated());

            // Send Telegram message
            TelegramHelper::sendMessage('✅', 'JENIS INSIDEN CREATED', $jenisInsiden->toArray());
            return Redirect::route('jenis-insiden.index')->with('success', 'Jenis Insiden created successfully.');
        } catch (\Exception $e) {
            TelegramHelper::sendMessage('⚠️', 'JENIS INSIDEN CREATE', ['request' => $request->validated(), 'error' => $e->getMessage()]);
            return Redirect::route('jenis-insiden.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
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
        try {
            $jenisInsiden->update($request->validated());

            // Send Telegram message
            TelegramHelper::sendMessage('✅', 'JENIS INSIDEN UPDATED', $jenisInsiden->toArray());
            return Redirect::route('jenis-insiden.index')->with('success', 'Jenis Insiden updated successfully');
        } catch (\Exception $e) {
            TelegramHelper::sendMessage('⚠️', 'JENIS INSIDEN UPDATE', ['id' => $jenisInsiden->id, 'request' => $request->validated(), 'error' => $e->getMessage()]);
            return Redirect::route('jenis-insiden.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            // Prevent deletion as per the logic you mentioned
            // return redirect()->back()->with('error', 'Jenis Insiden tidak bisa untuk dihapus');
            throw new \Exception('Jenis Insiden tidak bisa untuk dihapus');

            // Optional, if you plan to implement the deletion logic in the future
            // JenisInsiden::find($id)->delete();

            // Send Telegram message
            TelegramHelper::sendMessage('✅', 'JENIS INSIDEN DELETED', ['id' => $id]);
            return Redirect::route('jenis-insiden.index')->with('success', 'Jenis Insiden deleted successfully');
        } catch (\Exception $e) {
            // Send error message to Telegram
            TelegramHelper::sendMessage('⚠️', 'JENIS INSIDEN DELETE', ['id' => $id, 'error' => $e->getMessage()]);
            return Redirect::route('jenis-insiden.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
