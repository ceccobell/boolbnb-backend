<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Gestisce una richiesta di autenticazione in arrivo.
     */
    public function store(Request $request): JsonResponse
    {
        // Validazione dei dati di input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Tentativo di autenticazione
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Credenziali non valide',
            ], 401);
        }

        // Recupera l'utente autenticato
        $user = User::where('email', $request->email)->firstOrFail();

        // Genera un token di accesso con Laravel Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        // Restituisce il token come risposta JSON
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    /**
     * Distrugge una sessione autenticata.
     */
    public function destroy(Request $request): JsonResponse
    {
        // Elimina tutti i token dell'utente autenticato
        $request->user()->tokens()->delete();

        // Restituisce una risposta JSON di conferma
        return response()->json([
            'message' => 'Logout effettuato con successo',
        ], 200);
    }
}
