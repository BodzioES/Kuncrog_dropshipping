//to jest biblioteka umozliwiajaca wyswietlanie tego modala po dodaniu produktu do koszyka
import { Modal } from 'bootstrap';
window.bootstrap = { Modal };

    //wykonuje sie po wcisnieciu przycisku z welcome.blade.php
    //dodaje on produkt do koszyka
    $(document).on('click','button.add-cart-button', function (event) {
        event.preventDefault();

        //pobiera odpowiednie id produktu dzieki data-id="{{ $product->id }}" ktory jest w przycisku
        var productId = $(this).data('id');

        // Sprawdzamy, czy przycisk ma przypisany input z ilością
        var quantitySelector = $(this).data('quantity-input'); // np. "#quantity"
        var quantity = 1; // domyślna ilość

        if (quantitySelector){
            var $input = $(quantitySelector);
            if ($input.length){
                quantity = parseInt($input.val());
            }
        }

        $.ajax({
            url: '/cart/' + productId,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                quantity: quantity
            },
            //jesli sie powiedzie to robi kolejny ajax ktory wyswietla cart modal (czyli taki mini koszyk)
            //wiadomo idzie to "zapytanie" do controllera ktory odesle do tego cart modal dane produktow ktore sa w koszyku
            success: function(response) {
                $.ajax({
                    url: '/cart/modal',
                    method: 'GET',
                    success: function (modalContent) {
                        console.log('Modal content:', modalContent);
                        $('#cartModalBody').html(modalContent);
                        let cartModal = new bootstrap.Modal(document.getElementById('cartModal'), {});
                        cartModal.show();
                        //jesli to sie powiedzie to wykonuje sie kolejny ajax XD, ktory ma za zadanie odswiezyc strone bez przeladowania
                        // w celu aktualizacji tej czerwonej kropki ktora jest obok ikony koszyka ktora pokazuje liczbe produktow w koszyku
                        $.ajax({
                            url: '/cart/count',
                            method: 'GET',
                            //wysylane jest tak jakby zapytanie do controllera aby ten odeslal z powrotem tutaj jako data odpowiedz ile jest produktow w koszyku
                            success: function (data){
                                //przypisujemy ta wartosc jako count i wsadzamy to do count
                                const count = data.count;
                                const $badge = $('#cart-count-badge');

                                //jezeli nie ma produktow to usuwana jest ta klasa w tej ikonce koszyka
                                if (count > 0){
                                    $badge.text(count).removeClass('d-none');
                                }
                                //jezezeli jest to doadajemy klase do naszego #cart-count-badge
                                else{
                                    $badge.addClass('d-none');
                                }
                            }
                        })
                    }
                });
            },
            error: function(response) {
                alert(response.responseJSON.message);
            }
        });
    });

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $('a#filter-button').click(function() {
        getProducts();
    });
    function getProducts(){
        //.find('input:visible') sluzy do wymuszenia by serialize lapal tylko widoczne pola ktore sa w form na stronie welcome.blade
        const form = $('form.sidebar-filter').find('input:visible').serialize();
        $.ajax({
            method: "GET",
            url: "/",
            data: form
        })
            .done(function( response ) {
                $('div#products-wrapper').empty();
                $.each(response.data, function(index, product) {
                    //jezeli istnieje zdjecie to jest wyswietlane a jesli nie to pisze no-image.png
                    let imagePath = (product.images && product.images.length > 0)
                        ? '/storage/products/' + product.images[0].image_url
                        : '/storage/no-image.png'; // fallback
                    const productUrl = '/product_page/' + product.id;

                    const html = `
                        <div class="col-12 col-sm-6 col-md-4">
                            <div id="pole" class="card h-100 border-0">
                                <a href="${productUrl}" style="text-decoration: none">
                                    <div class="card-img-top text-center">
                                        <img src="${imagePath}" class="img-fluid"
                                            alt="Photo"
                                            style="height: auto; object-fit: cover; width: 100%;">
                                    </div>
                                    <div class="card-body text-center">
                                        <h4 class="card-title">${product.name}</h4>
                                        <h5 class="card-price small"><i>${product.price} PLN </i></h5>
                                    </div>
                                </a>
                                <div style="display: none" id="product-quantity-{{$product->id}}">${product.quantity}</div>
                                <button class="btn btn-success btn-sm add-cart-button" data-id="${product.id}">
                                    <i class="fas fa-cart-plus"></i> Add to cart
                                </button>
                            </div>
                        </div>`;
                    $('div#products-wrapper').append(html);
                });
            })
            .fail(function (response){
                alert("nie dziala");
            });
    }


    $(document).on('click','.category-button',function (e){
        e.preventDefault();
        let categoryId = $(this).data('category');

        $.ajax({
            url: "/",
            method: "GET",
            data:{
                'filter[categories][]' : categoryId
            },
            dataType: "json"
        }).done(function (response){
            $('div#products-wrapper').empty();
            $.each(response.data, function(index, product) {
                let imagePath = (product.images && product.images.length > 0)
                    ? '/storage/products/' + product.images[0].image_url
                    : '/storage/no-image.png';

                const productUrl = '/product_page/' + product.id;
                const html = `
                    <div class="col-12 col-sm-6 col-md-4">
                        <div id="pole" class="card h-100 border-0">
                            <a href="${productUrl}" style="text-decoration: none">
                                <div class="card-img-top text-center">
                                    <img src="${imagePath}" class="img-fluid"
                                        alt="Photo"
                                        style="height: auto; object-fit: cover; width: 100%;">
                                </div>
                                <div class="card-body text-center">
                                    <h4 class="card-title">${product.name}</h4>
                                    <h5 class="card-price small"><i>${product.price} PLN </i></h5>
                                </div>
                            </a>
                            <div style="display: none" id="product-quantity-{{$product->id}}">${product.quantity}</div>
                            <button class="btn btn-success btn-sm add-cart-button" data-id="${product.id}">
                                <i class="fas fa-cart-plus"></i> Add to cart
                            </button>
                        </div>
                    </div>`;
                $('div#products-wrapper').append(html);
            });
        })
            .fail(function() {
                alert("Błąd filtrowania produktów");
            });
    });

    $(document).on('click','.sort-link',function (e){
        e.preventDefault();
        let sortValue = $(this).data('sort');

        $.ajax({
            url: "/",
            method: "GET",
            data: {
                sort: sortValue
            },
            dataType: "json",
        }).done(function (response){
            $('div#products-wrapper').empty();
            $.each(response.data, function(index, product) {
                let imagePath = (product.images && product.images.length > 0)
                    ? '/storage/products/' + product.images[0].image_url
                    : '/storage/no-image.png';

                const productUrl = '/product_page/' + product.id;
                const html = `
                    <div class="col-12 col-sm-6 col-md-4">
                        <div id="pole" class="card h-100 border-0">
                            <a href="${productUrl}" style="text-decoration: none">
                                <div class="card-img-top text-center">
                                    <img src="${imagePath}" class="img-fluid"
                                        alt="Photo"
                                        style="height: auto; object-fit: cover; width: 100%;">
                                </div>
                                <div class="card-body text-center">
                                    <h4 class="card-title">${product.name}</h4>
                                    <h5 class="card-price small"><i>${product.price} PLN </i></h5>
                                </div>
                            </a>
                            <div style="display: none" id="product-quantity-{{$product->id}}">${product.quantity}</div>
                            <button class="btn btn-success btn-sm add-cart-button" data-id="${product.id}">
                                <i class="fas fa-cart-plus"></i> Add to cart
                            </button>
                        </div>
                    </div>`;
                $('div#products-wrapper').append(html);
            });
        })
            .fail(function() {
                alert("Błąd filtrowania produktów");
            });
    });



