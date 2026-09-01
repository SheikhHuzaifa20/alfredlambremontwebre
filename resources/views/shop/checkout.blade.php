@extends('layouts.main')

@section('title', 'Checkout — Alfred Lambremont Webre')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css"
      integrity="sha512-wJgJNTBBkLit7ymC6vvzM1EcSWeM9mmOu+1USHaRBbHkm6W9EgM0HY27+UtUaprntaYQJF75rc8gjxllKs5OIQ=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
/* ── Checkout Page Styles ────────────────────── */
.co-hero {
    position: relative;
    padding: 72px 0 50px;
    overflow: hidden;
    background: linear-gradient(180deg, rgba(29,36,82,.75), rgba(11,16,38,0));
    border-bottom: 1px solid var(--rule);
}
.co-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 75% 30%, rgba(200,162,75,.06), transparent 55%);
    pointer-events: none;
}
.co-hero h1 {
    font-family: var(--display);
    font-size: clamp(36px, 5vw, 62px);
    font-weight: 400;
    letter-spacing: -.01em;
    line-height: 1.05;
}
.co-breadcrumb {
    font-family: var(--mono);
    font-size: 11px;
    letter-spacing: .16em;
    text-transform: uppercase;
    color: var(--parchment-dim);
    margin-bottom: 18px;
}
.co-breadcrumb a:hover { color: var(--brass); }

.co-section { padding: 70px 0 100px; }

.co-layout {
    display: grid;
    grid-template-columns: 1fr 420px;
    gap: 50px;
    align-items: start;
}
@media(max-width:900px) {
    .co-layout { grid-template-columns: 1fr; gap: 40px; }
}

/* ── Headings ── */
.co-heading {
    font-family: var(--mono);
    font-size: 11px;
    letter-spacing: .22em;
    text-transform: uppercase;
    color: var(--brass);
    margin-bottom: 24px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--rule);
}

/* ── Form ── */
.co-form .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
@media(max-width:600px) { .co-form .form-row { grid-template-columns: 1fr; } }
.co-form .form-group { margin-bottom: 16px; }
.co-form label {
    display: block;
    font-family: var(--mono);
    font-size: 10.5px;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--parchment-dim);
    margin-bottom: 7px;
}
.co-form input,
.co-form textarea,
.co-form select {
    width: 100%;
    background: rgba(11,16,38,.65);
    border: 1px solid rgba(237,231,218,.18);
    border-radius: 3px;
    padding: 13px 15px;
    color: var(--parchment);
    font-family: var(--body);
    font-size: 15px;
    transition: border-color .2s;
    flex: unset;
    min-width: unset;
}
.co-form input:focus,
.co-form textarea:focus,
.co-form select:focus {
    border-color: var(--signal);
    outline: none;
    box-shadow: 0 0 0 3px rgba(111,211,199,.08);
}
.co-form input::placeholder,
.co-form textarea::placeholder { color: #5A5650; }
.co-form .err-msg {
    display: block;
    font-family: var(--mono);
    font-size: 10.5px;
    color: #E08A7A;
    margin-top: 5px;
}
.co-form select { appearance: none; }

/* Login nudge */
.login-nudge {
    font-family: var(--mono);
    font-size: 11px;
    letter-spacing: .08em;
    color: var(--parchment-dim);
    margin-bottom: 24px;
    padding: 14px 18px;
    border: 1px solid var(--rule);
    border-radius: 3px;
    background: rgba(29,36,82,.3);
}
.login-nudge a { color: var(--signal); }

/* ── Right panel ── */
.co-panel {
    position: sticky;
    top: 90px;
}

/* Order summary */
.co-order-box {
    border: 1px solid var(--rule);
    border-radius: 3px;
    background: rgba(20,27,61,.5);
    overflow: hidden;
    margin-bottom: 24px;
}
.co-order-items {
    padding: 0 22px;
    max-height: 280px;
    overflow-y: auto;
}
.co-order-item {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    padding: 14px 0;
    border-bottom: 1px solid var(--rule);
    gap: 12px;
}
.co-order-item:last-child { border-bottom: none; }
.co-item-name {
    font-family: var(--body);
    font-size: 14.5px;
    line-height: 1.4;
    color: var(--parchment);
}
.co-item-qty {
    font-family: var(--mono);
    font-size: 10px;
    letter-spacing: .1em;
    color: var(--parchment-dim);
    white-space: nowrap;
}
.co-item-price {
    font-family: var(--mono);
    font-size: 14px;
    white-space: nowrap;
}

.co-totals {
    padding: 18px 22px;
    border-top: 1px solid var(--rule);
    background: rgba(11,16,38,.35);
}
.co-total-row {
    display: flex;
    justify-content: space-between;
    font-family: var(--mono);
    font-size: 12.5px;
    letter-spacing: .04em;
    padding: 6px 0;
    color: var(--parchment-dim);
}
.co-total-row.grand {
    font-size: 16px;
    color: var(--parchment);
    border-top: 1px solid var(--rule);
    margin-top: 10px;
    padding-top: 14px;
}

/* ── Payment block ── */
.co-payment-block {
    border: 1px solid var(--rule);
    border-radius: 3px;
    background: rgba(20,27,61,.4);
    overflow: hidden;
}
.co-pay-tab {
    display: flex;
    border-bottom: 1px solid var(--rule);
}
.co-pay-tab-btn {
    flex: 1;
    padding: 14px 10px;
    font-family: var(--mono);
    font-size: 11px;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--parchment-dim);
    background: none;
    border: none;
    border-bottom: 2px solid transparent;
    cursor: pointer;
    transition: .2s;
}
.co-pay-tab-btn.active {
    color: var(--brass);
    border-bottom-color: var(--brass);
    background: rgba(200,162,75,.06);
}
.co-pay-body { display: none; padding: 24px; }
.co-pay-body.active { display: block; }

