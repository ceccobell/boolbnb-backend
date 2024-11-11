@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center fs-5">{{ __('Registrati') }}</div>

                    <div class="card-body">
                        <form id="registrationForm" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="col-12 pb-3">
                                <span class="text-danger">Tutti i campi sono * obbligatori</span>
                            </div>

                            <div class="mb-4 row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    <span class="invalid-feedback" role="alert"></span>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Cognome') }}<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input id="surname" type="text" class="form-control" name="surname"
                                        value="{{ old('surname') }}" required autocomplete="surname">
                                    <span class="invalid-feedback" role="alert"></span>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">
                                    <span class="invalid-feedback" role="alert"></span>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required
                                        autocomplete="new-password">
                                    <span class="invalid-feedback" role="alert"></span>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password') }}<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="mb-4 row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary"
                                        id="submitBtn">{{ __('Registrati') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#registrationForm').on('submit', function(e) {
                e.preventDefault(); // Evita il refresh della pagina

                // Reset degli errori
                $('.invalid-feedback').text('').hide();
                $('.form-control').removeClass('is-invalid');

                // Ottieni i dati della form
                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.message) {
                            // Successo! Mostra un messaggio di successo
                            alert('Registrazione avvenuta con successo');
                            window.location.href = '/'; // O una pagina di destinazione
                        }
                    },
                    error: function(response) {
                        if (response.status === 422) { // Se la validazione fallisce
                            var errors = response.responseJSON.errors;
                            for (var field in errors) {
                                $('#' + field).addClass(
                                    'is-invalid'); // Aggiungi la classe di errore
                                $('#' + field).next('.invalid-feedback').text(errors[field][0])
                                    .show();
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
