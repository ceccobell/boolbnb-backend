<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        // Genera un nuovo token per l'utente autenticato
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        // In caso di richiesta JSON, restituisci il token e i dati utente
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
            ], 200);
        }

        // In alternativa, procedi con la normale risposta di redirect
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        // Effettua il logout
        Auth::guard('web')->logout();

        // Revoca tutti i token dell'utente autenticato
        if ($user = $request->user()) {
            $user->tokens()->delete();
        }

        // In caso di richiesta JSON, restituisci un messaggio di successo
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Logout successful',
            ], 200);
        }

        // In alternativa, procedi con la normale risposta di redirect
        return redirect('/');
    }
}
