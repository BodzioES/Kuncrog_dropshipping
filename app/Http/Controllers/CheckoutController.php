<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\ShippingMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Nette\Schema\ValidationException;

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

        $shippingMethods = ShippingMethod::all();
        $paymentMethods = PaymentMethod::all();


        return view('checkout.index',compact(
            'cartItems',
            'isGuest',
            'totalProductPrice',
            'shippingMethods',
            'paymentMethods',
        ));
    }

    public function updateTotal(Request $request): JsonResponse{
        $shippingId = $request->input('id_shipping_method');

        $shippingMethod = ShippingMethod::find($shippingId);
        if (!$shippingMethod) {
            return response()->json(['error' => 'Shipping method not found'], 400);
        }

        $shippingCost = $shippingMethod->price;

        $cartItems = Auth::check()
            ? Cart::with('product')->where('id_user', Auth::id())->get()
            : collect(session()->get('cart',[]));

        $totalProductPrice = 0;

        foreach ($cartItems as $item) {
            $price = Auth::check()
                ? $item->product->price
                : $item['price'];
            $quantity = Auth::check()
                ? $item->quantity
                : $item['quantity'];

            $totalProductPrice += $price * $quantity;
        }

        $totalPrice = $totalProductPrice + $shippingCost;

        return response()->json([
           'shippingCost' => number_format($shippingCost, 2,),
           'totalPrice' => number_format($totalPrice, 2,),
        ]);
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'street_and_house_number' => 'required|string',
                'apartment_number' => 'required|string',
                'city' => 'required|string',
                'postal_code' => 'required|string',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'phone_number' => 'required|string',
                'email' => 'required|string|email|max:255',
                'id_shipping_method' => 'required|exists:shipping_methods,id',
                'id_payment_method' => 'required|exists:payments_methods,id',
            ]);
        } catch (ValidationException $e){
            return response()->json([
                'success' => false,
                'message' => 'blad walidacji',
                'errors' => $e->errors()
            ],422);
        }


        DB::beginTransaction();

        try {
            // 1. Zapisz adres
            $address = Address::create([
                'street_and_house_number' => $request->street_and_house_number,
                'apartment_number' => $request->apartment_number,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
            ]);

            // 2. Pobierz produkty z koszyka
            if (Auth::check()) {
                $cartItems = Cart::with('product')->where('id_user', Auth::id())->get();
            } else {
                $sessionCart = session('cart', []);
                $cartItems = collect();

                foreach ($sessionCart as $productId => $details) {
                    $product = Product::find($productId);
                    if ($product) {
                        $cartItems->push((object)[
                            'id_product' => $product->id,
                            'price' => $product->price,
                            'quantity' => $details['quantity'],
                        ]);
                    }
                }
            }

            // 3. Oblicz sumę
            $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);

            // 4. Stwórz zamówienie
            $order = Order::create([
                'id_user' => Auth::id(),
                'id_address' => $address->id,
                'id_shipping_method' => $request->id_shipping_method,
                'id_payment_method' => $request->id_payment_method,
                'total_price' => $total,
                'status' => 'nowe',
            ]);

            // 5. Zapisz pozycje zamówienia
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'id_order' => $order->id,
                    'id_product' => $item->id_product ?? $item->product->id,
                    'quantity' => $item->quantity,
                    'current_price' => $item->price,
                ]);
            }

            // 6. Wyczyść koszyk
            Auth::check()
                ? Cart::where('id_user', Auth::id())->delete()
                : session()->forget('cart');

            DB::commit();

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


}

