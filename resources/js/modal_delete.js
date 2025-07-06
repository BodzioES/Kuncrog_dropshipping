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
