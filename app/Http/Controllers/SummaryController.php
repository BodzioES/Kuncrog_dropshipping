<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SummaryController extends Controller
{
    public function index(){
        return view('checkout.summary',[]);
    }

    public function store(Request $request){

    }
}
