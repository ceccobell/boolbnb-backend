<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'surname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ],
            [
                'name.required' => 'Il nome è obbligatorio',
                'surname.required' => 'Il cognome è obbligatorio',
                'email.required' => 'L\'indirizzo email è obbligatorio',
                'password.required' => 'La password è obbligatoria',
                'password.confirmed' => 'Le password non corrispondono',
            ]
        );

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Verifica se la richiesta è API (JSON)
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Registration successful',
                'user' => $user,
            ], 201); // Stato HTTP 201 per creazione
        }

        // Risposta per richieste classiche (Blade)
        return redirect(RouteServiceProvider::HOME);
    }
}
