<?php

namespace App\Providers;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL; //to jest biblioteka do tego config co jest zaraz pod bootem
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cart;
use App\Models\Visitors;

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
        //to jest po to aby serwer uzywal adresu www.kuncrog.pl zamiast adresu ip raspberry
        //dzieki temu route dziala poprawnie i przekieruje na http://www.kuncrog.pl/cart/list zamiast http://192.168.1.115/cart/list
        if (config('app.env') === 'production') {
            URL::forceRootUrl(config('app.url'));
        }

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

        //  POBIERA ADRES IP OD UZYTKOWNIKA KTORY WEJDZIE NA STRONE
        $ip = request()->ip();

        //  SPRAWDZA CZY ADRES JEST JUZ W BAZIE JAK NIE TO GO DODAJE
        Visitors::firstOrCreate(['ip_address' => $ip]);


        // liczy unikalne IP (cache na 60s, żeby nie mielić bazy)
        /*
         * Służy do cache’owania wyniku zapytania, żeby za każdym razem nie liczyć od nowa
         * przez godzinę wynik będzie brany z cache, zamiast pytać bazę. Po godzinie wynik się przeliczy i zapisze na nowo
         *
         * */
        $visitorsCount = Cache::remember('visitors_count',60, function () {
            return Visitors::count('ip_address');
        });

        // udostępnia liczbę adresow ip do WSZYSTKICH WIDOKÓW
        view()->share('visitorsCount', $visitorsCount);
    }
}
