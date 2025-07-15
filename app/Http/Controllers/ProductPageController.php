<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductPageController extends Controller
{
    public function show(Product $product): View
    {
        return view('product_page.show',compact('product'));
    }


}
