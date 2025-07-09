$(function (){
    //usuwanie produktu z modal cart (tego mini koszyka)
    $(document).on('click', '.delete-cart-item', function (event) {
        event.preventDefault();

        //pobieranie id productu z  data-id="{{ $item->product->id ?? $item['id'] }}" z cart_modal_content.blade.php
       const productId = $(this).data('id');

       $.ajax({
           url: '/cart/' + productId,
           type: 'DELETE',
           data:{
               _token: $('meta[name="csrf-token"]').attr('content')
           },
           //jesli sie powiedzie to nastepuje aktualizacja cart modal aby wyswietlic to bez danego usunietego produktu
           success: function (response){
              $.ajax({
                  url: '/cart/modal',
                  method: 'GET',
                  success: function (modalContent){
                      $('#cartModalBody').html(modalContent);

                      //gdy powyzej sie powiedzie to nastepuje aktuzalizacja tej czerwonej kropeczki przy ikonie koszyla
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
           error: function (xhr){
               console.error(xhr.responseText);
               alert('Cos poszlo nie tak...');
           }
       })
   });
});
