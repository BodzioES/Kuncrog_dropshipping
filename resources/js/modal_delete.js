$(function (){
    $(document).on('click', '.delete-cart-item', function (event) {
        event.preventDefault();

       const productId = $(this).data('id');

       $.ajax({
           url: '/cart/' + productId,
           type: 'DELETE',
           data:{
               _token: $('meta[name="csrf-token"]').attr('content')
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
           error: function (xhr){
               console.error(xhr.responseText);
               alert('Cos poszlo nie tak...');
           }
       })
   });
});
