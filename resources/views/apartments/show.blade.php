@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('apartments.index') }}" class="btn btn-light rounded-pill fs-3"><i class="fas fa-arrow-left"></i></a>
            <h1 class="text-primary text-center w-100">{{ $apartment->title }}</h1>
            <i class="fa-solid fa-circle-info fa-lg"></i>
        </div>
        
        <div class="row mb-4">
            <div class="col-12 col-md-8">
                <div class="card p-4 shadow-sm border-0 rounded-3 d-flex h-100">
                    <h3 class="mb-4">Informazioni principali</h3>
                    <div class="row">
                        <div class="col-6">
                            <span class="text-secondary">Tipo di proprietà</span>
                            <p class="fs-5">{{ $apartment->property }}</p>
                        </div>
                        <div class="col-6">
                            <span class="text-secondary">Città</span>
                            <p class="fs-5">{{ $apartment->city }}</p>
                        </div>
                        <div class="col-6">
                            <span class="text-secondary">Indirizzo</span>
                            <p class="fs-5">{{ $apartment->address }}</p>
                        </div>
                        <div class="col-12">
                            <span class="text-secondary">Stato</span>
                            <p class="fs-5 text-success">{{ $apartment->status }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-4">
                <div class="card p-4 shadow-sm border-0 rounded-3 d-flex h-100">
                    <h3 class="mb-4">Immagine della proprietà</h3>
                    <div class="image pt-3">
                        <img src="{{ asset($apartment->mainImage ? 'storage/' . $apartment->mainImage->image_url : 'https://via.placeholder.com/600x400.png?text=Immagine%20non%20disponibile') }}" 
                             class="card-img-top rounded-3" 
                             alt="{{ $apartment->title }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card p-4 shadow-sm border-0 rounded-3">
                    <h3 class="mb-4">Dettagli della proprietà</h3>
                    <div class="row">
                        <div class="col-6 col-md-3">
                            <span class="text-secondary">Camere</span>
                            <p class="fs-5">{{ $apartment->n_rooms }}</p>
                        </div>
                        <div class="col-6 col-md-3">
                            <span class="text-secondary">Posti letto</span>
                            <p class="fs-5">{{ $apartment->n_beds }}</p>
                        </div>
                        <div class="col-6 col-md-3">
                            <span class="text-secondary">Bagni</span>
                            <p class="fs-5">{{ $apartment->n_bathrooms }}</p>
                        </div>
                        <div class="col-6 col-md-3">
                            <span class="text-secondary">Metri quadrati</span>
                            <p class="fs-5">{{ $apartment->square_meters }} m²</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card p-4 shadow-sm border-0 rounded-3">
                    <h3 class="mb-4">Servizi</h3>
                    <div class="row">
                        @foreach ($apartment->services as $service)
                            <div class="col-6 col-sm-4 col-md-3 my-2 text-center">
                                <span class="text-secondary d-block">{{ $service->service_name }}</span>
                                <i class="{{ $service->service_icon }} fa-2x"></i>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card p-4 shadow-sm border-0 rounded-3">
                    <h3 class="mb-4">Descrizione</h3>
                    <p>{{ $apartment->description }}</p>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ route('apartments.edit', $apartment->id) }}" class="btn btn-warning mx-2">Modifica</a>
                <form action="{{ route('apartments.destroy', $apartment->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Sei sicuro di voler eliminare questo appartamento?')">Elimina</button>
                </form>
            </div>
        </div>
    </div>
@endsection


