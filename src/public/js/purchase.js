document.getElementById('paymentMethod').addEventListener('change', function() {
    var selectedPaymentMethod = this.value;
    document.getElementById('hidden_payment_method').value = selectedPaymentMethod;

    var paymentMethodDisplay = document.querySelector('.payment-method-display');
    if (selectedPaymentMethod === 'credit_card') {
        paymentMethodDisplay.textContent = 'カード支払い';
    } else if (selectedPaymentMethod === 'convenience_store') {
        paymentMethodDisplay.textContent = 'コンビニ支払い';
    } else {
        paymentMethodDisplay.textContent = '選択してください';
    }
});

