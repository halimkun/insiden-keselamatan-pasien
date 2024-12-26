<?php

namespace App\Http\Controllers;

use App\Helpers\TelegramHelper;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = \App\Models\User::with('detail')->findOrFail($request->user()->id);
        
        return view('profile.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->only("name", "email", "username"));
        
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        
        $request->user()->save();
        
        $request->user()->detail->fill($request->only("no_hp"));
        $request->user()->detail->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated')->with('success', 'Profile updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        try {
            $user = $request->user()->load('detail');
            Auth::logout();
            $user->delete();

            TelegramHelper::sendMessage('✅', 'USER DELETED', $user->toArray());
        } catch (\Exception $e) {
            TelegramHelper::sendMessage('❌', 'USER DELETE FAILED', ['id' => $request->user()->id, 'error' => $e->getMessage()]);
            return Redirect::route('profile.edit')->with('status', 'profile-deletion-failed')->with('error', 'An error occurred: ' . $e->getMessage());
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
