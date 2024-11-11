<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SponsorshipController extends Controller
{
    public function sponsorApartment(Request $request)
    {
        $validatedData = $request->validate([
            'apartment_id' => 'required|exists:apartments,id',
            'package_id' => 'required|exists:packages,id',
        ]);

        $apartmentId = $validatedData['apartment_id'];
        $packageId = $validatedData['package_id'];

        $apartment = Apartment::find($apartmentId);
        $package = Package::find($packageId);

        // Controlla se esiste già una sponsorizzazione attiva
        $activeSponsorship = $apartment->packages()
            ->wherePivot('sponsorship_end', '>', Carbon::now())
            ->orderByDesc('sponsorship_end')
            ->first();

        // Definisce la data di inizio
        $sponsorshipStart = $activeSponsorship ? $activeSponsorship->pivot->sponsorship_end : Carbon::now();
        // Calcola la data di fine in base alle ore definite dal pacchetto
        $sponsorshipEnd = $sponsorshipStart->copy()->addHours($package->hours);

        // Assegna il nuovo pacchetto all'appartamento con le date calcolate
        $apartment->packages()->attach($packageId, [
            'sponsorship_start' => $sponsorshipStart,
            'sponsorship_end' => $sponsorshipEnd,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Sponsorizzazione assegnata con successo',
            'sponsorship_start' => $sponsorshipStart,
            'sponsorship_end' => $sponsorshipEnd,
        ]);
    }

    public function getSponsorPackages()
    {
        $packages = Package::all();

        return response()->json([
            'packages' => $packages,
        ], 200);
    }
}
