<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Container\Attributes\Storage;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::latest()
            ->filter(request(['search', 'category', 'penulis']))
            ->paginate(6)
            ->withQueryString();

        $categories = Category::all();

        return view('dashboard.index', [
            'title' => 'Book Page',
            'books' => $books,
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.createBook');
    }

    public function store(Request $request)
    {
        // Blok validasi dari Langkah 1
        $validated = $request->validate([
            'judul'       => 'required|max:255',
            'deskripsi'   => 'required',
            'harga'       => 'required|numeric|min:10000',
            'id_penulis'  => 'required|exists:users,id',
            'id_kategori' => 'required|exists:categories,id',
            'rating'      => 'required|numeric|min:1|max:5',
            'cover_image' => 'image|file|max:2048'
        ]);

        // Baris ini menambahkan 'terbit' ke array
        $validated['terbit'] = now();
        $validated['slug'] = Str::slug($validated['judul']);

        if ($request->file('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('img/books', 'public');
        }

        // HENTIKAN DAN TAMPILKAN ISI DARI $validated
        // dd($validated);

        // Kode di bawah ini tidak akan dijalankan untuk sementara
        Book::create($validated);

        return redirect()->route('dashboard.index')->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('dashboard.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('dashboard.update', [
            'book' => $book
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $rules = [
            'judul'       => 'required|max:255',
            'deskripsi'   => 'required',
            'harga'       => 'required|numeric|min:10000',
            'rating'      => 'required|numeric|min:1|max:5',
            'id_kategori' => 'required|exists:categories,id',
            'cover_image' => 'image|file|max:2048'
        ];

        $validatedData = $request->validate($rules);
        if ($request->file('cover_image')) {
            // Hapus gambar LAMA jika ada
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            // Simpan gambar BARU & timpa path di data validasi
            $validatedData['cover_image'] = $request->file('cover_image')->store('img/books', 'public');
        }

        $book->update($validatedData);

        return redirect()->route('dashboard.index')->with('success', 'Buku berhasil di-update.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('dashboard.index')->with('success', 'book deleted successfully.');
    }
}
