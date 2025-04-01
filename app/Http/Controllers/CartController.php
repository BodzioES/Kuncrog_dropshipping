<?php

namespace App\Http\Controllers;


use App\Dtos\Cart\CartDto;
use App\Dtos\Cart\CartItemDto;
use App\Models\Product;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('home');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function store(Product $product): JsonResponse
    {
        $cart = Session::get('cart', new CartDto());
        $items = $cart->getItems();
        if (Arr::exists($items, $product->id)) {
            $items[$product->id]->incrementQuantity();
        }else{
            $cartItemDto = new CartItemDto();
            $cartItemDto->setProductId($product->id);
            $cartItemDto->setProductName($product->name);
            $cartItemDto->setProductPrice($product->price);
            $cartItemDto->setImage($product->image);
            $cartItemDto->setQuantity(1);
            $items[$product->id] = $cartItemDto;
        }
        $cart->incrementTotalQuantity();
        $cart->incrementTotalSum($product->price);

        Session::put('cart',[$cart]);
        return response()->json([
            'status' => 'success',
        ]);
    }
}
