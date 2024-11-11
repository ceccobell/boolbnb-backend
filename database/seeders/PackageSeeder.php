<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('packages')->insert([
            [
                'package_name' => 'Basic',
                'price' => 2.99,
                'hours' => 24,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'package_name' => 'Standard',
                'price' => 5.99,
                'hours' => 72,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'package_name' => 'Premium',
                'price' => 9.99,
                'hours' => 144,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
