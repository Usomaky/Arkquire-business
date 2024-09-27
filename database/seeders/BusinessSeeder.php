<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Business::factory(50)->create()
        ->each(function ($business) {
            \App\Models\Image::factory(6)->create([
                'imageable_id' => $business->id,
                'imageable_type' => get_class($business),
            ]);
        });
    }
}
