<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Provider;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $providers = [
            'Proveedor A',
            'Proveedor B',
            'Proveedor C',
            'Proveedor D',
            'Proveedor E',
            'Proveedor F',
            'Proveedor G',
            'Proveedor H',
            'Proveedor I',
            'Proveedor J'
        ];

        foreach ($providers as $provider) {
            Provider::create(['name' => $provider]);
        }
    }
}
