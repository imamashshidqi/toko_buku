<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() // This method handles GET requests to /books
    {
        $books = Book::latest()
            ->filter(request(['search', 'category', 'penulis']))
            ->paginate(6)
            ->withQueryString();

        return view('dashboard.index', [
            'title' => 'Book Page', // Add the title here!
            'books' => $books
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.createBook');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

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
        return view('dashboard.edit', ['book' => $book]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);
        $book->update($validated);
        return redirect()->route('dashboard.index')->with('success', 'book updated successfully.');
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
