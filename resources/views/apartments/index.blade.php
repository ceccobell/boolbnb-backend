@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($apartments as $apartment)
                <div class="col-3">
                    <div class="card">
                        <h5 class="card-title">{{ $apartment['title'] }}</h5>
                        <p class="card-text">{{ $apartment['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection