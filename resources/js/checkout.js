import '../css/checkout.css';

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

document.addEventListener('DOMContentLoaded',function (){
    const radios = document.querySelectorAll('input[name="shipping_method"]');

});
