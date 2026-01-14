<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\Income;
use App\Models\Provider;
use Faker\Factory as Faker;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $providers = Provider::all();

        for ($i = 0; $i < 50; $i++) {
            Income::create([
                'provider_id' => $providers->random()->id,
                'amount' => $faker->randomFloat(2, 100, 10000),
                'concept' => $faker->randomElement(['Venta', 'Servicio', 'Producto', 'Consultoría']),
                'date' => $faker->dateTimeBetween('-3 months', 'now'),
                'description' => $faker->sentence()
            ]);
        }
    }
}
