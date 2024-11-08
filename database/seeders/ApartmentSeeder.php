<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Apartment;
use Illuminate\Support\Facades\File;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Percorso del file JSON
        $jsonPath = database_path('data/italy_apartments_100.json');

        // Controlla se il file esiste e carica il contenuto JSON
        if (File::exists($jsonPath)) {
            $data = json_decode(File::get($jsonPath), true);

            // Inserisci ogni appartamento nel database
            foreach ($data as $apartment) {
                Apartment::create($apartment);
            }
        } else {
            echo "Il file JSON non è stato trovato!";
        }
    }
}
