<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserApartmentController extends Controller
{
    /**
     * Display a listing of the authenticated user's apartments.
     */
    public function index()
    {
        // Ottieni gli appartamenti dell'utente autenticato
        $userId = Auth::id();
        $apartments = Apartment::where('user_id', $userId)
            ->with([
                'services', 
                'user',
                'packages' => function ($query) {
                    $query->withPivot('sponsorship_end')->orderByDesc('pivot_sponsorship_end')->limit(1);
                }
            ])
            ->get();

        $apartments->each(function ($apartment) {
        $apartment->images->each(function ($image) {
            $image->url = asset('storage/' . $image->image_url);
        });

        // Formattazione della data 'sponsorship_end' senza orario
        $apartment->packages->each(function ($package) {
            if ($package->pivot->sponsorship_end) {
                $package->pivot->sponsorship_end = \Carbon\Carbon::parse($package->pivot->sponsorship_end)->format('d-m-Y');
            }
        });
    });

        return response()->json([
            'apartments' => $apartments,
        ], 200);
    }



    /**
     * Sponsorizza un appartamento specifico.
     */
    public function sponsorApartment(Request $request, $apartmentId)
    {
        // Verifica che l'appartamento appartenga all'utente autenticato
        $userId = Auth::id();
        $apartment = Apartment::where('id', $apartmentId)->where('user_id', $userId)->first();

        if (!$apartment) {
            return response()->json(['error' => 'Apartment not found or not authorized'], 403);
        }

        // Logica per gestire la sponsorizzazione
        // Ad esempio, salva il pagamento, aggiorna l’appartamento come sponsorizzato, ecc.

        return response()->json(['message' => 'Sponsorship successful'], 200);
    }
}
