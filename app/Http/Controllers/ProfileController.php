<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthenticateController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return Inertia::render('Profile/Edit', [
            'user' => $request->user(),
            'status' => session('status')
        ]);
    }

    /**
     * Update User's Info
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:51'],
            'email' => [
                'required',
                'lowercase',
                'email',
                'min:3',
                'max:51',
                Rule::unique(User::class)->ignore($request->user()->id)
            ],
        ]);

        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return redirect()->route('profile.edit');
    }

    /**
     * Update user's profile password
     *
     * @return void
     */
    public function updatePassword(Request $request) {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.edit');
    }

    /**
     * Delete Logged In Account
     *
     * @param Request $request
     * @return void
     */
    public function delete(Request $request) {
        $request->validate([
            'password' => ['required', 'current_password']
        ]);

        $auth = new AuthenticateController;

        $user = $request->user();
        $user->delete();
        
        $auth->logout($request);
    }
}
