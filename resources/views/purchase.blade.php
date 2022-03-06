@push('extra-css')
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

    </style>
@endpush
@push('extra-js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        let stripe = Stripe("{{ env('STRIPE_KEY') }}")
        let elements = stripe.elements()
        let style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        }
        let card = elements.create('card', {
            style: style
        })
        card.mount('#card-element')
        let paymentMethod = null
        $('.card-form').on('submit', function(e) {
            $('button.pay').attr('disabled', true)
            if (paymentMethod) {
                return true
            }
            stripe.confirmCardSetup(
                "{{ $intent->client_secret }}", {
                    payment_method: {
                        card: card,
                        billing_details: {
                            name: $('.card_holder_name').val()
                        }
                    }
                }
            ).then(function(result) {
                if (result.error) {
                    $('#card-errors').text(result.error.message)
                    $('button.pay').removeAttr('disabled')
                } else {
                    paymentMethod = result.setupIntent.payment_method
                    $('.payment-method').val(paymentMethod)
                    $('.card-form').submit()
                }
            })
            return false
        })
    </script>
@endpush
<x-app-layout>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="border-b border-gray-200 bg-white p-6">

                <div class="mb-4 border-b text-center">
                    <h2>Checkout</h2>
                </div>

                @if (Session::has('error') || $errors->any())
                    <div class="alert alert-danger">
                        @if (Session::has('error'))
                            <p class="mb-0">{{ Session::get('error') }}</p>
                        @endif
                        @if ($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endif

                <div class="row g-5">
                    <div class="col-md-7">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-primary">Your cart</span>
                            <span class="badge bg-primary rounded-pill">{{ $cart->count() }}</span>
                        </h4>
                        <ul class="list-group mb-3">
                            @if ($cart->count() > 0)
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">{{ $cart->first()->product_name }}</h6>
                                        <small class="text-muted">{{ Str::limit($cart->first()->product->description ?? '', 30, '...') }}</small>
                                    </div>
                                    <span class="text-muted">x{{ $cart->sum('quantity') }}</span>
                                    <span class="text-muted">
                                        ${{ $cart->first()->price }}
                                    </span>
                                </li>
                            @else
                                <li class="list-group-item d-flex justify-content-between lh-sm">No product added for purchase</li>
                            @endif

                            @if (false)
                                <li class="list-group-item d-flex justify-content-between bg-light">
                                    <div class="text-success">
                                        <h6 class="my-0">Promo code</h6>
                                        <small>EXAMPLECODE</small>
                                    </div>
                                    <span class="text-success">−$5</span>
                                </li>
                            @endif

                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total (USD)</span>
                                <strong>${{ $cart->first()->price * $cart->sum('quantity') }}</strong>
                            </li>
                        </ul>

                        <form class="card p-2" action="#">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Promo code" disabled />
                                <button type="submit" class="btn btn-secondary" disabled>Redeem</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-5">
                        <form method="POST" action="{{ route('single-payment', $cart->first()->product_id) }}" class="card-form mt-3 mb-3">
                            @csrf
                            <input type="hidden" name="payment_method" class="payment-method">
                            <input class="StripeElement mb-3" name="card_holder_name" placeholder="Card holder name" required>
                            {{-- <div class="col-lg-4 col-md-6"> --}}
                            <div id="card-element"></div>
                            {{-- </div> --}}
                            <div id="card-errors" role="alert"></div>
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary pay">
                                    Purchase
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
