<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use Illuminate\Support\Carbon;



class ApartmentSearchController extends Controller
{
    public function searchNearbyApartments(Request $request)
    {
        $location = $request->input('address');
        $radius = $request->input('radius', 20);
        $minRooms = $request->input('min_rooms');
        $minBeds = $request->input('min_beds');
        $requiredServices = $request->input('services_filtered', []);

        // Ottieni le coordinate usando la funzione esistente
        $coordinates = app(ApartmentController::class)->getCoordinates($location);

        if (!$coordinates) {
            return response()->json(['error' => 'Location not found'], 404);
        }

        $originLat = $coordinates['latitude'];
        $originLon = $coordinates['longitude'];

        // Recupera tutti gli appartamenti e filtra
        $apartments = Apartment::with('services', 'user')
            ->when($minRooms, function ($query) use ($minRooms) {
                $query->where('n_rooms', '>=', $minRooms);
            })
            ->when($minBeds, function ($query) use ($minBeds) {
                $query->where('n_beds', '>=', $minBeds);
            })
            ->when(!empty($requiredServices), function ($query) use ($requiredServices) {
                $query->whereHas('services', function ($q) use ($requiredServices) {
                    $q->whereIn('service_id', $requiredServices);
                }, '=', count($requiredServices));
            })
            ->where('status', 'like', 'Disponibile')
            ->get();

        // Separare gli appartamenti sponsorizzati e non
        $apartmentsWithSponsorship = $apartments->filter(function ($apartment) {
            // Controlla se l'appartamento ha una sponsorizzazione attiva
            return $apartment->packages()->where('sponsorship_end', '>', Carbon::now())->exists();
        });

        $apartmentsWithoutSponsorship = $apartments->diff($apartmentsWithSponsorship);

        // Unire gli appartamenti sponsorizzati (al primo posto) con quelli senza sponsorizzazione
        $sortedApartments = $apartmentsWithSponsorship->merge($apartmentsWithoutSponsorship);

        // Aggiungere l'URL delle immagini
        $sortedApartments->each(function ($apartment) {
            $apartment->images->each(function ($image) {
                $image->url = asset('storage/' . $image->image_url);
            });
        });

        // Filtra in base al raggio usando la funzione Haversine
        $nearbyApartments = $sortedApartments->filter(function ($apartment) use ($originLat, $originLon, $radius) {
            $distance = $this->haversineDistance($originLat, $originLon, $apartment->latitude, $apartment->longitude);
            return $distance <= $radius;
        });


        return response()->json($nearbyApartments->values());
    }

    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }
}
