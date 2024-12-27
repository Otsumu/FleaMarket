document.addEventListener('DOMContentLoaded', function() {
    const paymentSelect = document.querySelector('.payment_method');
    const paymentDisplay = document.querySelector('.payment-method-display');
    const hiddenInput = document.querySelector('#hidden_payment_method');

    paymentSelect.addEventListener('change', function() {
        paymentDisplay.textContent = this.options[this.selectedIndex].text;
        hiddenInput.value = this.value;
    });
});