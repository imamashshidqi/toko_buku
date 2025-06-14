<?php

use App\Models\Book;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    $books = Book::latest()
        ->filter(request(['search', 'category', 'penulis']))
        ->paginate(8)
        ->withQueryString();
    return view('index', ['books' => $books, 'title' => 'Toko Buku']);
});

Route::resource('/dashboard', DashboardController::class)->middleware('auth')->parameters(['dashboard' => 'book']);

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{book:slug}', function (Book $book) {
    return view('book', [
        'title' => 'Book Detail - ' . $book->judul,
        'book'  => $book
    ]);
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware(('guest'));
Route::post('/register', [RegisterController::class, 'store']);
