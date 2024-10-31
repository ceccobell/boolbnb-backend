<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users_data = [
            [
                'name' => 'Gioele',
                'surname' => 'Miscia',
                'email' => 'gioele.miscia@boolbnb.com',
                'password' => 'password.Gioele',
            ],
            [
                'name' => 'Roberto',
                'surname' => 'Ledda',
                'email' => 'roberto.ledda@boolbnb.com',
                'password' => 'password.Roberto',
            ],
            [
                'name' => 'Francesco',
                'surname' => 'Bellingeri',
                'email' => 'francesco.bellingeri@boolbnb.com',
                'password' => 'password.Francesco',
            ],
            [
                'name' => 'Andrea',
                'surname' => 'Romeo',
                'email' => 'andrea.romeo@boolbnb.com',
                'password' => 'password.Andrea',
            ],
            [
                'name' => 'Rivaldo',
                'surname' => 'Gjoni',
                'email' => 'rivaldo.gjoni@boolbnb.com',
                'password' => 'password.Rivaldo',
            ],
        ];

        foreach ($users_data as $user) {
            $user['password'] = Hash::make($user['password']);  // password cript
            User::create($user);
        }
    }
}
