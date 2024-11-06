@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <h1>Modifica Appartamento</h1>
        <form action="{{ route('apartments.update', $apartment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-4">
                <div class="mb-2 col-12">
                    <label for="title" class="form-label">Titolo annuncio</label>
                    <input type="text" name="title" class="form-control" value="{{ $apartment->title }}" required>
                </div>
                <div class="mb-2 col-12 col-md-4">
                    <label for="property" class="form-label">Proprietà</label>
                    <input type="text" name="property" class="form-control" value="{{ $apartment->property }}" required>
                </div>
                <div class="mb-2 col-12 col-md-4">
                    <label for="city" class="form-label">Città</label>
                    <input type="text" name="city" class="form-control" value="{{ $apartment->city }}" required>
                </div>
                <div class="mb-2 col-12 col-md-4">
                    <label for="address" class="form-label">Indirizzo</label>
                    <input type="text" name="address" class="form-control" value="{{ $apartment->address }}" required>
                </div>
                <div class="mb-2 col-12">
                    <label for="description" class="form-label">Descrizione</label>
                    <textarea name="description" class="form-control" required>{{ $apartment->description }}</textarea>
                </div>
                <div class="mb-2 col-12 col-md-6">
                    <label for="main_image" class="form-label">Immagine copertina (opzionale)</label>
                    <input type="file" name="main_image" class="form-control">
                </div>
                <div class="mb-2 col-12 col-md-6">
                    <label for="image[]" class="form-label">Nuove Immagini (opzionale)</label>
                    <input type="file" name="image[]" class="form-control" multiple>
                </div>
                <div class="mb-2 col-12">
                    <h5>Servizi disponibili</h5>
                    <div class="row g-3">
                        @foreach ($services as $service)
                            <div class="col-12 col-md-3">
                                <div class="form-check">
                                    <input type="checkbox" name="services[]" value="{{ $service->id }}" class="form-check-input"
                                        id="service-{{ $service->id }}"
                                        {{ $apartment->services->contains($service->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="service-{{ $service->id }}">
                                        {{ $service->service_name }} <i class="{{ $service->service_icon }}"></i>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-success w-100 w-md-auto">Aggiorna Appartamento</button>
            </div>
        </form>
    </div>
@endsection

