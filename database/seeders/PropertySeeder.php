<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Business properties
        \App\Models\Property::factory(1)->create(['property_name' => 'None']);
        \App\Models\Property::factory(1)->create(['property_name' => 'Rented office']);
        \App\Models\Property::factory(1)->create(['property_name' => 'Shop']);
        \App\Models\Property::factory(1)->create(['property_name' => 'Workspace']);
    }
}
