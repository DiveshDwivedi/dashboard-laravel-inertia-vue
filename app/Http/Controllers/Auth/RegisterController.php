<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class RegisterController extends Controller
{
    public function create() {
        return Inertia::render('Auth/Register');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:221',
            'email' => 'required|email|lowercase|min:3|max:221',
            'password' => 'required|confirmed|min:3|max:21'
        ]);

        $user = User::create($validated);

        event(new Registered($user));
        sleep(1);

        Auth::login($user);

        return redirect()->route('home');
    }
}
