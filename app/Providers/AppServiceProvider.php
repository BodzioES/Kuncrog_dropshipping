<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cart;
use App\Models\Product;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        //przekazuje to ilosc produktow w koszyku do layouts (do tej czerwonej kropki przy ikonie koszyka)
        View::composer('*', function ($view) {
            $cartCount = 0;

            if (Auth::check()) {
                $cartCount = Cart::where('id_user', Auth::id())->sum('quantity');
            } else {
                $cart = session()->get('cart', []);
                foreach ($cart as $item) {
                    $cartCount += $item['quantity'] ?? 1;
                }
            }

            $view->with('cartCount', $cartCount);
        });
    }
}
