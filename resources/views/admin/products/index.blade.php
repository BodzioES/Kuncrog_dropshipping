@extends('layouts.admin')

@section('content')
    <div class="container" data-url="{{ route('products.index') }}">
    <div class="container">
        {{-- TO ODPOWIADA ZA WYSWIETLENIE KOMUNIKATU O POTWIERDZENIU AKTUALIZACJI PRODUKTU --}}
        @include('helpers.flash-messages')
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h1><i class="fa-solid fa-clipboard-list"></i> {{__('shop.product.index_title')}}</h1>
                <a href="{{route('products.create')}}">
                    <button type="button" class="btn btn-primary"><i class="fa-solid fa-plus"></i> {{__('shop.button.add')}}</button>
                </a>
            </div>
        </div>
        <div class="row">
            {{-- Desktop --}}
            <table class="table table-hover table-desktop d-none d-md-table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{__('shop.product.fields.name')}}</th>
                    <th scope="col">{{__('shop.product.fields.description')}}</th>
                    <th scope="col">{{__('shop.product.fields.stock_quantity')}}</th>
                    <th scope="col">{{__('shop.product.fields.price')}}</th>
                    <th scope="col">{{__('shop.product.fields.category')}}</th>
                    <th scope="col">{{__('shop.columns.actions')}}</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                @foreach($products as $product)
                    <tr>
                        <th scope="row">{{$product->id}}</th>
                        <td>{{$product->name}}</td>
                        <td>{{$product->description}}</td>
                        <td>{{$product->stock_quantity}}</td>
                        <td>{{$product->price}}</td>
                        <td>@if($product->hasCategory()){{$product->category->name}}@endif</td>
                        <td>
                            <a href="{{route('products.show',$product->id)}}">
                                <button class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </a>
                            <a href="{{route('products.edit',$product->id)}}">
                                <button class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></button>
                            </a>
                            <button class="btn btn-danger btn-sm delete"
                                    data-id="{{$product->id}}"
                                    data-url="{{ route('products.index') }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{-- Mobile --}}
            <div class="table-mobile d-block d-md-none">
                @foreach($products as $product)
                    <div class="product-card mb-3 p-3 border rounded shadow-sm bg-light">
                        <p><strong>ID:</strong> {{$product->id}}</p>
                        <p><strong>Nazwa:</strong> {{$product->name}}</p>
                        <p><strong>Opis:</strong> {{$product->description}}</p>
                        <p><strong>Ilość:</strong> {{$product->stock_quantity}}</p>
                        <p><strong>Cena:</strong> {{$product->price}} zł</p>
                        <p><strong>Kategoria:</strong> @if($product->hasCategory()){{$product->category->name}}@endif</p>

                        <div class="d-flex justify-content-around mt-2">
                            <a href="{{route('products.show',$product->id)}}" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </a>
                            <a href="{{route('products.edit',$product->id)}}" class="btn btn-sm btn-warning">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <button class="btn btn-sm btn-danger delete"
                                    data-id="{{$product->id}}"
                                    data-url="{{ route('products.index') }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $products->links() }}
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script data-url="{{ route('products.index') }}"></script>
    @vite('resources/js/delete.js')
    @vite('resources/css/product.css')
@endsection


