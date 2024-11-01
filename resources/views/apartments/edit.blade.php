@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifica Appartamento</h1>
        <form action="{{ route('apartments.update', $apartment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="property" class="form-label">Proprietà</label>
                <input type="text" name="property" class="form-control" value="{{ $apartment->property }}" required>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">Città</label>
                <input type="text" name="city" class="form-control" value="{{ $apartment->city }}" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Indirizzo</label>
                <input type="text" name="address" class="form-control" value="{{ $apartment->address }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descrizione</label>
                <textarea name="description" class="form-control" required>{{ $apartment->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Prezzo</label>
                <input type="number" name="price" class="form-control" value="{{ $apartment->price }}" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Nuova Immagine (opzionale)</label>
                <input type="file" name="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Aggiorna Appartamento</button>
        </form>
    </div>
@endsection