/* Stripe element */
.StripeElement {
    background: rgba(11,16,38,.7);
    border: 1px solid rgba(237,231,218,.18);
    border-radius: 3px;
    padding: 13px 15px;
    margin-bottom: 12px;
    transition: border-color .2s;
}
.StripeElement--focus { border-color: var(--signal); }
.StripeElement--invalid { border-color: #E08A7A; }
#card-errors {
    font-family: var(--mono);
    font-size: 11px;
    color: #E08A7A;
    margin-bottom: 12px;
    display: none;
}

/* Pay button */
.co-pay-btn {
    width: 100%;
    background: var(--brass);
    color: var(--ink);
    font-family: var(--mono);
    font-size: 12px;
    letter-spacing: .14em;
    text-transform: uppercase;
    padding: 15px;
    border-radius: 2px;
    border: none;
    cursor: pointer;
    transition: background .2s;
    margin-top: 6px;
}
.co-pay-btn:hover { background: #DCB963; }
.co-pay-btn:disabled { opacity: .55; cursor: default; }

/* Stripe logos */
.co-stripe-logos {
    margin-top: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: var(--mono);
    font-size: 9.5px;
    letter-spacing: .08em;
    color: var(--parchment-dim);
}
.co-stripe-logos img { height: 22px; }

/* Alert banner */
.co-alert {
    border-radius: 3px;
    padding: 14px 18px;
    margin-bottom: 20px;
    font-family: var(--mono);
    font-size: 11.5px;
    letter-spacing: .04em;
}
.co-alert-danger {
    background: rgba(224,138,122,.12);
    border: 1px solid rgba(224,138,122,.4);
    color: #E08A7A;
}
</style>
@endsection

@section('content')

{{-- ── Hero ── --}}
<section class="co-hero">
    <svg class="starfield" aria-hidden="true"></svg>
    <div class="wrap">
        <p class="co-breadcrumb">
            <a href="{{ route('books') }}">Books</a>
            <span style="margin:0 10px;opacity:.4">→</span>
            Checkout
        </p>
        <h1>Checkout</h1>
    </div>
</section>

{{-- ── Body ── --}}
<section class="co-section">
    <div class="wrap">

        {{-- Error alerts --}}
        @if ($errors->any())
        <div class="co-alert co-alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
        @endif

        @if (Session::has('stripe_error'))
        <div class="co-alert co-alert-danger">{{ Session::get('stripe_error') }}</div>
        @endif

        <div class="co-layout">

            {{-- ══ LEFT: Billing Form ══ --}}
            <div>
                <h2 class="co-heading">Billing Details</h2>

                @if(!Auth::check())
                <div class="login-nudge">
                    Returning customer? <a href="{{ url('signin') }}">Click here to sign in</a>
                </div>
                @endif

                <form action="{{ route('order.place') }}" method="POST" id="order-place" class="co-form">
                    @csrf
                    <input type="hidden" name="payment_id"     value="">
                    <input type="hidden" name="payer_id"       value="">
                    <input type="hidden" name="payment_status" value="">
                    <input type="hidden" name="payment_method" id="payment_method" value="stripe">

                    @if(Auth::check())
                        @php $_getUser = DB::table('users')->where('id', Auth::user()->id)->first(); @endphp

                        <div class="form-row">
                            <div class="form-group">
                                <label for="f-name">First Name *</label>
                                <input id="f-name" name="first_name" type="text" required
                                       placeholder="First Name"
                                       value="{{ old('first_name', $_getUser->name ?? '') }}">
                                @error('first_name')<span class="err-msg">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="l-name">Last Name</label>
                                <input id="l-name" name="last_name" type="text"
                                       placeholder="Last Name"
                                       value="{{ old('last_name') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input id="email" name="email" type="email" required
                                   placeholder="you@example.com"
                                   value="{{ old('email', $_getUser->email ?? '') }}">
                            @error('email')<span class="err-msg">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="phone_no">Phone *</label>
                            <input name="phone_no" type="text" required
                                   placeholder="+1 555 000 0000"
                                   value="{{ old('phone_no') }}">
                            @error('phone_no')<span class="err-msg">{{ $message }}</span>@enderror
                        </div>

                    @else

                        <div class="form-row">
                            <div class="form-group">
                                <label for="f-name">First Name *</label>
                                <input id="f-name" name="first_name" type="text" required
                                       placeholder="First Name" value="{{ old('first_name') }}">
                                @error('first_name')<span class="err-msg">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="l-name">Last Name</label>
                                <input id="l-name" name="last_name" type="text"
                                       placeholder="Last Name" value="{{ old('last_name') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input id="email" name="email" type="email" required
                                   placeholder="you@example.com" value="{{ old('email') }}">
                            @error('email')<span class="err-msg">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="phone_no">Phone *</label>
                            <input name="phone_no" type="text" required
                                   placeholder="+1 555 000 0000" value="{{ old('phone_no') }}">
                            @error('phone_no')<span class="err-msg">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group" style="display:flex;align-items:center;gap:10px">
                            <input type="checkbox" name="create_account" id="create_account"
                                   {{ old('create_account') ? 'checked' : '' }}
                                   style="width:auto;min-width:auto;flex:unset">
                            <label for="create_account" style="margin:0;cursor:pointer">Create an account?</label>
                        </div>
                        <div class="form-row" id="pw-fields">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" placeholder="Password">
                                @error('password')<span class="err-msg">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_password" placeholder="Confirm">
                            </div>
                        </div>
                    @endif

                    {{-- Address --}}
                    <h2 class="co-heading" style="margin-top:32px">Shipping Address</h2>

                    <div class="form-group">
                        <label for="address">Street Address *</label>
                        <input id="address" name="address_line_1" type="text" required
                               placeholder="123 Main Street" value="{{ old('address_line_1') }}">
                        @error('address_line_1')<span class="err-msg">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City *</label>
                            <input id="city" name="city" type="text" required
                                   placeholder="City" value="{{ old('city') }}">
                            @error('city')<span class="err-msg">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="zip_code">Postcode / ZIP</label>
                            <input id="zip_code" name="zip_code" type="text"
                                   placeholder="10001" value="{{ old('zip_code') }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="state">State / Region</label>
                            <input id="state" name="state" type="text"
                                   placeholder="State" value="{{ old('state') }}">
                        </div>
                        <div class="form-group">
                            <label for="country">Country *</label>
                            <input id="country" name="country" type="text" required
                                   placeholder="United States" value="{{ old('country') }}">
                            @error('country')<span class="err-msg">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="comment">Order Notes (optional)</label>
                        <textarea id="comment" name="order_notes" rows="4"
                                  placeholder="Anything we should know about your order?">{{ old('order_notes') }}</textarea>
                    </div>
                </form>
            </div>

            {{-- ══ RIGHT: Order + Payment ══ --}}
            <div class="co-panel">

                {{-- Order Summary --}}
                <h2 class="co-heading">Your Order</h2>
                <div class="co-order-box">
                    <div class="co-order-items">
                        @php $subtotal = 0; @endphp
                        @foreach($cart as $key => $value)
                            @php
                                if (!is_array($value) || !isset($value['baseprice'])) continue;
                                $lineTotal = $value['baseprice'] * $value['qty'];
                                $subtotal += $lineTotal;
                            @endphp
                            <div class="co-order-item">
                                <div>
                                    <div class="co-item-name">{{ $value['name'] }}</div>
                                    <div class="co-item-qty">Qty: {{ $value['qty'] }}</div>
                                </div>
                                <div class="co-item-price">${{ number_format($lineTotal, 2) }}</div>
                            </div>
                        @endforeach
                    </div>
                    <div class="co-totals">
                        <div class="co-total-row">
                            <span>Subtotal</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="co-total-row">
                            <span>Shipping</span>
                            <span style="color:var(--signal)">Calculated at confirmation</span>
                        </div>
                        <div class="co-total-row grand">
                            <span>Total</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Payment --}}
                <h2 class="co-heading" style="margin-top:28px">Payment Method</h2>
                <div class="co-payment-block">
                    <div class="co-pay-tab">
                        <button class="co-pay-tab-btn active" data-tab="stripe" id="tabStripe">
                            Credit / Debit Card
                        </button>
                        <button class="co-pay-tab-btn" data-tab="paypal" id="tabPaypal">
                            PayPal
                        </button>
                    </div>

                    {{-- Stripe --}}
                    <div class="co-pay-body active" id="bodyStripe">
                        <div class="stripe-form-wrapper"
                             data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                             data-cc-on-file="false">
                            <div id="card-element"></div>
                            <div id="card-errors" role="alert"></div>
                            <button class="co-pay-btn" type="button" id="stripe-submit">
                                Place Order &amp; Pay ${{ number_format($subtotal, 2) }}
                            </button>
                        </div>
                        <div class="co-stripe-logos">
                            <span>Secured by</span>
                            <img src="https://stripe.com/img/v3/home/twitter.png"
                                 onerror="this.style.display='none'"
                                 alt="Stripe">
                            <span>SSL encrypted</span>
                        </div>
                    </div>

                    {{-- PayPal --}}
                    <div class="co-pay-body" id="bodyPaypal">
                        <p style="font-family:var(--mono);font-size:11px;color:var(--parchment-dim);margin-bottom:16px">
                            You will be redirected to PayPal to complete payment.
                        </p>
                        <input type="hidden" name="price_pp"      value="{{ $subtotal }}">
                        <div id="paypal-button-container-popup"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
        integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>
