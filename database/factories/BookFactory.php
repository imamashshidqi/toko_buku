<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $judul = fake()->sentence(rand(6, 8));
        return [
            'judul' => $judul,
            'id_penulis' => User::factory(),
            'id_kategori' => Category::factory(),
            'harga' => fake()->numberBetween(5, 100) * 10000,
            'stok' => fake()->numberBetween(0, 100),
            'rating' => fake()->numberBetween(1, 5),
            'deskripsi' => fake()->paragraph(rand(3, 5)),
            'slug' => Str::slug($judul),
            'terbit' => fake()->date(),
        ];
    }
}
