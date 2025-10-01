@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('shop.product.show_title')}}</div>

                <div class="card-body">
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{__('shop.product.fields.name')}}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ $product->name }}" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="description" class="col-md-4 col-form-label text-md-end">{{__('shop.product.fields.description')}}</label>

                        <div class="col-md-6">
                            <textarea id="description" class="form-control" name="description"  disabled>{{$product->description}}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="stock_quantity" class="col-md-4 col-form-label text-md-end">{{__('shop.product.fields.stock_quantity')}}</label>

                        <div class="col-md-6">
                            <input id="stock_quantity" type="number" min="0" class="form-control" name="stock_quantity" value="{{ $product->stock_quantity }}" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="price" class="col-md-4 col-form-label text-md-end">{{__('shop.product.fields.price')}}</label>

                        <div class="col-md-6">
                            <input id="price" type="number" step="0.01" min="0" class="form-control"  name="price" value="{{ $product->price }}" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="category" class="col-md-4 col-form-label text-md-end">{{__('shop.product.fields.category')}}</label>

                        <div class="col-md-6">
                            <select id="category" class="form-control" name="id_products_categories" disabled>
                                @if($product->hasCategory())
                                    <option>{{$product->category->name}}</option>
                                @else
                                    <option>Brak</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 text-center">
                        <label>Current photos</label> <br>
                        @foreach($product->images as $img)
                            <img src="{{asset('storage/products/' . $img->image_url)}}"
                                 alt="phtoto"
                                 style="width: 60px; height: auto;">
                        @endforeach
                    </div>

                    <div class="row mb-0 justify-content-center">
                        <div class="col-md-6 offset-md-4">
                            <a href="{{route('products.index')}}">
                                <button type="button" class="btn btn-primary">
                                    Back
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
