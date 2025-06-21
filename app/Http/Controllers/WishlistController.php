<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Book;
use Illuminate\Http\Request; // Ditambahkan jika Anda memerlukan Request object, meskipun tidak digunakan di kode saat ini
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        // Pastikan view 'wishlist.index' ada di resources/views/wishlist/index.blade.php
        $wishlists = Wishlist::with('book')->where('user_id', Auth::id())->get();
        return view('wishlist', [
            'wishlists' => $wishlists,
            'title' => 'Favorit Saya'
        ]);
    }

    public function store(Request $request, Book $book)
    {
        // Menggunakan firstOrCreate untuk menghindari duplikasi
        Wishlist::firstOrCreate([
            'user_id' => Auth::id(),
            'book_id' => $book->id
        ]);

        return redirect()->back()->with('success', 'Buku ditambahkan ke wishlist.');
    }

    public function destroy(Request $request, Book $book)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->delete();

        return redirect()->back()->with('success', 'Buku dihapus dari wishlist.');
    }

    // Di dalam WishlistController.php
    public function toggle(Book $book)
    {
        // Cari item wishlist
        $wishlistItem = Wishlist::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->first();

        // Jika item sudah ada di wishlist, hapus
        if ($wishlistItem) {
            $wishlistItem->delete();
            return back()->with('success', 'Buku dihapus dari wishlist.');
        }
        // Jika belum ada, tambahkan
        else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'book_id' => $book->id,
            ]);
            return back()->with('success', 'Buku ditambahkan ke wishlist.');
        }
    }
}
