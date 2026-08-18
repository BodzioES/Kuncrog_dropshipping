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
use Illuminate\Support\Facades\Mail;

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
                        'image' => $item->product->images->first()?->image_url ?? 'no-image.png',
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
                        'image' => $product->images->first()?->image_url ?? 'no-image.png',
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

    public function store(Request $request): JsonResponse
    {
        $request->validate([
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
            'inpost_locker' => [
                function($attribute, $value, $fail) use ($request) {
                    if ((int)$request->id_shipping_method == 2 && empty($value)) {
                        $fail('You must to choose a parcel locker!');
                    }
                }
            ],

            'items' => 'required|array|min:1',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.current_price' => 'required|numeric|min:0',
            'items.*.id_product' => 'required|integer',
        ], [
            'address.first_name.required' => 'Pole Imię jest wymagane.',
            'address.last_name.required' => 'Pole Nazwisko jest wymagane.',
            'address.email.required' => 'Pole E-mail jest wymagane.',
            'address.street_and_house_number.required' => 'Pole Ulica i numer domu jest wymagane.',
            'address.city.required' => 'Pole Miasto jest wymagane.',
            'address.postal_code.required' => 'Pole Kod pocztowy jest wymagane.',
            'address.phone_number.required' => 'Pole Numer telefonu jest wymagane.',

            'id_payment_method.required' => 'Musisz wybrać metodę płatności.',
            'id_shipping_method.required' => 'Musisz wybrać metodę dostawy.',
            'items.required' => 'Koszyk nie może być pusty.',
        ]);
        //Po walidacji — nigdy się nie wykona jeśli walidacja padnie!!!!!!!!!!
        DB::beginTransaction();

        try {
            $shippingMethod = ShippingMethod::findOrFail($request->input('id_shipping_method'));

            // 1. Wezryfikuj ceny i ilosci z BAZA (nie wierzymy danym z formularza)
            //    dzieki temu nie da sie podmienic ceny na wartosc nizsza
            $totalProductPrice = 0;
            $validatedItems = [];
            foreach ($request->input('items') as $itemData) {
                $product = Product::find($itemData['id_product']);
                if (!$product) {
                    throw new \Exception('Produkt nie istnieje. Odśwież koszyk.');
                }
                if ((float) $itemData['current_price'] !== (float) $product->price) {
                    throw new \Exception('Cena produktu uległa zmianie. Odśwież koszyk.');
                }
                if ($itemData['quantity'] > $product->stock_quantity) {
                    throw new \Exception("Brak wystarczającej ilości towaru: {$product->name}.");
                }

                $totalProductPrice += $product->price * $itemData['quantity'];
                $validatedItems[] = [
                    'id_product' => $product->id,
                    'current_price' => $product->price,
                    'quantity' => (int) $itemData['quantity'],
                ];
            }

            $totalPrice = $totalProductPrice + (float) $shippingMethod->price;

            // Zapis adresu z requestu
            $address = new Address($request->input('address'));
            $address->save();

            // Wspolne zapisywanie zamowienia (jeden kod dla goscia i zalogowanego)
            $order = new Order();
            $order->id_user = Auth::check() ? Auth::id() : null;
            $order->id_shipping_method = $request->input('id_shipping_method');
            $order->id_payment_method = $request->input('id_payment_method');
            $order->parcel_locker = ((int) $request->input('id_shipping_method') === 2 && $request->filled('inpost_locker'))
                ? $request->input('inpost_locker')
                : null;
            $order->total_price = $totalPrice;
            $order->status = 'pending';
            $order->id_address = $address->id_address;
            $order->save();

            // Zapis pozycji zamowienia + dekrementacja stanu magazynu
            foreach ($validatedItems as $itemData) {
                OrderItem::create($itemData + ['id_order' => $order->id]);
                Product::where('id', $itemData['id_product'])->decrement('stock_quantity', $itemData['quantity']);
            }

            // Wyczyszczenie koszyka (zalogowany -> z bazy, gosc -> z sesji)
            if (Auth::check()) {
                Cart::where('id_user', Auth::id())->delete();
            } else {
                session()->forget('cart');
            }

            DB::commit();

            //wysylanie informacji z tabeli order i order_item do OrderConfirmationMail.php
            $order->load('items.product', 'paymentMethod', 'shippingMethod','address');
            try {
                Mail::to($address->email)->send(new OrderConfirmationMail($order));
            } catch (\Exception $e) {
                \Log::error('Nie udalo sie wyslac maila potwierdzajacego: ' . $e->getMessage());
            }

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

