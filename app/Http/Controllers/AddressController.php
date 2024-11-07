<?php

// app/Http/Controllers/AddressController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AddressController extends Controller
{
    public function getSuggestions(Request $request)
    {
        // Recupera la query di ricerca inviata dal frontend
        $query = $request->input('query');

        // Effettua la chiamata all'API di TomTom per i suggerimenti
        $response = Http::get('https://api.tomtom.com/search/2/search/' . $query . '.json', [
            'key' => 'Qwrc50MvZYOeJvH56v7hQrbf5HSzDfyX', // Sostituisci con la tua chiave API TomTom
            'limit' => 5
        ]);

        // Restituisce i suggerimenti come risposta JSON
        return response()->json($response->json());
    }
}

