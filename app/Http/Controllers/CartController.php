<?php

namespace App\Http\Controllers;


use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return RedirectResponse|View
     */

    public function index(): View
    {
        if (Auth::check()) {
            $cartItems = Cart::with('product')
                ->where('id_user', Auth::id())
                ->get()
                ->map(function ($item) {
                    return (object)[
                        'id' => $item->id,
                        'name' => $item->product?->name,
                        'price' => $item->product?->price,//edytowaf tabele aby byly w niej te rekordy z pytajnikiem
                        'image' => $item->product?->image,
                        'quantity' => $item->quantity
                    ];
                });
        } else {
            $cart = session()->get('cart', []);
            $cartItems = collect();

            foreach ($cart as $productId => $quantity) {
                $product = Product::find($productId);
                if ($product) {
                    $cartItems->push((object)[
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'image' => $product->image,
                        'quantity' => $quantity
                    ]);
                }
            }
        }
        return view('cart.index', compact('cartItems'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function store(Request $request, Product $product): JsonResponse
    {
        if (Auth::check()) {
            $cartItem = Cart::firstOrCreate(
                ['id_user' => Auth::id(), 'id_product' => $product->id],
                ['quantity' => 0]
            );
            $cartItem->quantity += 1;
            $cartItem->save();

            return response()->json(['message' => 'Dodano do koszyka (konto).']);
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$product->id])) {
                $cart[$product->id] += 1;
            } else {
                $cart[$product->id] = 1;
            }

            session()->put('cart', $cart);
            return response()->json(['message' => 'Dodano do koszyka (gość).']);
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
}
