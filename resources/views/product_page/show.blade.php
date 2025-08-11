@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row">
        <!-- Product Images -->
        <div class="col-md-6 mb-4">
            <img src="{{asset('storage/products/' . ($productImages->first()->image_url ?? 'default.jpg')) }}"
                 alt="Product"
                 class="img-fluid rounded mb-3 product-image"
                 id="mainImage"
            >
            <div class="d-flex justify-content-between">
                @foreach($productImages as $key => $image)
                    <img
                        src="{{asset('storage/public/products/' . $image->image_url)}}"
                        alt="Thumbnail {{$key+1}}"
                        class="thumbnail rounded {{$key === 0 ? 'active' : ''}}"
                        onclick="changeImage(event,this.src)"
                @endforeach
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h2 class="mb-3">{{$product->name}}</h2>
            <p class="text-muted mb-4">SKU: WH1000XM4 ??</p>
            <div class="mb-3">
                <span class="h4 me-2">{{$product->price}} zł</span>
                {{--<span class="text-muted"><s>$399.99</s></span>--}}
            </div>
            <div class="mb-3">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-half text-warning"></i>
                {{--<span class="ms-2">4.5 (120 reviews)</span>--}}
            </div>
            <p class="mb-4">{{$product->description}}</p>
            {{--
                <div class="mb-4">
                    <h5>Color:</h5>
                    <div class="btn-group" role="group" aria-label="Color selection">
                        <input type="radio" class="btn-check" name="color" id="black" autocomplete="off" checked>
                        <label class="btn btn-outline-dark" for="black">Black</label>
                        <input type="radio" class="btn-check" name="color" id="silver" autocomplete="off">
                        <label class="btn btn-outline-secondary" for="silver">Silver</label>
                        <input type="radio" class="btn-check" name="color" id="blue" autocomplete="off">
                        <label class="btn btn-outline-primary" for="blue">Blue</label>
                    </div>
                </div>
            --}}
            <div class="mb-4">
                <label for="quantity" class="form-label">Ilość:</label>
                <input type="number" class="form-control" id="quantity" value="1" min="1" style="width: 80px;">
            </div>
            <button class="btn btn-dark btn-lg mb-3 me-2 add-cart-button" data-id="{{ $product->id }}">
                <i class="bi bi-cart-plus"></i> Dodaj do koszyka
            </button>
            {{--
                <button class="btn btn-outline-secondary btn-lg mb-3">
                    <i class="bi bi-heart"></i> Add to Wishlist
                </button>
            --}}

            <div class="mt-4">
                <h5>Key Features:</h5>
                <ul>
                    <li>Industry-leading noise cancellation</li>
                    <li>30-hour battery life</li>
                    <li>Touch sensor controls</li>
                    <li>Speak-to-chat technology</li>
                </ul>
            </div>
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
                <p>Ładowanie koszyka...</p>
            </div>
            <div class="modal-footer">
                <a href="{{ route('cart.index') }}" class="btn btn-primary">Przejdź do koszyka</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kontynuuj zakupy</button>
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

