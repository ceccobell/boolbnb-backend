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
        ->with(['services', 'user', 'images'])
        ->get();

    $apartments->each(function ($apartment) {
        // Ottieni il percorso completo dell'immagine
        $apartment->images->each(function ($image) {
            $image->url = asset('storage/' . $image->image_url);
        });

        // Prendi solo l'ultimo pacchetto sponsorizzato per ogni appartamento
        $latestPackage = $apartment->packages()
            ->withPivot('sponsorship_end')
            ->orderByDesc('pivot_sponsorship_end')
            ->first();

        // Formatta la data di 'sponsorship_end' e assegna il pacchetto
        if ($latestPackage && $latestPackage->pivot->sponsorship_end) {
            $latestPackage->pivot->sponsorship_end = \Carbon\Carbon::parse($latestPackage->pivot->sponsorship_end)->format('d-m-Y');
            $apartment->latest_package = $latestPackage; // Assegna il pacchetto formattato all'appartamento
        } else {
            $apartment->latest_package = null; // Nessun pacchetto disponibile
        }
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
