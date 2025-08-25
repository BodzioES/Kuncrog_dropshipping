//to jest biblioteka umozliwiajaca wyswietlanie tego modala po dodaniu produktu do koszyka
import { Modal } from 'bootstrap';
window.bootstrap = { Modal };

    //wykonuje sie po wcisnieciu przycisku z welcome.blade.php
    //dodaje on produkt do koszyka
    $('button.add-cart-button').click(function(event) {
        event.preventDefault();

        //pobiera odpowiednie id produktu dzieki data-id="{{ $product->id }}" ktory jest w przycisku
        var productId = $(this).data('id');
        var quantity = 1;

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
        const form = $('form.sidebar-filter').serialize();
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
                    <div class="col-6 col-md-6 col-lg-4 mb-3">
                        <a href="${productUrl}" style="text-decoration: none">
                            <div class="card h-100 border-0">
                                <div class="card-img-top">
                                    <img src="${imagePath}" class="img-fluid" alt="photo">
                                </div>
                                <div class="card-body text-center">
                                    <h4 class="card-title">${product.name}</h4>
                                    <h5 class="card-price small"><i>${product.price} PLN </i></h5>
                                </div>
                                <button class="btn btn-success btn-sm add-cart-button" data-id="${product.id}">
                                    <i class="fas fa-cart-plus"></i> Dodaj do koszyka
                                </button>
                            </div>
                        </a>
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
            <div class="col-6 col-md-6 col-lg-4 mb-3">
                <a href="${productUrl}" style="text-decoration: none">
                    <div class="card h-100 border-0">
                        <div class="card-img-top">
                            <img src="${imagePath}" class="img-fluid" alt="photo">
                        </div>
                        <div class="card-body text-center">
                            <h4 class="card-title">${product.name}</h4>
                            <h5 class="card-price small"><i>${product.price} PLN</i></h5>
                        </div>
                        <button class="btn btn-success btn-sm add-cart-button" data-id="${product.id}">
                            <i class="fas fa-cart-plus"></i> Dodaj do koszyka
                        </button>
                    </div>
                </a>
            </div>`;
                $('div#products-wrapper').append(html);
            });
        })
            .fail(function() {
                alert("Błąd filtrowania produktów");
            });
    });



