@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Appartamenti</h1>
        <a href="{{ route('apartments.create') }}" class="btn btn-primary mb-3">Aggiungi Appartamento</a>
        <div class="row">
            @foreach ($apartments as $apartment)
                <div class="col-3">
                    <div class="card">
                        <img src="{{ $apartment->getMainImageUrlAttribute() }}" class="card-img-top"
                            alt="{{ $apartment->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $apartment->title }}</h5>
                            <p class="card-text">{{ $apartment->description }}</p>
                            <a href="{{ route('apartments.show', $apartment->id) }}" class="btn btn-info">Visualizza</a>
                            <a href="{{ route('apartments.edit', $apartment->id) }}" class="btn btn-warning">Modifica</a>
                            <form action="{{ route('apartments.destroy', $apartment->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Sei sicuro di voler eliminare questo appartamento?')">Elimina</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
