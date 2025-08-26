@extends('layouts.app')

@section('content')

    <h1 class="text-center my-4">Moje zamówienia</h1>

    @forelse($orders as $order)
        <div class="order card shadow-sm p-3 mb-4">
            <div class="d-flex justify-content-center align-items-center flex-wrap mb-3">
                @foreach($order->items as $item)
                    <div class="me-3 mb-2 text-center">
                        <img src="{{ asset('storage/products/' . ($item->product->images->first()->image_url ?? null)) }}"
                             alt="photo"
                             class="img-thumbnail"
                             style="width: 80px; height: auto; object-fit: cover; border-radius: 8px;">
                        <p class="small mt-1">{{ $item->product->name }}</p>
                    </div>
                @endforeach
            </div>

            <div class="text-center">
                <p><strong>Zamówienie #{{ $order->id }}</strong></p>
                <p>Status: <span class="badge bg-info text-dark">{{ $order->status }}</span></p>
                @foreach($order->items as $item)
                    <p>{{$item->quantity}} * {{$item->current_price}} zł</p>
                @endforeach
                <p>{{$order->total_price - $order->shippingMethod->price}} zł</p>
                <p>Razem z dostawą: <strong>{{ number_format($order->total_price, 2) }} zł</strong></p>
            </div>
        </div>
    @empty
        <p class="text-center text-muted">Nie masz jeszcze żadnych zamówień</p>
    @endforelse



@endsection
@section('javascript')

@endsection
@section('js-files')
    @vite(['resources/js/welcome.js'])
    @vite('resources/js/modal_delete.js')
    @vite('resources/js/modal_quantity.js')
@endsection
@vite(['resources/css/welcome.css'])
