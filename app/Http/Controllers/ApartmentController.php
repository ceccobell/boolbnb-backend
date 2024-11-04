<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();
        $apartments = Apartment::where('user_id', $userId)->get();
        return view('apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();
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
            return [
                'latitude' => $coordinates['lat'],
                'longitude' => $coordinates['lon'],
            ];
        }

        return null;  // Gestione degli errori se l'indirizzo non viene trovato
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'property' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'description' => 'required|string',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_image_id' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string|max:30',
        ]);

        // get coordinates
        $coordinates = $this->getCoordinates($request->address);

        if (!$coordinates) {
            return redirect()->back()->withErrors(['address' => 'Address not found.']);
        }

        // Store image
        $imagePath = $request->file('image')->store('apartments', 'public');

        // Create new apartment
        $apartment = Apartment::create([
            'user_id' => auth()->id(), // Assuming the user is authenticated
            'title' => $request->title,
            'property' => $request->property,
            'slug' => Apartment::generateSlug($request->property),
            'city' => $request->city,
            'address' => $request->address,
            'n_rooms' => $request->n_rooms,
            'n_beds' => $request->n_beds,
            'n_bathrooms' => $request->n_bathrooms,
            'square_meters' => $request->square_meters,
            'description' => $request->description,
            'main_image_id' => $request->main_image_id,
            'image' => $imagePath,
            'status' => $request->status,
            'latitude' => $coordinates['latitude'],
            'longitude' => $coordinates['longitude'],
        ]);

        // Salva i servizi associati
        if ($request->has('services')) {
            $apartment->services()->attach($request->services);
        }

        return redirect()->route('apartments.index')->with('success', 'Apartment created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $apartment = Apartment::findOrFail($id);
        return view('apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $apartment = Apartment::findOrFail($id);
        $services = Service::all();
        return view('apartments.edit', compact('apartment', 'services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'property' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'description' => 'required|string',
            'main_image_id' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'services' => 'nullable|array',
            'services.*' => 'exists:services,id'
        ]);

        $apartment = Apartment::findOrFail($id);

        // Store new image if uploaded
        if ($request->hasFile('image')) {
            // Delete the old image
            Storage::disk('public')->delete($apartment->image);
            $imagePath = $request->file('image')->store('apartments', 'public');
            $apartment->image = $imagePath;
        }

        // Update apartment details
        $apartment->update([
            'property' => $request->property,
            'city' => $request->city,
            'address' => $request->address,
            'description' => $request->description,
        ]);

        // Sync selected services
        $apartment->services()->sync($request->input('services', [])); // Use an empty array if no services selected

        return redirect()->route('apartments.index')->with('success', 'Apartment updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $apartment = Apartment::findOrFail($id);

        // Delete the main image if it exists
        if ($apartment->mainImage) {
            Storage::disk('public')->delete($apartment->mainImage->image_url);
        }

        // Delete the apartment
        $apartment->delete();

        return redirect()->route('apartments.index')->with('success', 'Apartment deleted successfully.');
    }
}
