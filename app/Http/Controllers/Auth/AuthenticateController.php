<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use App\Models\SocialiteUser;
use Illuminate\Support\Str;
use App\Models\User;
use Inertia\Inertia;

class AuthenticateController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Login', [
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an authentication attempt.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:3', 'max:21'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Redirect to Provider
     *
     * @param [type] $provider
     * @return void
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle provider Callback
     *
     * @param [type] $provider
     * @return void
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();

            $socialite_user = SocialiteUser::where('email', $user->email)->first();

            if (!$socialite_user) {
                $register_user = $this->createSocialiteUser($user);

                SocialiteUser::create([
                    'email' => $user->email,
                    'provider' => $provider,
                ]);

                Auth::login($register_user);

                return redirect()->route('dashboard');
            }

            $registered_user = User::where('email', $user->email)->first();

            Auth::login($registered_user);
            return redirect()->route('dashboard');
        } catch (\Throwable $th) {
            Log::log(throw $th);
        }
    }

    /**
     * Register user in Database
     *
     * @param [type] $userPayload
     * @return void
     */
    public function createSocialiteUser($userPayload)
    {
        $name = $userPayload->name;
        $email = $userPayload->email;
        $password = Hash::make(Str::random(8));

        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
    }
}
