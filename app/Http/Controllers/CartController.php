<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Menampilkan halaman keranjang
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('book')->get();
        return view('keranjang', [
            'title'     => 'Keranjang Belanja',
            'cartItems' => $cartItems
        ]);
    }

    // Menambah item ke keranjang
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('book_id', $request->book_id)
            ->first();

        if ($cartItem) {
            // Jika buku sudah ada di keranjang, tambahkan quantity
            $cartItem->increment('quantity');
        } else {
            // Jika belum ada, buat entri baru
            Cart::create([
                'user_id' => Auth::id(),
                'book_id' => $request->book_id,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', 'Buku berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $item)
    {
        // Pastikan item ini milik user yang sedang login
        if ($item->user_id !== Auth::id()) {
            return back()->with('error', 'Aksi tidak diizinkan.');
        }

        // Validasi action dari form
        $request->validate([
            'action' => 'required|in:increase,decrease'
        ]);

        if ($request->action === 'increase') {
            $item->increment('quantity');
        } elseif ($request->action === 'decrease') {
            if ($item->quantity > 1) {
                $item->decrement('quantity');
            } else {
                // Jika kuantitas 1 dan dikurangi, hapus item dari keranjang
                $item->delete();
                return back()->with('success', 'Buku berhasil dihapus dari keranjang.');
            }
        }

        return back()->with('success', 'Kuantitas berhasil diperbarui.');
    }

    // Menghapus item dari keranjang
    public function destroy(Cart $keranjang)
    {
        // Pastikan item yang akan dihapus adalah milik user yang sedang login
        if ($keranjang->user_id !== Auth::id()) {
            return back()->with('error', 'Aksi tidak diizinkan.');
        }

        $keranjang->delete();
        return back()->with('success', 'Buku berhasil dihapus dari keranjang.');
    }
}
