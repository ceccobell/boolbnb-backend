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
                    <input type="text" name="title" class="form-control" value="{{ old('title', $apartment->title) }}">
                </div>
                <div class="mb-3 col-6">
                    <label for="property" class="form-label">Proprietà <span class="text-danger">*</span></label>
                    <input type="text" name="property" class="form-control"
                        value="{{ old('property', $apartment->property) }}">
                </div>
                <div class="mb-3 col-12">
                    <label for="address" class="form-label">Città ed indirizzo<span class="text-danger">*</span></label>
                    <input type="text" name="address" id="address" class="form-control"
                        value="{{ old('address', $apartment->address) }}">
                    <ul id="address-suggestions" class="list-group" style="display: none;"></ul>
                </div>
                <div class="mb-3 col-12">
                    <label for="description" class="form-label">Descrizione</label>
                    <textarea name="description" class="form-control">{{ old('description', $apartment->description) }}</textarea>
                </div>
                <div class="mb-3 col-3">
                    <label for="n_rooms" class="form-label">Numero Camere <span class="text-danger">*</span></label>
                    <input type="number" min="1" name="n_rooms" class="form-control" required
                        {{ old('n_rooms', $apartment->n_rooms) }}>
                </div>
                <div class="mb-3 col-3">
                    <label for="n_beds" class="form-label">Posti letto <span class="text-danger">*</span></label>
                    <input type="number" min="1" name="n_beds" class="form-control" required
                        {{ old('n_beds', $apartment->n_beds) }}>
                </div>
                <div class="mb-3 col-3">
                    <label for="n_bathrooms" class="form-label">Numero bagni <span class="text-danger">*</span></label>
                    <input type="number" min="1" name="n_bathrooms" class="form-control" required
                        {{ old('n_bathrooms', $apartment->n_bathrooms) }}>
                </div>
                <div class="mb-3 col-3">
                    <label for="square_meters" class="form-label">Metri quadri <span class="text-danger">*</span></label>
                    <input type="number" name="square_meters" class="form-control" required
                        {{ old('square_meters', $apartment->square_meters) }}>
                </div>
                <div class="mb-3 col-4">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control" id="">
                        <option value="Disponibile" {{ $apartment->status == 'Disponibile' ? 'selected' : '' }}>
                            Disponibile</option>
                        <option value="Non Disponibile" {{ $apartment->status == 'NonDisponibile' ? 'selected' : '' }}>
                            Non Disponibile</option>
                    </select>
                </div>
                <div class="mb-3 col-6">
                    <label for="main_image" class="form-label">Immagine Copertina</label>
                    <input type="file" name="main_image" class="form-control">
                </div>
                <div class="mb-3 col-6">
                    <label for="image[]" class="form-label">Altre Immagini</label>
                    <input type="file" name="image[]" class="form-control" multiple>
                </div>
                @foreach ($services as $service)
                    <div class="mb-3 col-3">
                        <div class="form-check">
                            <input type="checkbox" name="services[]" value="{{ $service->id }}" class="form-check-input"
                                id="service-{{ $service->id }}"
                                {{ $apartment->services->contains($service->id) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="service-{{ $service->id }}">{{ $service->service_name }}
                                <i class="{{ $service->service_icon }}"></i></label>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-success">Aggiorna Appartamento</button>
        </form>
    </div>
    <script>
        document.getElementById('address').addEventListener('input', function() {
            const query = this.value;
            const suggestionsList = document.getElementById('address-suggestions');

            if (query.length < 3) {
                suggestionsList.style.display = 'none';
                return;
            }

            // Invia una richiesta GET per ottenere i suggerimenti usando Axios
            axios.get(`/api/get-address-suggestions`, {
                    params: {
                        query: query
                    }
                })
                .then(response => {
                    const suggestions = response.data.results;
                    suggestionsList.innerHTML = ''; // Pulisce la lista dei suggerimenti

                    if (suggestions.length > 0) {
                        // Aggiunge i suggerimenti alla lista
                        suggestions.forEach(suggestion => {
                            const li = document.createElement('li');
                            li.classList.add('list-group-item');
                            li.classList.add('cursor-pointer');
                            li.textContent = suggestion.address.freeformAddress;
                            li.onclick = function() {
                                document.getElementById('address').value = suggestion.address
                                    .freeformAddress;
                                suggestionsList.style.display = 'none';
                            };
                            suggestionsList.appendChild(li);
                        });
                        suggestionsList.style.display = 'block'; // Mostra la lista
                    } else {
                        suggestionsList.style.display = 'none'; // Nasconde la lista se non ci sono suggerimenti
                    }
                })
                .catch(error => {
                    console.error('Errore nella richiesta dei suggerimenti:', error);
                    suggestionsList.style.display = 'none'; // Nasconde la lista in caso di errore
                });
        });
    </script>
@endsection
