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
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Pobieramy produkty z koszyka użytkownika
            $cartItems = Cart::where('id_user', $user->id)
                ->with('product') // Dołączamy produkt do wyników
                ->get();
            return view('cart.index', compact('cartItems'));
        }

        return redirect()->route('welcome')->with('error', 'Musisz być zalogowany, aby zobaczyć koszyk');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function store(Request $request, Product $product): JsonResponse
    {
        if(Auth::check()){
            $user = Auth::user();

            $cartItem = Cart::where('id_user',$user->id)
            -> where('id_product',$product->id)
            ->first();
            if($cartItem){
                $cartItem->quantity += 1;
                $cartItem->save();
            }else{
                Cart::create([
                    'id_user' => $user->id,
                    'id_product' => $product->id,
                    'quantity' => 1
                ]);
            }
            return response()->json([
                'message' => 'Produkt został dodany do koszyka!',
                'status' => 'success'
            ]);
        }
        return response()->json([
            'message' => 'Musisz być zalogowany, aby dodać produkt do koszyka.',
            'status' => 'error'
        ], 401);
    }

    public function destroy($id): JsonResponse
    {
        $cartItem = Cart::where('id', $id)
            ->where('id_user', Auth::id())
            ->first();

        if ($cartItem) {
            $cartItem->delete();

            return response()->json([
                'message' => 'Produkt został usunięty z koszyka.',
                'status' => 'success',
            ]);
        }

        return response()->json([
            'message' => 'Nie znaleziono produktu w koszyku.',
            'status' => 'error',
        ], 404);
    }
}
