@extends('layouts.app')

@section('content')

    <h1 class="text-center my-4">My orders</h1>


        @forelse($orders as $order)
            <div class="order card shadow-sm p-3 mb-4">
                <a class="btn" data-bs-toggle="collapse" href="#collapseOrder" role="button" aria-expanded="false" aria-controls="collapseOrder">
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
                        <p><strong>Order #{{ $order->id }}</strong></p>
                        <p>Status: <span class="badge bg-info text-dark">{{ $order->status }}</span></p>
                        <p><span style="color: #0dcaf0; font-weight: 700;">expand</span></p>

                        <div class="collapse" id="collapseOrder">
                                @foreach($order->items as $item)
                                    <p>{{$item->product->name}}: {{$item->quantity}} * {{$item->current_price}} zł</p>
                                @endforeach
                                <p>total: {{$order->total_price - $order->shippingMethod->price}} zł</p>
                                <p>together with delivery: <strong>{{ number_format($order->total_price, 2) }} zł</strong></p>
                        </div>

                    </div>
                </a>
            </div>
        @empty
            <p class="text-center text-muted">You don't have any orders yet</p>
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
