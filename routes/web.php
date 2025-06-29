<?php

use App\Models\Book;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    $books = Book::latest()
        ->filter(request(['search', 'category', 'penulis']))
        ->paginate(8)
        ->withQueryString();
    return view('index', ['books' => $books, 'title' => 'Toko Buku']);
});

// Route::resource('/dashboard', DashboardController::class)->middleware('auth')->parameters(['dashboard' => 'book']);

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{book:slug}', function (Book $book) {
    return view('book', [
        'title' => 'Book Detail - ' . $book->judul,
        'book'  => $book
    ]);
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
// Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware(('guest'));
Route::post('/register', [RegisterController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang', [CartController::class, 'store'])->name('keranjang.store');
    Route::patch('/keranjang/{item}', [CartController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{keranjang}', [CartController::class, 'destroy'])->name('keranjang.destroy');

    Route::resource('/dashboard', DashboardController::class)->middleware('auth')->parameters(['dashboard' => 'book']);
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::middleware('auth')->group(function () {

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/{book}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{book}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::post('/wishlist/toggle/{book}', [WishlistController::class, 'toggle'])->middleware('auth')->name('wishlist.toggle');
});
