<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
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

        /* $request->session()->regenerate(); */

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Login successful',
                'user' => Auth::user(),
            ], 200);
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        /* $request->session()->invalidate(); */

        /* $request->session()->regenerateToken(); */

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Logout successful',
            ], 200);
        }

        return redirect('/');
    }
}
