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

        //przekazuje to aktualna ilosc produktow w koszyku do layouts (do tej czerwonej kropki przy ikonie koszyka)
        // dzieki temu przy pierwszym zaladowniu strony dziala licnzik w tej ikonce koszyka
        // bez tego by to nie dzialalo dopoki nie odpalil by sie jakikolwiek ajax ktory aktualizuje w bez przeladowania ten koszyk
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

            //zwraca zmienna $cartCount do app.blade.php
            $view->with('cartCount', $cartCount);
        });
    }
}
