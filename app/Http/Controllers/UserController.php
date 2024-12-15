<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // $this->middleware("permission:view_karyawan")->only(["index", "show"]);
        // $this->middleware("permission:create_karyawan")->only(["create", "store"]);
        // $this->middleware("permission:edit_karyawan")->only(["edit", "update", "restore"]);
        // $this->middleware("permission:delete_karyawan")->only(["destroy"]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $user = new User();
        $units = Unit::all();

        return view('user.create', compact('user', 'units'))->with('isCreate', true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $d                      = $request->only('name', 'user', 'username', 'email');
        $d['email_verified_at'] = now();
        $d['password']          = \Illuminate\Support\Facades\Hash::make('password');
        $d['remember_token']    = \Illuminate\Support\Str::random(10);
        
        $user = User::create($d);

        $detail = [
            'user_id'    => $user->id,
            'jabatan'    => $request->jabatan,
            'unit_id'    => $request->unit,
            'departemen' => $request->departemen,
            'no_hp'      => $request->no_hp,
        ];

        // update or create user detail
        \App\Models\UserDetail::updateOrCreate(
            ['user_id' => $user->id],
            $detail
        );

        return Redirect::route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $user = User::find($id);

        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $user = User::find($id);
        $units = Unit::all();

        return view('user.edit', compact('user', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->only('name', 'user', 'email'));

        $detail = [
            'user_id'    => $user->id,
            'jabatan'    => $request->jabatan,
            'unit_id'    => $request->unit,
            'departemen' => $request->departemen,
            'no_hp'      => $request->no_hp,
        ];

        // update or create user detail
        \App\Models\UserDetail::updateOrCreate(
            ['user_id' => $user->id],
            $detail
        );

        return Redirect::route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id, Request $request): RedirectResponse
    {
        // validate the request
        $user = User::onlyTrashed()->find($id);
        if ($user) {
            $user->restore();
            return Redirect::route('users.index')
                ->with('success', 'User restored successfully');
        }

        return Redirect::route('users.index')
            ->with('error', 'User not found');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $user = User::find($id);

        // has role admin
        if ($user->hasRole(['admin', 'administrator'])) {
            $anotherAdmin = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin')->orWhere('name', 'administrator');
            })->where('id', '!=', $id)->count();

            if ($anotherAdmin < 1) {
                return Redirect::route('users.index')
                    ->with('error', 'Cannot delete ' . $user->name . ' (Administator), Because there is no another admin');
            }
        }

        User::find($id)->delete();

        return Redirect::route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
