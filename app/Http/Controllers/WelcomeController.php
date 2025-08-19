<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View|JsonResponse
     */
    public function index(Request $request): View|JsonResponse
    {
        $filters = $request->query('filter');
        $query = Product::with('images');
        if (!empty($filters)) {
            if (array_key_exists('categories', $filters)) {
                $query = $query->whereIn('id_products_categories', $filters['categories']);
            }
            if (!empty($filters['price_min'])) {
                $query = $query->where('price','>=', $filters['price_min']);
            }
            if (!empty($filters['price_max'])) {
                $query = $query->where('price','>=', $filters['price_max']);
            }

            return response()->json([
                'data' => $query->get()
            ]);
        }

        return view('welcome',[
            'products' => $query->get(),
            'products_categories' => ProductCategory::orderBy('name','ASC')->get(),
        ]
        );
    }
}
