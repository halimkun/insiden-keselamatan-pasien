<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\User;
use App\Models\Jabatan;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Helpers\TelegramHelper;
use App\Http\Requests\UserRequest;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @return View
     */
    public function create(): View
    {
        $user     = new User();
        $units    = Unit::all();
        $jabatans = Jabatan::all();

        return view('user.create', compact('user', 'units', 'jabatans'))->with('isCreate', true);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $data                      = $request->only('name', 'user', 'username', 'email');
        $data['email_verified_at'] = now();
        $data['password']          = \Illuminate\Support\Facades\Hash::make('password');
        $data['remember_token']    = \Illuminate\Support\Str::random(10);

        $detail = [
            'jabatan_id'    => $request->jabatan_id,
            'unit_id'    => $request->unit,
            'departemen' => $request->departemen,
            'no_hp'      => $request->no_hp,
        ];

        try {
            $user = User::create($data);
            $user->assignRole('pelapor');

            $detail['user_id'] = $user->id;

            $detail = \App\Models\UserDetail::updateOrCreate(
                ['user_id' => $user->id],
                $detail
            );

            TelegramHelper::sendMessage("✅", "USER CREATED", [
                "user"   => $user->makeHidden('id')->toArray(),
                "detail" => $detail->makeHidden(['id', 'user_id'])->toArray()
            ]);
        } catch (\Throwable $th) {
            TelegramHelper::sendMessage("❌", "USER CREATED FAILED", [
                "user"   => $data,
                "detail" => $detail,
                "error"  => $th->getMessage()
            ]);

            return Redirect::route('users.index')->with('error', 'User created failed');
        }

        return Redirect::route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     * 
     * @param int $id
     * @return View
     */
    public function show($id): View
    {
        $user = User::find($id);

        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param int $id
     * @return View
     */
    public function edit($id): View
    {
        $user     = User::find($id);
        $units    = Unit::all();
        $jabatans = Jabatan::all();

        return view('user.edit', compact('user', 'units', 'jabatans'));
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param int $user
     * @return View
     */
    public function roles(int $userId)
    {
        $roles       = \Spatie\Permission\Models\Role::with('permissions')->get();
        $permissions = \Spatie\Permission\Models\Permission::all();

        $user       = User::with(['roles', 'permissions'])->find($userId);

        return view('user.set-roles', compact('user', 'roles', 'permissions'));
    }

    /**
     * Set permission to user
     * 
     * @param Request $request
     * @param int $userId
     * 
     * @return RedirectResponse
     */
    public function setRoles(Request $request, int $userId)
    {
        $user = User::find($userId);
        $roles = \Spatie\Permission\Models\Role::whereIn('id', $request->roles)->get();

        try {
            $user->syncPermissions([]);
            $user->syncRoles($roles->pluck('name')->toArray());

            TelegramHelper::sendMessage("✅", "ROLES AND PERMISSIONS UPDATED", [
                "user"  => $user->makeHidden('id')->toArray(),
                "roles" => $roles->makeHidden('id')->toArray()
            ], [
                "Aksi ini akan menghapus semua permission yang sudah ada sebelumnya",
                "Permission yang dihapus akan di gantikan dengan permission baru",
                "Permission baru sesuai dengan role yang di pilih"
            ]);
        } catch (\Throwable $th) {
            TelegramHelper::sendMessage("❌", "ROLES AND PERMISSIONS UPDATED FAILED", [
                "user"  => $user->makeHidden('id')->toArray(),
                "roles" => $roles->makeHidden('id')->toArray(),
                "error" => $th->getMessage()
            ]);

            return Redirect::route('users.index')->with('error', 'Roles and permissions updated failed');
        }

        return Redirect::route('users.index')->with('success', 'Roles and permissions updated successfully');
    }

    /**
     * Set permission to user
     * 
     * @param Request $request
     * @param int $userId
     * 
     * @return RedirectResponse
     */
    public function setPermission(Request $request, int $userId)
    {
        $user = User::find($userId);
        $permissions = \Spatie\Permission\Models\Permission::whereIn('id', $request->permissions)->get();

        try {
            $user->syncRoles([]);

            $user->syncPermissions($permissions->pluck('name')->toArray());

            TelegramHelper::sendMessage("✅", "PERMISSIONS UPDATED", [
                "user"        => $user->makeHidden('id')->toArray(),
                "permissions" => $permissions->makeHidden('id')->toArray()
            ], [
                "Aksi ini akan menghapus semua role yang sudah ada sebelumnya",
                "Pengguna akan kehilangan semua role yang sudah di berikan sebelumnya",
                "Role yang dihapus akan di gantikan dengan permission yang di pilih",
            ]);
        } catch (\Throwable $th) {
            TelegramHelper::sendMessage("❌", "PERMISSIONS UPDATED FAILED", [
                "user"        => $user->makeHidden('id')->toArray(),
                "permissions" => $permissions->makeHidden('id')->toArray(),
                "error"       => $th->getMessage()
            ]);

            return Redirect::route('users.index')->with('error', 'Roles and permissions updated failed');
        }

        return Redirect::route('users.index')->with('success', 'Roles and permissions updated successfully');
    }

    /**
     * Set password to user
     * 
     * @param Request $request
     * @param int $userId
     * 
     * @return RedirectResponse
     */
    public function setPassword(Request $request, int $userId)
    {
        $request->validate([
            'password'              => 'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8',
        ]);

        $user = User::find($userId);

        if (!$user) {
            return Redirect::route('users.index')->with('error', 'User not found');
        }

        try {
            $user->update([
                'password' => \Illuminate\Support\Facades\Hash::make($request->password)
            ]);

            TelegramHelper::sendMessage("✅", "PASSWORD UPDATED", [
                "user" => $user->only('name', 'username', 'email')
            ]);
        } catch (\Throwable $th) {
            TelegramHelper::sendMessage("❌", "PASSWORD UPDATED FAILED", [
                "user"  => $user->only('name', 'username', 'email'),
                "error" => $th->getMessage()
            ]);

            return Redirect::route('users.index')->with('error', 'Password updated failed');
        }

        return Redirect::route('users.index')->with('success', 'Password updated and user logged out successfully');
    }


    /**
     * Update the specified resource in storage.
     * 
     * @param UserRequest $request
     * @param User $user
     * 
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->only('name', 'user', 'email'));

        $detail = [
            'user_id'    => $user->id,
            'jabatan_id'    => $request->jabatan_id,
            'unit_id'    => $request->unit,
            'departemen' => $request->departemen,
            'no_hp'      => $request->no_hp,
        ];

        try {
            \App\Models\UserDetail::updateOrCreate(
                ['user_id' => $user->id],
                $detail
            );

            TelegramHelper::sendMessage("✅", "USER UPDATED", [
                "user"   => $user->only('name', 'username', 'email'),
                "detail" => $detail
            ]);
        } catch (\Throwable $th) {
            TelegramHelper::sendMessage("❌", "USER UPDATED FAILED", [
                "user"   => $user->only('name', 'username', 'email'),
                "detail" => $detail,
                "error"  => $th->getMessage()
            ]);

            return Redirect::route('users.index')->with('error', 'User updated failed');
        }

        return Redirect::route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Restore the specified resource from storage.
     * 
     * @param string $id
     * @param Request $request
     */
    public function restore(string $id, Request $request): RedirectResponse
    {
        // validate the request
        $user = User::onlyTrashed()->find($id);

        if ($user) {
            try {
                $user->restore();
                TelegramHelper::sendMessage("✅", "USER RESTORED", [
                    "user" => $user->only('name', 'username', 'email')
                ]);
            } catch (\Throwable $th) {
                TelegramHelper::sendMessage("❌", "USER RESTORED FAILED", [
                    "user"  => $user->only('name', 'username', 'email'),
                    "error" => $th->getMessage()
                ]);

                return Redirect::route('users.index')->with('error', 'User restored failed');
            }
        }

        return Redirect::route('users.index')->with('error', 'User not found');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return RedirectResponse
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
                TelegramHelper::sendMessage("❌", "USER DELETED FAILED", [
                    "user"  => $user->only('name', 'username', 'email'),
                    "error" => "Cannot delete " . $user->name . " (Administator), Because there is no another admin"
                ]);
                
                return Redirect::route('users.index')->with('error', 'Cannot delete ' . $user->name . ' (Administator), Because there is no another admin');
            }
        }

        try {
            $user->delete();

            TelegramHelper::sendMessage("✅", "USER DELETED", [
                "user" => $user->only('name', 'username', 'email')
            ]);
        } catch (\Throwable $th) {
            TelegramHelper::sendMessage("❌", "USER DELETED FAILED", [
                "user"  => $user->only('name', 'username', 'email'),
                "error" => $th->getMessage()
            ]);

            return Redirect::route('users.index')->with('error', 'User deleted failed');
        }

        return Redirect::route('users.index')->with('success', 'User deleted successfully');
    }
}
