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

        $sponsorshipStart = $activeSponsorship ? Carbon::parse($activeSponsorship->pivot->sponsorship_end) : Carbon::now();
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

    public function getApartmentsWithActiveSponsorship()
    {
        // Recupera gli appartamenti con una sponsorizzazione attiva
        $apartments = Apartment::whereHas('packages', function ($query) {
            $query->where('sponsorship_end', '>', Carbon::now()); // Controlla se la sponsorizzazione è ancora attiva
        })
            ->with(['packages' => function ($query) {
                $query->where('sponsorship_end', '>', Carbon::now())
                    ->orderByDesc('sponsorship_start'); // Ordina per data di inizio della sponsorizzazione
            }])
            ->orderByDesc(function ($query) {
                // Ordina gli appartamenti in base alla data di inizio della sponsorizzazione più recente
                $query->select('sponsorship_start')
                    ->from('apartment_package')  // La tabella pivot che contiene le informazioni sulla sponsorizzazione
                    ->whereColumn('apartment_id', 'apartments.id')
                    ->orderByDesc('sponsorship_start')  // Ordinamento in ordine decrescente
                    ->limit(1);  // Considera solo la sponsorizzazione più recente per ogni appartamento
            })
            ->where('status', 'like', 'Disponibile')
            ->get();

        $apartments->each(function ($apartment) {
            $apartment->images->each(function ($image) {
                $image->url = asset('storage/' . $image->image_url);
            });
        });

        return response()->json([
            "apartments" => $apartments,
        ]);
    }
}
