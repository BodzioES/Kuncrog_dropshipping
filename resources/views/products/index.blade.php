@extends('layouts.app')

@section('content')
    <div class="container">
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
            <table class="table table-hover">
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
                            <button class="btn btn-danger btn-sm delete" data-id="{{$product->id}}"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $products->links() }}
        </div>
    </div>
@endsection
<script type="text/javascript" data-url="{{ url('products') }}">
    @yield('javascript')
</script>
@vite('resources/js/delete.js')

