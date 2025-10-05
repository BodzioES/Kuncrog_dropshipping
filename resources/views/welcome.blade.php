@extends('layouts.app')

@section('content')

    {{-- POKAZ SLAJDOW Z TYMI ZDJECIAMI ALE TO JEST NARAZIR CHWILOWE --}}
    <div id="hero">
        <div class="slide active" style="background-image:url('https://rueparis.pl/wp-content/uploads/sites/54/2022/02/wiosenna-kolekcja-ubran-rue-paris.jpg');">
            <div class="overlay">
                <h1>New spring collection</h1>
                <p>Pastel dresses and light fabrics</p>
                <a href="">Watch now</a>
            </div>
        </div>
        <div class="slide" style="background-image:url('https://cdn.shopify.com/s/files/1/0605/4995/5814/files/sport_luxe_banner_mockd_1024x1024.jpg?v=1636070459');">
            <div class="overlay">
                <h1>Sport-luxe in style 2025</h1>
                <p>Sports jackets and retro sneakers</p>
                <a href="">Check</a>
            </div>
        </div>
        <div class="slide" style="background-image:url('https://fioza.pl/wp-content/uploads/2025/04/elegancka-przezroczysta-bluzka.jpg');">
            <div class="overlay">
                <h1>Sheer tops and organza</h1>
                <p>Delicate,ethereal designs</p>
                <a href="">Buy now</a>
            </div>
        </div>
    </div>

    <!-- Sekcja z opisem marki -->
    <section class="text-center py-5 bg-light">
        <div class="container">
            <h2 class="mb-4">Kuncrog – trendy products!</h2>
            <p class="lead">
                Our store is constantly updated and refreshed with a variety of new products that are constantly entering the market.
                We strive to provide interesting and functional products!
            </p>
        </div>
    </section>

    <!-- Sekcja z popularnymi kategoriami -->
    <section class="py-5">
        <div class="container">
            <h3 class="text-center mb-4">Popular categories</h3>
            <div class="row justify-content-center text-center">
                @foreach($products_categories as $category)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                        <div class="category-item text-center">
                            <button type="button"
                                    class="btn btn-light category-button"
                                    data-category="{{$category->id}}"
                                    style="border: none; background: transparent;">
                                <img
                                    src="{{ asset('storage/category/' . $category->image) }}"
                                    alt="{{ $category->name }}"
                                    class="img-fluid rounded-circle mb-2"
                                    style="width: 120px; height: 120px; object-fit: cover;"
                                >
                            </button>
                            <div>{{ $category->name }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="container pt-5">
        <div class="row">
            {{-- Jeden wspólny formularz --}}
            <form class="col-12 col-md-4 col-lg-3 sidebar-filter">

                {{-- Desktop: sidebar po lewej --}}
                <div class="d-none d-md-block">
                    <h3 class="mt-0 mb-5">
                        Products <span class="text-primary">{{ count($products) }}</span>
                    </h3>

                    <h6 class="text-uppercase font-weight-bold mb-3">Categories</h6>
                    @foreach($products_categories as $category)
                        <div class="mt-2 mb-2 pl-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="filter[categories][]" id="category-{{ $category->id }}" value="{{ $category->id }}">
                                <label class="custom-control-label" for="category-{{ $category->id }}">{{ $category->name }}</label>
                            </div>
                        </div>
                    @endforeach

                    <div class="divider mt-5 mb-5 border-bottom border-secondary"></div>

                    <h6 class="text-uppercase mt-5 mb-3 font-weight-bold">Price</h6>
                    <div class="price-filter-control">
                        <input type="number" class="form-control w-50 mb-2" placeholder="50"
                               name="filter[price_min]" min="0">
                        <input type="number" class="form-control w-50" placeholder="150"
                               name="filter[price_max]" min="0">
                    </div>
                    <a href="#products-wrapper" class="btn btn-lg btn-block btn-primary mt-5" id="filter-button">Filter</a>
                </div>

                {{-- Mobile: filtry nad produktami --}}
                <div class="col-12 d-block d-md-none mb-4">
                    <div class="accordion" id="filterAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFilters">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFilters" aria-expanded="true"
                                        aria-controls="collapseFilters">
                                    🔍 Product filters
                                </button>
                            </h2>
                            <div id="collapseFilters" class="accordion-collapse collapse show"
                                 aria-labelledby="headingFilters" data-bs-parent="#filterAccordion">
                                <div class="accordion-body">
                                    <h6 class="text-uppercase font-weight-bold mb-3">{{__('shop.welcome.categories')}}</h6>
                                    @foreach($products_categories as $category)
                                        <div class="mt-2 mb-2 pl-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="filter[categories][]" id="category-{{ $category->id }}" value="{{ $category->id }}">
                                                <label class="custom-control-label" for="category-{{ $category->id }}">{{ $category->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach

                                    <hr>

                                    <h6 class="text-uppercase mt-3 mb-2 font-weight-bold">{{__('shop.welcome.price')}}</h6>
                                    <div class="d-flex gap-2">
                                        <input type="number" class="form-control" placeholder="50"
                                               name="filter[price_min]" min="0">
                                        <input type="number" class="form-control" placeholder="150"
                                               name="filter[price_max]" min="0">
                                    </div>

                                    <a href="#products-wrapper" class="btn btn-lg btn-block btn-primary mt-5" id="filter-button">{{__('shop.welcome.filter')}}</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

            {{-- Produkty --}}
            <div class="col-md-8 col-lg-9">
                <div class="row g-4" id="products-wrapper">
                    @foreach($products as $product)
                        <div class="col-12 col-sm-6 col-md-4">
                            <div id="pole" class="card h-100 border-0">
                                <a href="{{route('product_page.show',$product->id)}}"
                                   style="text-decoration: none">
                                    <div class="card-img-top text-center">
                                        <img src="{{asset('storage/products/' . $product->images->first()->image_url)}}"
                                             alt="Photo" style="height: auto; object-fit: cover; width: 100%;">
                                    </div>
                                    <div class="card-body text-center">
                                        <h4 class="card-title">{{ $product->name }}</h4>
                                        <h5 class="card-price small"><i>{{ $product->price }} PLN</i></h5>
                                    </div>
                                </a>
                                <div style="display: none" id="product-quantity-{{$product->id}}">
                                    {{$product->quantity}}
                                </div>
                                <button class="btn btn-success btn-sm add-cart-button m-2" data-id="{{ $product->id }}">
                                    <i class="fas fa-cart-plus"></i> Add to cart
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- TO JEST TEN KOSZYK KTORY SIE WYSWIETLA PO DODANIU PRODUKTU DO KOSZYKA --}}
        <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="max-height: 80vh; overflow-y: auto;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cartModalLabel">Cart</h5>
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

        {{-- POKAZ SLAJDOW Z TYMI ZDJECIAMI ALE TO JEST NA RAZIE CHWILOWE --}}
        <script>
            const slides = document.querySelectorAll('#hero .slide');
            let current = 0;
            setInterval(() => {
                slides[current].classList.remove('active');
                current = (current + 1) % slides.length;
                slides[current].classList.add('active');
            }, 7000);
        </script>
    </div>
@endsection

@section('javascript')

@endsection

@section('js-files')
    @vite(['resources/js/welcome.js'])
    @vite('resources/js/modal_delete.js')
    @vite('resources/js/modal_quantity.js')
    @vite(['resources/js/cookie-navbar.js'])
@endsection

@vite(['resources/css/welcome.css'])
