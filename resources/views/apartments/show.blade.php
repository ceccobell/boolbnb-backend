@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $apartment->title }}</h1>
        <img src="{{ $apartment->getMainImageUrlAttribute() }}" class="img-fluid" alt="{{ $apartment->title }}">
        <p><strong>Proprietà:</strong> {{ $apartment->property }}</p>
        <p><strong>Città:</strong> {{ $apartment->city }}</p>
        <p><strong>Indirizzo:</strong> {{ $apartment->address }}</p>
        <p><strong>Descrizione:</strong> {{ $apartment->description }}</p>
        <p><strong>Prezzo:</strong> {{ $apartment->price }} €</p>
        <a href="{{ route('apartments.edit', $apartment->id) }}" class="btn btn-warning">Modifica</a>
        <form action="{{ route('apartments.destroy', $apartment->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"
                onclick="return confirm('Sei sicuro di voler eliminare questo appartamento?')">Elimina</button>
        </form>
        <a href="{{ route('apartments.index') }}" class="btn btn-secondary">Torna alla lista</a>
    </div>
@endsection
