<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->foreignId('id_penulis')->constrained(
                table: 'users',
                indexName: 'books_id_penulis',
            );
            $table->foreignId('id_kategori')->constrained(
                table: 'categories',
                indexName: 'books_id_kategori',
            );
            $table->decimal('harga', 10, 2);
            $table->decimal('rating')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->date('terbit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
