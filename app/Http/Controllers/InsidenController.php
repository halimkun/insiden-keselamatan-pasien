<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Insiden;
use Illuminate\View\View;
use App\Models\JenisInsiden;
use Illuminate\Http\Request;
use App\Http\Requests\InsidenRequest;
use App\Models\Tindakan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class InsidenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $insidens = Insiden::paginate();

        return view('insiden.index', compact('insidens'))
            ->with('i', ($request->input('page', 1) - 1) * $insidens->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $insiden = new Insiden();
        $jenisInsiden = JenisInsiden::all();
        $units = Unit::all();

        return view('insiden.create', compact('insiden', 'jenisInsiden', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InsidenRequest $request): RedirectResponse
    {
        // implode array kasus_insiden
        $request->merge(['kasus_insiden' => implode(', ', $request->kasus_insiden)]);
        $insiden = Insiden::create($request->except('tindakan', 'oleh', 'oleh_tim', 'oleh_petugas'));

        $tindakanData = [
            'tindakan' => $request->tindakan ?? '',
            'oleh'     => $request->oleh == 'tim' ? $request->oleh_tim : ($request->oleh == 'petugas' ? $request->oleh_petugas : $request->oleh),
        ];

        $tindakan = Tindakan::create($tindakanData);

        $insiden->update(['tindakan_id' => $tindakan->id]);

        return Redirect::route('insiden.index')
            ->with('success', 'Insiden created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $insiden = Insiden::find($id);

        return view('insiden.show', compact('insiden'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $insiden = Insiden::find($id);
        $jenisInsiden = JenisInsiden::all();
        $units = Unit::all();

        return view('insiden.edit', compact('insiden', 'jenisInsiden', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InsidenRequest $request, Insiden $insiden): RedirectResponse
    {
        $insiden->update($request->validated());

        return Redirect::route('insiden.index')
            ->with('success', 'Insiden updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Insiden::find($id)->delete();

        return Redirect::route('insiden.index')
            ->with('success', 'Insiden deleted successfully');
    }
}
