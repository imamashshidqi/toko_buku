<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;
    protected $fillable = [
        'judul',
        'id_penulis',
        'id_kategori',
        'harga',
        'stok',
        'deskripsi',
        'cover_image',
        'rating',
        'slug',
        'terbit'
    ];
    protected $with = ['penulis', 'category'];

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_penulis');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_kategori');
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('judul', 'like', '%' . $search . '%');
        });

        $query->when($filters['category'] ?? false, function ($query, $category) {
            return $query->whereHas(
                'category',
                fn(Builder $query) =>
                $query->where('slug', $category)
            );
        });

        $query->when($filters['penulis'] ?? false, function ($query, $penulis) {
            return $query->whereHas(
                'penulis',
                fn(Builder $query) =>
                $query->where('username', $penulis)
            );
        });
    }
}
