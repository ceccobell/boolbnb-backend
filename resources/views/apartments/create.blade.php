@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Aggiungi Appartamento</h1>
        <form action="{{ route('apartments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="property" class="form-label">Proprietà</label>
                <input type="text" name="property" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">Città</label>
                <input type="text" name="city" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Indirizzo</label>
                <input type="text" name="address" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descrizione</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Prezzo</label>
                <input type="number" name="price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Immagine</label>
                <input type="file" name="image" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Crea Appartamento</button>
        </form>
    </div>
@endsection
