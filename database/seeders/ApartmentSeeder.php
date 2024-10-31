<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Apartment;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $apartments_data = [
            [
                'user_id' => 1,
                'slug' => 'appartamento-1',
                'property' => 'Appartamento Privato',
                'city' => 'Roma',
                'address' => 'Via Roma, 1',
                'description' => 'Un appartamento accogliente nel centro di Roma.',
                'n_rooms' => 3,
                'n_beds' => 2,
                'n_bathrooms' => 1,
                'square_meters' => '80',
                'latitude' => 41.90,  
                'longitude' => 12.49, 
                'status' => 'disponibile',
            ],
            [
                'user_id' => 2,
                'slug' => 'appartamento-2',
                'property' => 'Studio',
                'city' => 'Milano',
                'address' => 'Corso Milano, 2',
                'description' => 'Uno studio moderno in zona centrale.',
                'n_rooms' => 1,
                'n_beds' => 1,
                'n_bathrooms' => 1,
                'square_meters' => '30',
                'latitude' => 45.46, 
                'longitude' => 9.19, 
                'status' => 'disponibile',
            ],
            [
                'user_id' => 3,
                'slug' => 'appartamento-3',
                'property' => 'Bilocale',
                'city' => 'Firenze',
                'address' => 'Via Firenze, 3',
                'description' => 'Un bilocale elegante con vista sulla città.',
                'n_rooms' => 2,
                'n_beds' => 2,
                'n_bathrooms' => 1,
                'square_meters' => '60',
                'latitude' => 43.77, 
                'longitude' => 11.25, 
                'status' => 'disponibile',
            ],
            [
                'user_id' => 1,
                'slug' => 'appartamento-4',
                'property' => 'Appartamento Familiare',
                'city' => 'Napoli',
                'address' => 'Via Napoli, 4',
                'description' => 'Ideale per famiglie, spazioso e ben arredato.',
                'n_rooms' => 4,
                'n_beds' => 3,
                'n_bathrooms' => 2,
                'square_meters' => '100',
                'latitude' => 40.85, 
                'longitude' => 14.27, 
                'status' => 'non disponibile',
            ],
            [
                'user_id' => 2,
                'slug' => 'appartamento-5',
                'property' => 'Appartamento in Centro',
                'city' => 'Torino',
                'address' => 'Via Torino, 5',
                'description' => 'Vicino ai principali punti di interesse.',
                'n_rooms' => 2,
                'n_beds' => 2,
                'n_bathrooms' => 1,
                'square_meters' => '55',
                'latitude' => 45.07, 
                'longitude' => 7.69, 
                'status' => 'disponibile',
            ],
            [
                'user_id' => 3,
                'slug' => 'appartamento-6',
                'property' => 'Attico',
                'city' => 'Bologna',
                'address' => 'Via Bologna, 6',
                'description' => 'Attico con terrazzo panoramico.',
                'n_rooms' => 3,
                'n_beds' => 3,
                'n_bathrooms' => 2,
                'square_meters' => '90',
                'latitude' => 44.49, 
                'longitude' => 11.34,
                'status' => 'disponibile',
            ],
        ];

        foreach ($apartments_data as $apartment) {
            Apartment::create($apartment);
        }
    }
}
