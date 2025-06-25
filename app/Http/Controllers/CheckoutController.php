<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class CheckoutController extends Controller
{


    public function index(){
        if (Auth::check()) {
            $cartItems = Cart::with('product')
                ->where('id_user', Auth::id())
                ->get()
                ->map(function ($item) {
                    return (object)[
                        'id' => $item->id,
                        'name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                        'image' => $item->product?->image,
                    ];
                });
            $isGuest = false;
        } else {
            $cart = session()->get('cart', []);
            $cartItems = [];

            foreach ($cart as $productId => $details) {
                $product = Product::find($productId);
                if ($product && is_array($details)) {
                    $cartItems[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $details['quantity'] ?? 1,
                        'image' => $product->image,
                    ];
                }
            }
            $isGuest = true;
        }

        $totalProductPrice = 0;
        foreach ($cartItems as $item) {
            $price = is_array($item) ? $item['price'] : $item->price;
            $quantity = is_array($item) ? $item['quantity'] : $item->quantity;
            $totalProductPrice += $price * $quantity;
        }

        return view('checkout.index',compact('cartItems','isGuest','totalProductPrice'));
    }

    public function store(Request $request){

    }
}