/* ── Payment tab switcher ── */
document.querySelectorAll('.co-pay-tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.co-pay-tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.co-pay-body').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('body' + btn.dataset.tab.charAt(0).toUpperCase() + btn.dataset.tab.slice(1)).classList.add('active');
        document.getElementById('payment_method').value = btn.dataset.tab;
    });
});

/* ── Stripe ── */
const stripe   = Stripe('{{ env("STRIPE_KEY") }}');
const elements = stripe.elements();
const style = {
    base: {
        color: '#EDE7DA',
        lineHeight: '20px',
        fontFamily: '"IBM Plex Mono", monospace',
        fontSmoothing: 'antialiased',
        fontSize: '14px',
        '::placeholder': { color: '#5A5650' }
    },
    invalid: { color: '#E08A7A', iconColor: '#E08A7A' }
};
const card = elements.create('card', { style });
card.mount('#card-element');

card.addEventListener('change', function(event) {
    const displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.style.display = 'block';
        displayError.textContent = event.error.message;
    } else {
        displayError.style.display = 'none';
        displayError.textContent = '';
    }
});

document.getElementById('stripe-submit').addEventListener('click', function() {
    const btn = this;
    if (!validateForm()) return;

    btn.disabled = true;
    btn.textContent = 'Processing…';

    stripe.createToken(card).then(function(result) {
        if (result.error) {
            const errEl = document.getElementById('card-errors');
            errEl.style.display = 'block';
            errEl.textContent = result.error.message;
            btn.disabled = false;
            btn.textContent = 'Place Order & Pay ${{ number_format($subtotal, 2) }}';
        } else {
            stripeTokenHandler(result.token);
        }
    });
});

