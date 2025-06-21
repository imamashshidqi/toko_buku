<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', ['title' => 'Login']);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Cek nilai kolom is_admin
            if ($user->is_admin) { // atau bisa juga: if ($user->is_admin == 1)
                // Jika admin, arahkan ke dashboard.
                // intended() akan mengarahkan ke halaman yang ingin dituju sebelum login,
                // jika tidak ada, default-nya ke '/dashboard'.
                return redirect()->intended('/dashboard');
            }

            // Jika bukan admin, arahkan ke halaman utama (index)
            return redirect('/');
        }

        return back()->withErrors([
            'username' => 'username salah bro!',
        ])->onlyInput('username');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
