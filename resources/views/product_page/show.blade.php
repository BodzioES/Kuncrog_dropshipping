@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 mb-4 d-flex flex-column">
            <img src="{{asset('storage/products/' . ($productImages->first()->image_url ?? 'default.jpg')) }}"
                 alt="Product"
                 class="img-fluid rounded mb-2 product-image shadow flex-grow-1"
                 id="mainImage"
                 style="width: 100%; height: 100%; object-fit: contain;"
            >
            <div class="d-flex justify-content-start gap-2 flex-wrap">
                @foreach($productImages as $key => $image)
                    <img
                        src="{{asset('storage/products/' . $image->image_url)}}"
                        alt="Thumbnail {{$key+1}}"
                        class="thumbnail rounded border border-dark p-1 {{$key === 0 ? 'active' : ''}}"
                        style="max-width: 90px; height: auto; cursor: pointer;"
                        onclick="changeImage(event,this.src)"
                    >
                @endforeach
            </div>
        </div>


        <div class="col-md-6">

            <h1 class="fw-bold mb-4 text-dark">{{$product->name}}</h1>

            <div class="mb-3">
                <span class="fs-3 fw-bold text-success">{{$product->price}} zł</span>
            </div>

            <div class="mb-3">
                <i class="bi bi-star-fill text-warning fs-5"></i>
                <i class="bi bi-star-fill text-warning fs-5"></i>
                <i class="bi bi-star-fill text-warning fs-5"></i>
                <i class="bi bi-star-fill text-warning fs-5"></i>
                <i class="bi bi-star-half text-warning fs-5"></i>
                {{--<span class="ms-2">4.5 (120 reviews)</span>--}}
            </div>

            <p class="mb-4 fs-5 text-secondary">{{$product->description}}</p>

            <div class="mb-4">
                <div class="number-input align-items-center">
                    <button class="btn btn-outline-dark btn-sm"
                            onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</button>
                    <input type="number" class="form-control mx-2 text-center fw-bold"
                           id="quantity" value="1" min="1" style="width: 90px; font-size: 1.1rem;">
                    <button class="btn btn-outline-dark btn-sm"
                            onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</button>
                </div>
            </div>

            <button class="btn btn-dark btn-lg mb-3 me-2 add-cart-button shadow-sm"
                    data-id="{{ $product->id }}"
                    data-quantity-input="#quantity">
                <i class="bi bi-cart-plus"></i> Add to cart
            </button>
        </div>
    </div>

</div>

<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Koszyk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
            </div>
            <div class="modal-body" id="cartModalBody">
                <p>Loading cart...</p>
            </div>
            <div class="modal-footer">
                <a href="{{ route('cart.index') }}" class="btn btn-primary">Go to cart</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continue shopping</button>
            </div>
        </div>
    </div>
</div>

<script>
    function changeImage(event, src) {
        document.getElementById('mainImage').src = src;
        document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
        event.target.classList.add('active');
    }
</script>
@endsection

@section('javascript')

@endsection

@section('js-files')
@vite(['resources/js/welcome.js'])
@vite('resources/js/modal_delete.js')
@vite('resources/js/modal_quantity.js')
@endsection

@vite(['resources/css/productPage.css'])

