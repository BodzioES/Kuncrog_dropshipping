//to jest biblioteka umozliwiajaca wyswietlanie tego modala po dodaniu produktu do oszyka
import { Modal } from 'bootstrap';
window.bootstrap = { Modal };
$(function (){

    $('button.add-cart-button').click(function(event) {
        event.preventDefault();

        var productId = $(this).data('id');
        var quantity = 1;

        $.ajax({
            url: '/cart/' + productId,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                quantity: quantity
            },
            success: function(response) {
                $.ajax({
                    url: '/cart/modal',
                    method: 'GET',
                    success: function (modalContent) {
                        console.log('Modal content:', modalContent);
                        $('#cartModalBody').html(modalContent);
                        let cartModal = new bootstrap.Modal(document.getElementById('cartModal'), {});
                        cartModal.show();
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
                        '                                        <img src="https://dummyimage.com/300x240/fc00fc/000000.jpg&text=dawid+to+zjeb" class="img-fluid" alt="photo">\n' +
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
