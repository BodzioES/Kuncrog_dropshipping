$(function (){

    $(document).on('click','.update-cart',function (event){
        event.preventDefault();

        const productId = $(this).data('id');
        const action = $(this).data('action');

        $.ajax({
            url: '/cart/update/' + productId,
            type: 'POST',
            data:{
                _token: $('meta[name="csrf-token"]').attr('content'),
                action: action
            },
            success: function (response){
                $.ajax({
                    url: '/cart/modal',
                    method: 'GET',
                    success: function (modalContent){
                        $('#cartModalBody').html(modalContent);

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
