<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Bug Fix', 'color' => '#FF0000'],
            ['name' => 'Feature', 'color' => '#00FF00'],
            ['name' => 'Documentation', 'color' => '#0000FF'],
            ['name' => 'Enhancement', 'color' => '#FFA500'],
            ['name' => 'Maintenance', 'color' => '#800080']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}