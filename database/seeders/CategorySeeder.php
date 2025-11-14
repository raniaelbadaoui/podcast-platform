<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Technology', 'slug' => 'technology', 'description' => 'Tech podcasts'],
            ['name' => 'Business', 'slug' => 'business', 'description' => 'Business podcasts'],
            ['name' => 'Education', 'slug' => 'education', 'description' => 'Educational podcasts'],
            ['name' => 'Entertainment', 'slug' => 'entertainment', 'description' => 'Entertainment podcasts'],
            ['name' => 'Health', 'slug' => 'health', 'description' => 'Health and wellness podcasts'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
