<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{


    public function index(){
        $cart = Auth::check()
            ?
            : session()->get('cart',[]);

        return view('checkout.index',[]);
    }

    public function store(Request $request){

    }
}
