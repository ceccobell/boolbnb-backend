@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12  mt-5">
            <a href="{{ route('apartments.index') }}" class="btn rounded-pill fs-3">&larr;</a>
            </div>
            <div class="col-12 mb-3">
                <h1>{{ $apartment->title }}</h1>
            </div>
            <div class="col-8">
                <div class="card p-4 min-h">
                    <h3 class="mb-4">Basic information</h3>
                    <div class="row">
                        <div class="col-6">
                            <span class="text-secondary">property Type</span>
                            <p class="fs-5">{{ $apartment->property }}</p>
                        </div>
                        <div class="col-6">
                            <span class="text-secondary">City</span>
                            <p class="fs-5">{{ $apartment->city }}</p>
                        </div>
                        <div class="col-6">
                            <span class="text-secondary">Address</span>
                            <p class="fs-5">{{ $apartment->address }}</p>
                        </div>
                        <div class="col-12">
                            <span class="text-secondary">Status</span>
                            <p class="mt-2">
                                <span  class="bd">
                                    {{ $apartment->status }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card p-4 min-h">
                    <h3>Property Image</h3>
                    <div class="image pt-5">
                        <img src="{{ $apartment->getMainImageUrlAttribute() }}" class="card-img-top"
                        alt="{{ $apartment->title }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                <div class="card p-4">
                    <h3>Property Details</h3>
                    <div class="row">
                        <div class="col-3">
                            <span class="text-secondary">Rooms</span>
                            <p class="fs-5">{{ $apartment->n_rooms }}</p>
                        </div>
                        <div class="col-3">
                            <span class="text-secondary">Beds</span>
                            <p class="fs-5">{{ $apartment->n_beds }}</p>
                        </div>
                        <div class="col-3">
                            <span class="text-secondary">Bathrooms</span>
                            <p class="fs-5">{{ $apartment->n_bathrooms }}</p>
                        </div>
                        <div class="col-3">
                            <span class="text-secondary">Square Meters</span>
                            <p class="fs-5">{{ $apartment->square_meters }} m²</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                <div class="card p-4">
                    <h3>Services</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                <div class="card p-4">
                    <h3>Description</h3>
                    <p>{{ $apartment->description }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-3 d-flex justify-content-end">
                <a href="{{ route('apartments.edit', $apartment->id) }}" class="btn btn-warning">Modifica</a>
                <form action="{{ route('apartments.destroy', $apartment->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger ms-2"
                        onclick="return confirm('Sei sicuro di voler eliminare questo appartamento?')">Elimina</button>
                </form>
            </div>
        </div>
    </div>
@endsection