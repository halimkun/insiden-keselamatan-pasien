<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\UnitRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Helpers\TelegramHelper;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $units = Unit::paginate();

        return view('unit.index', compact('units'))
            ->with('i', ($request->input('page', 1) - 1) * $units->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $unit = new Unit();

        return view('unit.create', compact('unit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitRequest $request): RedirectResponse
    {
        try {
            $finddedData = Unit::withTrashed()->where($request->validated())->first();
            if ($finddedData) {
                $finddedData->restore();
                TelegramHelper::sendMessage('✅', 'UNIT RESTORED', $finddedData->toArray());
                return redirect()->route('unit.index')->with('success', 'Unit sudah ada, data berhasil di restore');
            } else {
                $unit = Unit::create($request->validated());
                TelegramHelper::sendMessage('✅', 'UNIT CREATED', $unit->toArray());
                return Redirect::route('unit.index')->with('success', 'Unit created successfully.');
            }
        } catch (\Exception $e) {
            TelegramHelper::sendMessage('⚠️', 'UNIT CREATE', ['request' => $request->validated(), 'error' => $e->getMessage()]);
            return Redirect::route('unit.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $unit = Unit::find($id);

        return view('unit.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $unit = Unit::find($id);

        return view('unit.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnitRequest $request, Unit $unit): RedirectResponse
    {
        try {
            $unit->update($request->validated());
            TelegramHelper::sendMessage('✅', 'UNIT UPDATED', $unit->toArray());
            return Redirect::route('unit.index')->with('success', 'Unit updated successfully');
        } catch (\Exception $e) {
            TelegramHelper::sendMessage('⚠️', 'UNIT UPDATE', ['id' => $unit->id, 'request' => $request->validated(), 'error' => $e->getMessage()]);
            return Redirect::route('unit.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $unit = Unit::find($id);
            $unit->delete();
            TelegramHelper::sendMessage('✅', 'UNIT DELETED', ['id' => $id, 'unit' => $unit]);
            return Redirect::route('unit.index')->with('success', 'Unit deleted successfully');
        } catch (\Exception $e) {
            TelegramHelper::sendMessage('⚠️', 'UNIT DELETE', ['id' => $id, 'error' => $e->getMessage()]);
            return Redirect::route('unit.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
