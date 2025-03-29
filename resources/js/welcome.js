$(function (){

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
