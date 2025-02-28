$(function (){
    $('.delete').click(function (){
        Swal.fire({
            title: "Czy na pewno chcesz usunąć rekord?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: 'Tak, usuń',
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "DELETE",
                    url: document.querySelector('script[type="text/javascript"]').getAttribute('data-url') + $(this).data("id")
                })
                    .done(function( response ) {
                        window.location.reload();
                    })
                    .fail(function (response){
                        Swal.fire("Oops!", "Something went wrong!", "error");
                    });
            }
        });
    });
});
