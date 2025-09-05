<?php

namespace App\Http\Controllers;


use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return View
     */

    public function index(): View
    {
        //wyswietlenie produktow i ich danych z koszyku jako zalogowany uzytkownik
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
                        'image' => $item->product->images->first()->image_url,
                    ];
                });
            $isGuest = false;
        }
        //wyswietlenie produktow i ich danych z koszyku jako gosc
        else {
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
                        'image' => $product->images->first()->image_url,
                    ];
                }
            }
            $isGuest = true;
        }

        //zwracanie do cart/show.blade.php danych produktu oraz czy uzytkownik jest gosciem czy tez nie
        return view('cart.index', compact('cartItems', 'isGuest'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function store(Request $request, Product $product): JsonResponse
    {
        $quantity = $request->input('quantity',1); // pobieramy quantity, domyślnie 1

        //dodawanie produktu do koszyka jako zalogowany uzytkownik
        if (Auth::check()) {
            $cartItem = Cart::firstOrCreate(
                ['id_user' => Auth::id(), 'id_product' => $product->id],
                [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 0,
                ]
            );
            $cartItem->quantity += $quantity;
            $cartItem->save();

            //to narazie nie jest uzywane ale moze kiedys byc wiec to zostawiam
            return response()->json(['message' => 'Dodano do koszyka (konto).']);
        }
        //dodawanie produktu do koszyka jako gosc
        else {
            $quantity = $request->input('quantity', 1);
            $cart = session()->get('cart', []);

            foreach ($cart as $key => $value) {
                if (is_object($value)) {
                    $cart[$key] = (array) $value;
                }
            }

            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] += $quantity;
            } else {
                $cart[$product->id] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image,
                    'quantity' => $quantity,
                ];
            }

            session()->put('cart', $cart);
            //to narazie nie jest uzywane ale moze kiedys byc wiec to zostawiam
            return response()->json(['message' => 'Dodano do koszyka (gość).']);
        }
    }

    public function updateQuantity(Request $request, $id): JsonResponse
    {
        //sluzy do zwiekszania badz zmniejszania ilosci produktow ktore sa w modal cart (czyli te
        // okienko ktore sie wyswietla jak sie doda produkt do koszyka)

        //pobieramy z data-action ktora jest w cart_modal_conent.blade.php akcje aby sprawdzic ktora kliknelismy
        $action = request()->input('action');

        if (Auth::check()) {
            $cartItems = Cart::where('id',$id)->where('id_user', Auth::id())->first();

            //sprawdzanie akcji czy kliknelismy przycisk ktory ma zmiejszac ilosc produktow lub zwiekszac
            if ($action) {
                if ($action == 'increase') {
                    $cartItems->quantity += 1;
                }elseif ($action == 'decrease') {
                    //max sluzy do tego aby zapobiec ujemnej liczbie produktow (minimalna liczba to jeden, nie moze byc mniejsza)
                    $cartItems->quantity = max(1, $cartItems->quantity - 1);
                }
                $cartItems->save();

                return response()->json(['message' => 'Zaktualizowano ilość']);
            }
        }else{
            //tutaj jest wykonywane dokladnie to samo lecz dla goscia
            $cart = session()->get('cart', []);
            if(isset($cart[$id])){
                if($action === 'increase'){
                    $cart[$id]['quantity'] += 1;
                }elseif ($action === 'decrease'){
                    $cart[$id]['quantity'] = max(1,$cart[$id]['quantity'] - 1);
                }
                session()->put('cart', $cart);

                return response()->json(['message' => 'Zaktualizowano ilość']);
            }
        }
        return response()->json(['message' => 'Nie znaleziono produktu.'], 404);
    }

    public function updateCount(): JsonResponse
    {
        //funkcja ma za zadanie wysylac aktualna ilosc produktow z koszyka do app.blade.php a konkretnie czerwonej kropki od koszyka
        //jest uzywana gdy wykonuje sie ajax, na przyklad podczas usuniecia produktu z koszyka badz zmiejszania jego ilosci w koszyku i zwiekszania
        $count = 0;

        if (Auth::check()) {
            $count = Cart::where('id_user', Auth::id())->sum('quantity');
        } else {
            $cart = session()->get('cart', []);
            foreach ($cart as $item) {
                $count += $item['quantity'] ?? 1;
            }
        }

        return response()->json(['count' => $count]);
    }

    //zwraca html koszyka content modal, jest to przekazywane do cart.modal_content.blade.php
    public function getCartModalContent(): Response|JsonResponse
    {
        try {
            if (Auth::check()) {
                $cartItems = Cart::with('product')->where('id_user', Auth::id())->get();
            } else {
                $cart = session()->get('cart', []);
                $cartItems = collect();
                foreach ($cart as $productId => $details) {
                    $product = Product::find($productId);
                    if ($product) {
                        $cartItems->push((object)[
                            'id' => $product->id,
                            'product' => $product,
                            'quantity' => $details['quantity'] ?? 1,
                        ]);
                    }
                }
            }

            //to dodaje zdjecie produktu do $cartItems aby moglo sie wyswietlac na stronie
            //$item moze byc dowonlna nazwa, na przyklad $produkt
            $cartItems->each(function ($item) {
                $firstImage = $item->product->images->first();
                $item->product->image_url = $firstImage
                    ? asset('storage/products/' . $firstImage->image_url)
                    : asset('storage/products/no-image.png');
            });

            return response(view('cart.cart_modal_content', compact('cartItems')));
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Błąd podczas ładowania koszyka: ' . $e->getMessage()
            ], 500);
        }
    }
    public function destroy($id): JsonResponse
    {
        if (Auth::check()) {
            $cartItem = Cart::where('id', $id)
                ->where('id_user', Auth::id())
                ->first();

            if ($cartItem) {
                $cartItem->delete();
                return response()->json(['message' => 'Usunięto z koszyka.']);
            }
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
                return response()->json(['message' => 'Usunięto z koszyka (gość).']);
            }
        }
        return response()->json(['message' => 'Nie znaleziono produktu.'], 404);
    }

    //zwraca html koszyka content modal, jest to przekazywane do cart.modal_content.blade.php
}