function stripeTokenHandler(token) {
    const form  = document.getElementById('order-place');
    const input = document.createElement('input');
    input.setAttribute('type',  'hidden');
    input.setAttribute('name',  'stripeToken');
    input.setAttribute('value', token.id);
    form.appendChild(input);
    document.getElementById('payment_method').value = 'stripe';
    form.submit();
}

/* ── PayPal ── */
paypal.Button.render({
    env: 'sandbox',
    style: { label: 'checkout', size: 'responsive', shape: 'rect', color: 'gold' },
    client: {
        sandbox: 'AV06KMdIerC8pd6_i1gQQlyVoIwV8e_1UZaJKj9-aELaeNXIGMbdR32kDDEWS4gRsAis6SRpUVYC9Jmf',
    },
    onClick: function() {
        if (!validateForm()) {
            showToast('Please complete all required fields first.', 'error');
        }
    },
    payment: function(data, actions) {
        return actions.payment.create({
            payment: { transactions: [{ amount: { total: {{ number_format((float)$subtotal, 2, '.', '') }}, currency: 'USD' } }] }
        });
    },
    onAuthorize: function(data, actions) {
        return actions.payment.execute().then(function() {
            document.querySelector('input[name="payment_status"]').value = 'Completed';
            document.querySelector('input[name="payment_id"]').value     = data.paymentID;
            document.querySelector('input[name="payer_id"]').value       = data.payerID;
            document.getElementById('payment_method').value              = 'paypal';
            document.getElementById('order-place').submit();
        });
    },
    onCancel: function(data) {
        document.querySelector('input[name="payment_status"]').value = 'Failed';
    }
}, '#paypal-button-container-popup');

/* ── Form validation ── */
function validateForm() {
    let ok = true;
    document.querySelectorAll('#order-place input[required]').forEach(inp => {
        if (!inp.value.trim()) {
            inp.style.borderColor = '#E08A7A';
            ok = false;
        } else {
            inp.style.borderColor = '';
        }
    });
    if (!ok) {
        showToast('Please fill in all required fields.', 'error');
    }
    return ok;
}

function showToast(msg, type) {
    $.toast({
        heading: type === 'error' ? 'Error' : 'Notice',
        position: 'bottom-right',
        text: msg,
        loaderBg: type === 'error' ? '#E08A7A' : '#6FD3C7',
        icon: type === 'error' ? 'error' : 'info',
        hideAfter: 4000,
        stack: 4
    });
}
</script>
@endsection
