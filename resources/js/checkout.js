import '../css/checkout.css';

//obsluga adresu rozliczeniowego (ten co sie wysuwa na stronie checkout po odznaczeniu)
document.addEventListener('DOMContentLoaded', () => {
    const checkbox = document.getElementById('sameAddressCheckbox');
    const shippingDiv = document.getElementById('shipping-adress');

    const toggleShippingAdress = () => {
        if (checkbox.checked){
            shippingDiv.style.display = 'none';
        }else{
            shippingDiv.style.display = 'block';
        }
    };

    toggleShippingAdress();

    checkbox.addEventListener('change', toggleShippingAdress);
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
