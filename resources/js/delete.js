$(function () {
    $('.delete').click(function () {
        Swal.fire({
            title: "Czy na pewno chcesz usunąć rekord?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: 'Tak, usuń',
            cancelButtonText: 'Anuluj',
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "DELETE",
                    url: document.querySelector('script[data-url]').getAttribute('data-url') + '/' + $(this).data("id"),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                    .done(function(response) {
                        Swal.fire("Usunięto!", "Rekord został usunięty.", "success")
                            .then(() => {
                                window.location.reload(); // Przeładuj stronę po usunięciu
                            });
                    })
                    .fail(function(response) {
                        Swal.fire("Oops!", "Coś poszło nie tak.", "error");
                    });
            }
        });
    });
});
