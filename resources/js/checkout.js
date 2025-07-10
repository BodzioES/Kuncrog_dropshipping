import '../css/checkout.css';

$(function (){
    const checkbox = $('#sameAddressCheckbox');
    const shippingDiv = $('#shipping-adress');

    const toggleShippingAdress = () => {
        if (checkbox.prop('checked')){
            shippingDiv.hide();
        }else{
            shippingDiv.show();
        }
    };

    toggleShippingAdress();
    checkbox.on('change',toggleShippingAdress);

    //w podsumowaniu uzywane jest to gdy wybieramy metode dostawy aby aktualizowac na biezaco cene
    //ktora jest w podsumowaniu (kurierzy maja rozne ceny)
    $(document).ready(function (){
        $('input[name="id_shipping_method"]').on('change',function (){
            const shippingId = $(this).val();

            $.ajax({
                url:'/checkout/update-total',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id_shipping_method: shippingId
                },
                success: function (data){
                    $('#shippingCost').text(data.shippingCost + ' zł');
                    $('#totalPrice').text(data.totalPrice + ' zł');
                },
                error: function (){
                    alert('Błąd podczas aktualizacji ceny dostawy');
                }
            })
        })
    });

    //to ma sluzyc do zaznaczania adresu wysylkowego ktory ma sie sumowac z cena produktow na samym dole
    document.addEventListener('DOMContentLoaded',function (){
        document.querySelectorAll('input[name="shipping_method"]');
    });

    // kod do zlozenia zamowienia na stronie checkout
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('#checkout-form').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            try {
                const response = await fetch('/checkout', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire('Sukces!', 'Zamówienie zostało złożone', 'success')
                        .then(() => window.location.href = '/');
                } else {
                    await Swal.fire('Błąd!', 'Nie udało się zapisać zamówienia', 'error');
                }
            } catch (err) {
                console.error(err);
                await Swal.fire('Błąd!', 'Wystąpił problem z serwerem', 'error');
            }
        });
    });
});
