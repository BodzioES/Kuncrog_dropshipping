<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Productimage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductPageController extends Controller
{
    public function show(Product $product): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $productImages = $product->images()->orderByDesc('is_main')->get();
        return view('product_page.show',compact('product','productImages'));
    }
}
