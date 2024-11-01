<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::all();
        return view('apartment.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();
        return view('apartment.create', compact('services'));
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
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        // Store image
        $imagePath = $request->file('image')->store('apartments', 'public');

        // Create new apartment
        Apartment::create([
            'user_id' => auth()->id(), // Assuming the user is authenticated
            'property' => $request->property,
            'city' => $request->city,
            'address' => $request->address,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

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
        return view('apartment.show', compact('apartment'));
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
        return view('apartment.edit', compact('apartment', 'services'));
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
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
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
            'price' => $request->price,
        ]);

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
        // Delete the image
        Storage::disk('public')->delete($apartment->image);
        $apartment->delete();

        return redirect()->route('apartments.index')->with('success', 'Apartment deleted successfully.');
    }
}
