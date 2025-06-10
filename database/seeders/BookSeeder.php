<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::factory(30)->recycle([
            Category::all(),
            User::all()
        ])->create();
    }
}
