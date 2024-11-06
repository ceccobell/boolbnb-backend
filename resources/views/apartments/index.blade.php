@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">Appartamenti</h1>
            <!-- Il bottone si adatta alla larghezza dello schermo, riducendosi su schermi più piccoli -->
            <a href="{{ route('apartments.create') }}" class="btn btn-success btn-sm d-inline-block d-md-block">
                Aggiungi Appartamento
            </a>
        </div>
        
        <div class="row g-4">
            @foreach ($apartments as $apartment)
                <!-- Colonna responsiva con margine tra le card -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0 rounded-3">
                        <img src="{{ asset($apartment->mainImage ? 'storage/' . $apartment->mainImage->image_url : 'https://via.placeholder.com/600x400.png?text=Immagine%20non%20disponibile') }}" 
                             class="card-img-top rounded-top" 
                             alt="{{ $apartment->title }}">

                        <div class="card-body d-flex flex-column py-2">
                            <h5 class="card-title text-primary">{{ $apartment->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($apartment->description, 100) }}</p>

                            <!-- Bottoni disposti in colonna su schermi piccoli e in riga su schermi più grandi -->
                            <div class="mt-auto">
                                <div class="d-grid gap-1 d-sm-flex">
                                    <a href="{{ route('apartments.show', $apartment->id) }}" class="btn btn-primary btn-sm w-100">Visualizza</a>
                                    <a href="{{ route('apartments.edit', $apartment->id) }}" class="btn btn-warning btn-sm w-100">Modifica</a>

                                    <form action="{{ route('apartments.destroy', $apartment->id) }}" method="POST" class="w-100">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm w-100"
                                            onclick="return confirm('Sei sicuro di voler eliminare questo appartamento?')">Elimina</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection