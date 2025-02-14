<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('settings.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'site_name'        => 'required|string|max:255',
            'site_description' => 'required|string|max:255',
            
            'faskes_name'      => 'required|string|max:255',
            'faskes_address'   => 'required|string|max:255',

            'site_logo'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $logo = $request->file('site_logo');

        // save settings data
        $settings = [
            'site_name'        => $request->site_name,
            'site_description' => $request->site_description,
            
            'faskes_name'      => $request->faskes_name,
            'faskes_address'   => $request->faskes_address,
        ];

        // model update
        $setting = new \App\Models\Settings();

        foreach ($settings as $key => $value) {
            $setting->where('key', $key)->update(['value' => $value]);
        }

        // logo handle
        if ($logo) {
            // Ambil setting logo lama hanya sekali
            $oldLogoSetting = $setting->where('key', 'site_logo')->first();
        
            if ($oldLogoSetting) {
                $oldLogo = $oldLogoSetting->value;
        
                if ($oldLogo && $oldLogo !== 'logo.png') {
                    $oldLogoName = basename($oldLogo);
                    \Storage::disk('public')->delete('images/' . $oldLogoName);
                }
            }
        
            // Simpan logo baru
            $logoName = time() . '.' . $logo->extension();
            $logoPath = $logo->storeAs('images', $logoName, 'public');
        
            // Update setting dengan path baru
            $setting->where('key', 'site_logo')->update(['value' => 'storage/' . $logoPath]);
        }        

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
