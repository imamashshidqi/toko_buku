<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Majalah',
            'slug' => 'majalah',
            'color' => 'bg-red-100'
        ]);

        Category::create([
            'name' => 'Komik',
            'slug' => 'komik',
            'color' => 'bg-green-100'
        ]);

        Category::create([
            'name' => 'Romansa',
            'slug' => 'romansa',
            'color' => 'bg-blue-100'
        ]);
    }
}
