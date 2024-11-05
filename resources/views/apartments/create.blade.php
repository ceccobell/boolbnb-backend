@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Aggiungi Appartamento</h1>
            </div>
            <div class="col-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('apartments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
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
                        <div class="mb-3 col-6">
                            <label for="city" class="form-label">Città <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="address" class="form-label">Indirizzo <span class="text-danger">*</span></label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrizione</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="n_rooms" class="form-label">Numero Camere <span class="text-danger">*</span></label>
                            <input type="number" min="1" name="n_rooms" class="form-control" required>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="n_beds" class="form-label">Posti letto <span class="text-danger">*</span></label>
                            <input type="number"  min="1" name="n_beds" class="form-control" required>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="n_bathrooms" class="form-label">Numero bagni <span class="text-danger">*</span></label>
                            <input type="number"  min="1" name="n_bathrooms" class="form-control" required>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="square_meters" class="form-label">Metri quadri <span class="text-danger">*</span></label>
                            <input type="number" name="square_meters" class="form-control" required>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <input type="text" name="status" class="form-control" required>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="main_image" class="form-label">Immagine</label>
                            <input type="file" name="main_image" class="form-control" required>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="image[]" class="form-label">Immagine</label>
                            <input type="file" name="image[]" class="form-control" multiple>
                        </div>
                        @foreach ($services as $service)
                            <div class="mb-3 col-3">
                                <div class="form-check">
                                    <input type="checkbox" name="services[]" value="{{ $service->id }}"
                                        class="form-check-input" id="service-{{ $service->id }}">
                                    <label class="form-check-label"
                                        for="service-{{ $service->id }}">{{ $service->service_name }} <i
                                            class="{{ $service->service_icon }}"></i></label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-success">Crea Appartamento</button>
                </form>
            </div>
        </div>
    </div>
@endsection
