<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManageProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.products.index',[
            'products' => Product::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.products.create',[
            'categories' => ProductCategory::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ManageProductRequest $request
     * @return RedirectResponse
     */

    # ManageProductRequest to plik w folderze Request odpowiadajacy za wszystkie walidacje dotyczacy produktu!!!
    public function store(ManageProductRequest $request): RedirectResponse
    {
        $product = new Product($request->validated());
        $product->save();
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $index => $image) {
                $path = $image->store('products', 'public');
                $filename = basename($path);

                ProductImage::create([
                    'id_product' => $product->id,
                    'image_url' => $filename,
                    'is_main' => $index === 0 ? 1 : 0,
                ]);
            }
        }
        return redirect()
            ->route('products.index')
            ->with('status',__('shop.product.status.store.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @param View
     */
    public function show(Product $product): View
    {
        return view('admin.products.show',[
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        return view('admin.products.edit',[
            'product' => $product
        ],
        [
            'categories' => ProductCategory::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ManageProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(ManageProductRequest $request, Product $product): RedirectResponse
    {
        $product->fill($request->validated());
        if ($request->hasFile('image')) {
            $currentImageCount = $product->images()->count();
            $newImages = $request->file('image');

            if ($currentImageCount + count($newImages) > 5) {
                return back()->with('image', 'Produkt może mieć maksymalnie 5 zdjęć.');
            }

            foreach ($newImages as $index => $image) {
                $path = $image->store('products', 'public');
                $filename = basename($path);

                ProductImage::create([
                   'id_product' => $product->id,
                   'image_url' => $filename,
                   'is_main' =>  $product->images()->count() === 0 && $index === 0 ? 1 : 0,
                ]);
            }
        }
        $product->save();
        return redirect()->route('products.index')->with('status',__('shop.product.status.update.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        try {
            $product->delete();
            Session::flash('status',__('shop.product.status.delete.success'));
            return response()->json([
                'status' => 'success'
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => "Wystapi blad"
            ])->setStatusCode(500);
        }
    }
}
