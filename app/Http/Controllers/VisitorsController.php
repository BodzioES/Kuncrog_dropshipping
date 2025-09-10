<?php

namespace App\Http\Controllers;

use App\Models\Visitors;
use Illuminate\Support\Facades\Http;

class VisitorsController extends Controller
{
    public function index(){

        $visitors = Visitors::all()->map(function($visitor){

            $response = Http::get("https://ipwhois.app/json/$visitor->ip_address");

            if($response->ok()){
                $data = $response->json();
                $visitor->country = $data['country'] ?? "Nieznany";
                $visitor->city = $data['city'] ?? "Nieznane";
            }else{
                $visitor->country = 'blad api';
                $visitor->city = ' - ';
            }

            return $visitor;
        });


        return view('admin.visitors.index',compact('visitors'));
    }
}
