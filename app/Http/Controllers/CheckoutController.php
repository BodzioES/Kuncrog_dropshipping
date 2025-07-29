<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Nette\Schema\ValidationException;
use function Laravel\Prompts\alert;

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
                        'id_product' => $item->product->id,
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
                        'id_product' => $product->id,
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
        $request->validate([
            //to sluzy do tego aby sprawdzic najpierw czy te dane spelniaja wymogi ktore sa ponizej, jesli nie to nie wykona sie zapytanie do bazy
            'address.first_name' => 'required|string|max:255',
            'address.last_name' => 'required|string|max:255',
            'address.email' => 'required|email|max:255',
            'address.street_and_house_number' => 'required|string|max:255',
            'address.apartment_number' => 'nullable|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.postal_code' => 'required|string|max:20',
            'address.phone_number' => 'required|string|max:20',

            'id_payment_method' => 'required|integer',
            'id_shipping_method' => 'required|integer',

            'items' => 'required|array|min:1',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.current_price' => 'required|numeric|min:0',
            'items.*.id_product' => 'required|integer',

        ]);
        //Po walidacji — nigdy się nie wykona jeśli walidacja padnie!!!!!!!!!!
        DB::beginTransaction();

        try {
            $userId = Auth::check() ? Auth::id() : null;

            if (Auth::check()) {
                // ZALOGOWANY UŻYTKOWNIK
                // Zapis adresu z requestu
                $address = new Address($request->input('address'));
                $address->save();


                $order = new Order();
                $order->id_user = $userId;
                $order->id_shipping_method = $request->input('id_shipping_method');
                $order->id_payment_method = $request->input('id_payment_method');
                $order->total_price = $request->input('total_price');
                $order->status = 'pending';
                $order->id_address = $address->id_address;
                $order->save();

                foreach ($request->input('items') as $itemData) {
                        OrderItem::create([
                            'id_order' => $order->id,
                            'id_product' => $itemData['id_product'],
                            'current_price' => $itemData['current_price'],
                            'quantity' => $itemData['quantity'],
                        ]);
                }

                DB::table('cart')->where('id_user', $userId)->delete();

            } else {

                $cart = session()->get('cart', []);

                // Zapis adresu z requestu
                $address = new Address($request->input('address'));
                $address->save();

                $order = new Order();
                $order->id_shipping_method = $request->input('id_shipping_method');
                $order->id_payment_method = $request->input('id_payment_method');
                $order->total_price = $request->input('total_price');
                $order->status = 'pending';
                $order->id_address = $address->id_address;
                $order->save();


                foreach ($request->input('items') as $itemData) {
                    OrderItem::create([
                        'id_order' => $order->id,
                        'id_product' => $itemData['id_product'],
                        'current_price' => $itemData['current_price'],
                        'quantity' => $itemData['quantity'],
                    ]);
                }
                session()->forget('cart');
            }

            DB::commit();

            //wysylanie informacji z tabeli order i order_item do OrderConfirmationMail.php
            $order->load('items.product', 'paymentMethod', 'shippingMethod','address');
            Mail::to($address->email)->send(new OrderConfirmationMail($order));

            return response()->json([
                'success' => true,
                'message' => 'Order placed',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
               'success' => false,
                'message' => $e->getMessage(),
            ],500);
        }

    }
}

