<?php

namespace App\Http\Controllers;

use App\Models\Visitors;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class VisitorsController extends Controller
{
    public function index(){

        $visitors = Visitors::all()->map(function($visitor){

            // geolokalizacja jest cachowana przez 7 dni zeby nie odpalac zewnetrznego
            // HTTP przy kazdym wejsciu na strone (szybciej i bez dodatkowych zapytan do API)
            $geo = Cache::remember('visitor_geo_' . $visitor->ip_address, now()->addDays(7), function () use ($visitor) {
                try {
                    $response = Http::timeout(5)->get("https://ipwhois.app/json/{$visitor->ip_address}");

                    if ($response->ok()) {
                        $data = $response->json();
                        return [
                            'country' => $data['country'] ?? 'Nieznany',
                            'city' => $data['city'] ?? 'Nieznane',
                        ];
                    }
                } catch (\Throwable $e) {
                    // brak dostepu do API - zwracamy wartosci domyslne
                }

                return [
                    'country' => 'Nieznany',
                    'city' => 'Nieznane',
                ];
            });

            $visitor->country = $geo['country'];
            $visitor->city = $geo['city'];

            return $visitor;
        });


        return view('admin.visitors.index',compact('visitors'));
    }
}
