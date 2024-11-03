<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                'service_name' => 'WiFi',
                'service_icon' => 'fa-solid fa-wifi',
            ],
            [
                'service_name' => 'Piscina',
                'service_icon' => 'fa-solid fa-person-swimming',
            ],
            [
                'service_name' => 'Posto auto',
                'service_icon' => 'fa-solid fa-square-parking',
            ],
            [
                'service_name' => 'Aria condizionata',
                'service_icon' => 'fa-solid fa-snowflake',
            ],
            [
                'service_name' => 'Ascensore',
                'service_icon' => 'fa-solid fa-elevator',
            ],
            [
                'service_name' => 'Cucina',
                'service_icon' => 'fa-solid fa-fire-burner',
            ],
            [
                'service_name' => 'Lavatrice',
                'service_icon' => 'fa-solid fa-jug-detergent',
            ],
            [
                'service_name' => 'Giardino',
                'service_icon' => 'fa-solid fa-tree',
            ],
            [
                'service_name' => 'Smart TV',
                'service_icon' => 'fa-solid fa-tv',
            ],
            [
                'service_name' => 'Allarme',
                'service_icon' => 'fa-solid fa-bell',
            ],
            [
                'service_name' => 'Riscaldamento',
                'service_icon' => 'fa-solid fa-temperature-arrow-up',
            ],
            [
                'service_name' => 'Domotica',
                'service_icon' => 'fa-solid fa-robot',
            ],
            [
                'service_name' => 'Vista mare',
                'service_icon' => 'fa-solid fa-water',
            ],
            [
                'service_name' => 'Servizio di pulizie',
                'service_icon' => 'fa-solid fa-broom',
            ],
            [
                'service_name' => 'Divieto di fumo',
                'service_icon' => 'fa-solid fa-ban-smoking',
            ],
            [
                'service_name' => 'Pet friendly',
                'service_icon' => 'fa-solid fa-paw',
            ],
            [
                'service_name' => 'No animali',
                'service_icon' => 'fa-solid fa-ban',
            ],
            [
                'service_name' => 'Palestra',
                'service_icon' => 'fa-solid fa-dumbell',
            ],
        ];

        foreach ($services as $service) {
            $newService = new Service();
            $newService->service_name = $service['service_name'];
            $newService->service_icon = $service['service_icon'];
            $newService->save();
        }
    }
}
