<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View; // <-- PASTIKAN 'V' BESAR
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['components.navbar', 'components.navbar-dashboard'], function ($view) {
            $cartCount = 0;
            if (Auth::check()) {
                $cartCount = Cart::where('user_id', Auth::id())->count();
            }
            $view->with('cartCount', $cartCount);
        });
    }
}
