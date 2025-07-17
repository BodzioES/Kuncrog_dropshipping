//to jest biblioteka umozliwiajaca wyswietlanie tego modala po dodaniu produktu do koszyka
import { Modal } from 'bootstrap';
window.bootstrap = { Modal };
$(function (){

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
                $.each(response.data,function (index, product){
                    const html = '<div class="col-6 col-md-6 col-lg-4 mb-3">\n' +
                        '                                <div class="card h-100 border-0">\n' +
                        '                                    <div class="card-img-top">\n' +
                        '                                        <img src="https://dummyimage.com/300x240/fc00fc/000000.jpg&text=image" class="img-fluid" alt="photo">\n' +
                        '                                    </div>\n' +
                        '                                    <div class="card-body text-center">\n' +
                        '                                        <h4 class="card-title">\n' +
                                                                    product.name +
                        '                                        </h4>\n' +
                        '                                        <h5 class="card-price small">\n' +
                        '                                            <i>PLN '+ product.price +'</i>\n' +
                        '                                        </h5>\n' +
                        '                                    </div>\n' +
                        '                                    <button class="btn btn-success btn-sm add-cart-button" data-id="{{ $product->id }}">\n' +
                        '                                        <i class="fas fa-cart-plus"></i> Dodaj do koszyka\n' +
                        '                                    </button>\n' +
                        '                                </div>\n' +
                        '                            </div>'
                    $('div#products-wrapper').append(html);
                });
            })
            .fail(function (response){
                alert("nie dziala");
            });
    }
});
