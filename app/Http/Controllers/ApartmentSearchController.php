<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;

class ApartmentSearchController extends Controller
{
    public function searchNearbyApartments(Request $request)
    {
        $location = $request->input('location');
        $radius = $request->input('radius', 20);

        // Ottieni le coordinate usando la funzione esistente nel tuo `ApartmentController`
        $coordinates = app(ApartmentController::class)->getCoordinates($location);

        if (!$coordinates) {
            return response()->json(['error' => 'Location not found'], 404);
        }

        $originLat = $coordinates['latitude'];
        $originLon = $coordinates['longitude'];

        // Recupera tutti gli appartamenti
        $apartments = Apartment::all();
        $nearbyApartments = [];

        foreach ($apartments as $apartment) {
            $distance = $this->haversineDistance($originLat, $originLon, $apartment->latitude, $apartment->longitude);
            if ($distance <= $radius) {
                $nearbyApartments[] = $apartment;
            }
        }

        return response()->json($nearbyApartments);
    }

    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Raggio della Terra in km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance;
    }
}

