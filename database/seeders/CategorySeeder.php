<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Business categories
        \App\Models\Category::factory(1)->create(['category_name' => 'E-commerce']);
        \App\Models\Category::factory(1)->create(['category_name' => 'SaaS']);
        \App\Models\Category::factory(1)->create(['category_name' => 'Health and Wellness']);
        \App\Models\Category::factory(1)->create(['category_name' => 'Travel and Tourism']);
        \App\Models\Category::factory(1)->create(['category_name' => 'Food and Beverage']);
        \App\Models\Category::factory(1)->create(['category_name' => 'Fashion and Apparel']);
        \App\Models\Category::factory(1)->create(['category_name' => 'Real Estate']);
        \App\Models\Category::factory(1)->create(['category_name' => 'Renewable Energy']);
        \App\Models\Category::factory(1)->create(['category_name' => 'Automobile']);
        \App\Models\Category::factory(1)->create(['category_name' => 'Entertainment and Media']);
        \App\Models\Category::factory(1)->create(['category_name' => 'Sports and Fitness']);
        \App\Models\Category::factory(1)->create(['category_name' => 'Social Networking']);
        \App\Models\Category::factory(1)->create(['category_name' => 'Beauty and Personal Care']);
        \App\Models\Category::factory(1)->create(['category_name' => 'Event Management']);
        \App\Models\Category::factory(1)->create(['category_name' => 'Others']);
    }
}
