<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Service;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ApartmentController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $apartments = Apartment::where('user_id', $userId)->get();
        return view('apartments.index', compact('apartments'));
    }

    public function create()
    {
        $services = Service::orderBy('service_name', 'asc')->get();
        return view('apartments.create', compact('services'));
    }

    public function getCoordinates($address)
    {
        $url = config('services.tomtom.url') . urlencode($address) . '.json';
        $apiKey = config('services.tomtom.key');

        $response = Http::get($url, [
            'key' => $apiKey,
        ]);

        if ($response->successful() && isset($response['results'][0]['position'])) {
            $coordinates = $response['results'][0]['position'];
            $addressDetails = $response['results'][0]['address'];  // Ottieni i dettagli dell'indirizzo

            // Estrai la città dalla risposta
            $city = $addressDetails['municipality'] ?? null;

            return [
                'latitude' => $coordinates['lat'],
                'longitude' => $coordinates['lon'],
                'city' => $city,  // Aggiungi la città ai dati restituiti
            ];
        }

        return null;
    }


    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'property' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'description' => 'required|string',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif',
                'main_image' => 'required|image|mimes:jpeg,png,jpg,gif',
                'status' => 'required|string|max:30',
                'services' => 'required|array|min:1',
                'services.*' => 'exists:services,id',
            ],
            [
                'title.required' => 'Il titolo è obbligatorio.',
                'title.max' => 'Il titolo non può superare i 255 caratteri.',
                'property.required' => 'La proprietà è obbligatoria.',
                'address.required' => 'L\'indirizzo è obbligatorio.',
                'description.required' => 'La descrizione è obbligatoria.',
                'main_image.image' => 'Devi caricare un\'immagine principale valida.',
                'image..image' => 'Ogni immagine deve essere in formato valido.',
                'services.required' => 'Devi selezionare almeno un servizio.',
                'services.min' => 'Seleziona almeno un servizio.',
                'services..exists' => 'Il servizio selezionato non è valido.',
            ]
        );

        $coordinates = $this->getCoordinates($request->address);

        if (!$coordinates) {
            return redirect()->back()->withErrors(['address' => 'Address not found.']);
        }

        $apartment = Apartment::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'property' => $request->property,
            'slug' => Apartment::generateSlug($request->property),
            'city' => $coordinates['city'],
            'address' => $request->address,
            'n_rooms' => $request->n_rooms,
            'n_beds' => $request->n_beds,
            'n_bathrooms' => $request->n_bathrooms,
            'square_meters' => $request->square_meters,
            'description' => $request->description,
            'status' => $request->status,
            'latitude' => $coordinates['latitude'],
            'longitude' => $coordinates['longitude'],
        ]);

        if ($request->hasFile('main_image')) {
            $mainImagePath = $request->file('main_image')->store('apartments', 'public');

            $mainImage = new Image();
            $mainImage->apartment_id = $apartment->id;
            $mainImage->image_url = $mainImagePath;
            $mainImage->is_main = true;
            $mainImage->save();
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $imageFile) {
                $imagePath = $imageFile->store('apartments', 'public');

                $image = new Image();
                $image->apartment_id = $apartment->id;
                $image->image_url = $imagePath;
                $image->is_main = false;
                $image->save();
            }
        }

        if ($request->has('services')) {
            $apartment->services()->attach($request->services);
        }

        return redirect()->route('apartments.index')->with('success', 'Apartment created successfully.');
    }

    public function show($id)
    {
        $apartment = Apartment::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('apartments.show', compact('apartment'));
    }

    public function edit($id)
    {
        $apartment = Apartment::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $services = Service::orderBy('service_name', 'asc')->get();
        return view('apartments.edit', compact('apartment', 'services'));
    }

    public function update(Request $request, $id)
    {

        $request->validate(
            [
                'title' => 'required|string|max:255',
                'property' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'description' => 'required|string',
                'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'services' => 'required|array|min:1',
                'services.*' => 'exists:services,id'
            ],
            [
                'title.required' => 'Il titolo è obbligatorio.',
                'title.max' => 'Il titolo non può superare i 255 caratteri.',
                'property.required' => 'La proprietà è obbligatoria.',
                'address.required' => 'L\'indirizzo è obbligatorio.',
                'description.required' => 'La descrizione è obbligatoria.',
                'main_image.image' => 'Devi caricare un\'immagine principale valida.',
                'image..image' => 'Ogni immagine deve essere in formato valido.',
                'services.required' => 'Devi selezionare almeno un servizio.',
                'services.min' => 'Seleziona almeno un servizio.',
                'services..exists' => 'Il servizio selezionato non è valido.',
            ]
        );


        $apartment = Apartment::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        if ($request->hasFile('main_image')) {
            $oldMainImage = $apartment->images()->where('is_main', true)->first();
            if ($oldMainImage) {
                Storage::disk('public')->delete($oldMainImage->image_url);
                $oldMainImage->delete();
            }

            $mainImagePath = $request->file('main_image')->store('apartments', 'public');
            $mainImage = new Image();
            $mainImage->apartment_id = $apartment->id;
            $mainImage->image_url = $mainImagePath;
            $mainImage->is_main = true;
            $mainImage->save();
            Log::info("Nuova immagine principale salvata: {$mainImagePath}");
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $imageFile) {
                $imagePath = $imageFile->store('apartments', 'public');

                $image = new Image();
                $image->apartment_id = $apartment->id;
                $image->image_url = $imagePath;
                $image->is_main = false;
                $image->save();
                Log::info("Immagine aggiuntiva salvata: {$imagePath}");
            }
        }

        $apartment->update($request->only([
            'title',
            'property',
            'city',
            'address',
            'description',
            'n_rooms',
            'n_beds',
            'n_bathrooms',
            'square_meters',
            'status'
        ]));
        Log::info("Dettagli dell'appartamento aggiornati.");



        $apartment->services()->sync($request->input('services', []));

        return redirect()->route('apartments.index')->with('success', 'Apartment updated successfully.');
    }

    public function destroy($id)
    {
        $apartment = Apartment::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        foreach ($apartment->images as $image) {
            Storage::disk('public')->delete($image->image_url);
            $image->delete();
        }

        $apartment->delete();

        return redirect()->route('apartments.index')->with('success', 'Apartment deleted successfully.');
    }
}
