@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifica Appartamento</h1>
        <form action="{{ route('apartments.update', $apartment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mb-3 col-12 my-4">
                    <h5 class="text-danger">I campi con * sono obbligatori</h3>
                </div>
                <div class="mb-3 col-6">
                    <label for="title" class="form-label">Titolo annuncio <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3 col-6">
                    <label for="property" class="form-label">Proprietà <span class="text-danger">*</span></label>
                    <input type="text" name="property" class="form-control" required>
                </div>
                <div class="mb-3 col-12">
                    <label for="city" class="form-label">Città ed indirizzo</label>
                    <input type="text" name="city" class="form-control" value="{{ $apartment->city }}" required>
                </div>
                <div class="mb-3 col-12">
                    <label for="description" class="form-label">Descrizione</label>
                    <textarea name="description" class="form-control" required>{{ $apartment->description }}</textarea>
                </div>
                <div class="mb-3 col-6">
                    <label for="main_image" class="form-label">Immagine Copertina (opzionale)</label>
                    <input type="file" name="main_image" class="form-control">
                </div>
                <div class="mb-3 col-6">
                    <label for="image[]" class="form-label">Altre Immagini (opzionale)</label>
                    <input type="file" name="image[]" class="form-control" multiple>
                </div>
                @foreach ($services as $service)
                    <div class="mb-3 col-3">
                        <div class="form-check">
                            <input type="checkbox" name="services[]" value="{{ $service->id }}" class="form-check-input"
                                id="service-{{ $service->id }}"
                                {{ $apartment->services->contains($service->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="service-{{ $service->id }}">{{ $service->service_name }}
                                <i class="{{ $service->service_icon }}"></i></label>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-success">Aggiorna Appartamento</button>
        </form>
    </div>
@endsection
