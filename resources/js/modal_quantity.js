$(function (){

    //po kliknieciu guzika ktora dodaje o jeden wiecej produkt do cart_modal_conent.blade.php wykonuje sie ponizszy ajax
    $(document).on('click','.update-cart',function (event){
        event.preventDefault();

        //pobierane sa dane od przyciskow takie jak id produktu oraz akcja wykonana (odjecie produktu badz dodanie)
        const productId = $(this).data('id');
        const action = $(this).data('action');

        $.ajax({
            url: '/cart/update/' + productId,
            type: 'POST',
            data:{
                _token: $('meta[name="csrf-token"]').attr('content'),
                action: action
            },
            //jesli sie powiedzie to wykonuje sie ajax ktory pokazuje aktualny stan koszyka czyli nasza zmiane ilosci danego produktu lacznie z aktualizacja ceny
            success: function (response){
                $.ajax({
                    url: '/cart/modal',
                    method: 'GET',
                    success: function (modalContent){
                        $('#cartModalBody').html(modalContent);

                        //jesli sie powiedzie to wykonuje sie kolejny ajax XD, ktory aktualizuje bez przeladowania strony ta czerwona kropeczke przy ikonie koszyka
                        $.ajax({
                            url: '/cart/count',
                            method: 'GET',
                            success: function (data){
                                const count = data.count;
                                const $badge = $('#cart-count-badge');

                                if (count > 0){
                                    $badge.text(count).removeClass('d-none');
                                }else{
                                    $badge.addClass('d-none');
                                }
                            }
                        })
                    }
                });
            },
            error: function (){
                alert('Wystąpił błąd podczas aktualizacji koszyka.');
            }
        })
    })

});
