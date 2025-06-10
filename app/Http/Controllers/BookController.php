<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use PhpParser\Node\Expr\AssignOp\Pow;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::latest()
            ->filter(request(['search', 'category', 'penulis']))
            ->paginate(8)
            ->withQueryString();

        return view('books', [
            'title' => 'Book Page',
            'books' => $books
        ]);
    }
}
