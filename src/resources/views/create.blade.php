@extends('layouts.app')

@section('content')
    <div class="container" style="text-align: center; font-size: 16px;">
        @if (session('flash_alert'))
            <div class="alert alert-danger">{{ session('flash_alert') }}</div>
        @elseif(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <div class="p-5">
            <div class="col-6 card" style="margin: 10% auto;">
                <div class="card-header" style="font-size: 20px; font-weight: bold; background-color: white;">Stripe決済</div>
                <div class="card-body">
                    <form id="card-form" action="{{ route('payment.store', $item->id ) }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <div>
                            <label for="card_number" style="margin-top: 5px;">カード番号</label>
                            <div id="card-number" class="form-control" style="padding: 10px; margin-top: 5px; height: 40px;"></div>
                        </div>

                        <div>
                            <label for="card_expiry" style="margin-top: 5px;">有効期限</label>
                            <div id="card-expiry" class="form-control" style="padding: 10px; margin-top: 5px; height: 40px;"></div>
                        </div>

                        <div>
                            <label for="card-cvc" style="margin-top: 5px;">セキュリティコード</label>
                            <div id="card-cvc" class="form-control" style="padding: 10px; margin-top: 5px; height: 40px;"></div>
                        </div>

                        <div id="card-errors" class="text-danger"></div>

                        <a href="{{ route('item.purchase',['item_id' => $item->id ]) }}" class="mt-3 btn btn-secondary" style="padding: 10px 20px;">戻る</a>
                        <button class="mt-3 btn btn-primary" type="submit" style="padding: 10px 20px;">支払い</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe("{{ config('stripe.stripe_public_key') }}");
        const elements = stripe.elements();

        const cardNumber = elements.create('cardNumber');
        const cardExpiry = elements.create('cardExpiry');
        const cardCvc = elements.create('cardCvc');

        cardNumber.mount('#card-number');
        cardExpiry.mount('#card-expiry');
        cardCvc.mount('#card-cvc');

        const form = document.getElementById('card-form');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(cardNumber).then(function(result) {
                if (result.error) {
                    const errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    const token = result.token;

                    const hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', token.id);
                    form.appendChild(hiddenInput);

                    const hiddenBookingId = document.createElement('input');
                    hiddenBookingId.setAttribute('type', 'hidden');
                    hiddenBookingId.setAttribute('name', 'item_id');
                    hiddenBookingId.setAttribute('value', document.querySelector('input[name="item_id"]').value);
                    form.appendChild(hiddenitemId);

                    form.submit();
                }
            });
        });
    </script>
@endsection
