document.addEventListener('DOMContentLoaded', function() {
    const paymentSelect = document.querySelector('.payment_method');
    const paymentDisplay = document.querySelector('.payment-method-display');

    paymentSelect.addEventListener('change', function() {
        const selectedText = paymentSelect.options[paymentSelect.selectedIndex].text;

        paymentDisplay.textContent = selectedText;
    });
});
