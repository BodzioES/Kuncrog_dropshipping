import '../css/checkout.css';

$(function (){

    //  KOD DO OBSLUGI ROZWIJANEJ LISTY ADRESU WYSYLKOWEGO

    const checkbox = $('#sameAddressCheckbox');
    const shippingDiv = $('#shipping-address');

    const toggleShippingAddress = () => {
        if (checkbox.prop('checked')){
            shippingDiv.hide();

            shippingDiv.find('input').each(function (){
               $(this).prop('disabled',true).removeAttr('required');
            });
        }else{
            shippingDiv.show();

            shippingDiv.find('input').each(function (){
                $(this).prop('disabled',false).attr('required','required');
            });
        }
    };

    toggleShippingAddress();
    checkbox.on('change',toggleShippingAddress);

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
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();
            if (data.success) {
                await Swal.fire({
                    title: 'Sukces!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: '<i class="fas fa-check"></i> OK'
                });
                window.location.href = '/';
            } else {
                await Swal.fire('Błąd!', data.message || 'Nie udało się zapisać zamówienia', 'error');
            }
        } catch (err) {
            console.error(err);
            await Swal.fire('Błąd!', 'Wystąpił problem z serwerem', 'error');
        }
    });
});

//  FUNKCJE ZWIAZANE Z PACZKOMATEM INPOST
document.addEventListener("DOMContentLoaded", function() {
    const shippingRadios = document.querySelectorAll('input[name="id_shipping_method"]');
    const inpostSection = document.getElementById('inpost-section');
    const lockerInput = document.getElementById('inpostLocker');
    const lockerInfo = document.getElementById('lockerInfo');
    const modal = document.getElementById('inpostModal');
    const openModalBtn = document.getElementById('openInpostModal');
    const closeModalBtn = document.querySelector(".inpost-close");

    if (!openModalBtn || !modal) return;

    // otwieranie modala
    openModalBtn.addEventListener("click", () => {
        modal.style.display = "flex";
        document.body.classList.add("modal-open"); // 🔒 blokada scrolla
    });

    // zamykanie modala (krzyżyk)
    closeModalBtn.addEventListener("click", () => {
        modal.style.display = "none";
        document.body.classList.remove("modal-open"); // 🔓 przywrócenie scrolla
    });

    // zamykanie po kliknięciu poza mapą
    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
            document.body.classList.remove("modal-open");
        }
    });

    //  Gdy uzytkownik wybierze paczkoamt
    document.addEventListener("onpointselect", function(event) {
        const point = event.detail;
        if (!point) return;

        //   Zapisanie kodu paczkomatu do ukrytego inputa
        lockerInput.value = point.name;

        //  Pokazanie informacji pod przyciskiem
        lockerInfo.textContent = `📦 Selected: ${point.name}`;

        //  Zamkniecie modala
        modal.style.display = "none";
        document.body.classList.remove("modal-open");
    });

    // Pokaż sekcję tylko przy metodzie InPost
    shippingRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const labelText = this.closest('label').innerText.toLowerCase();

            if (labelText.includes('inpost')) {
                inpostSection.style.display = 'block';
            } else {
                inpostSection.style.display = 'none';
                lockerInfo.textContent = '';
                lockerInput.value = '';
            }
        });
    });
});
