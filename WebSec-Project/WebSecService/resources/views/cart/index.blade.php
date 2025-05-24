@extends('layouts.master')
@section('title','Your Cart')

@section('content')
<style>
    body {
        min-height: 100vh;
        background:
            linear-gradient(rgba(220,20,60,0.07), rgba(220,20,60,0.07)),
            url('https://ik.imagekit.io/jyx7871cz/2148633547.jpg') no-repeat center center fixed;
        background-size: cover;
        color: #222;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    .cart-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 32px 0 40px 0;
    }
    .modern-card {
        background: #fff;
        border: 1.5px solid #dc143c33;
        border-radius: 1.1rem;
        box-shadow: 0 6px 24px 0 rgba(220,20,60,0.10);
        margin-bottom: 1.3rem;
        color: #222;
        transition: box-shadow 0.2s;
    }
    .modern-card:hover {
        box-shadow: 0 10px 32px 0 rgba(220,20,60,0.18);
    }
    h1 {
        text-align: center;
        margin-bottom: 2.2rem;
        font-size: 2.3rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        color: #dc143c;
        text-shadow: 0 2px 8px rgba(220,20,60,0.08);
    }
    @media (max-width: 800px) {
        .cart-container {
            max-width: 98vw;
            padding: 16px 0 20px 0;
        }
    }
</style>

<div class="cart-container">
    <div class="modern-card" style="padding:2.2rem 2rem;">
        <h1>Your Cart</h1>

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(!$cart || $cart->items->isEmpty())
          <p>Your cart is empty.</p>
        @else
          <table class="table">
            <thead>
              <tr>
                <th>Product</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($cart->items as $item)
                <tr>
                  <td>{{ $item->product->name }}</td>
                  <td>${{ number_format($item->product->price, 2) }}</td>
                  <td>
                    <form method="POST" action="{{ route('cart.update', $item->id) }}">
                      @csrf
                      <input
                        type="number"
                        name="quantity"
                        value="{{ $item->quantity }}"
                        min="1"
                        max="{{ $item->product->quantity }}"
                        class="form-control w-50 d-inline"
                        onchange="this.form.submit()"
                      >
                    </form>
                    @if($item->quantity > $item->product->quantity)
                      <div class="text-danger small">
                        Only {{ $item->product->quantity }} in stock!
                      </div>
                    @endif
                  </td>
                  <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                  <td>
                    <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-danger">Remove</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          @php
            $total = $cart->items->sum(fn($i) => $i->product->price * $i->quantity);
            $insufficientStock = $cart->items->contains(fn($i) => $i->quantity > $i->product->quantity);
          @endphp

          <h4>Total: ${{ number_format($total, 2) }}</h4>

          <form action="{{ route('cart.checkout') }}" method="POST" class="mt-4">
            @csrf

            <!-- Delivery Location -->
            <div class="mb-3">
              <label for="location" class="form-label">Delivery Location</label>
              <input
                type="text"
                name="location"
                id="location"
                value="{{ old('location') }}"
                class="form-control @error('location') is-invalid @enderror"
                placeholder="Enter your address or share location"
                required
              >
              @error('location')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Hidden latitude/longitude fields -->
            <input type="hidden" name="lat" id="lat">
            <input type="hidden" name="lng" id="lng">

            <!-- Share My Location button -->
            <button
              type="button"
              class="btn btn-outline-secondary mb-3"
              onclick="getLocation()"
            >
              Share My Location
            </button>
            <div id="location-status" class="text-muted small mb-3"></div>

            <!-- Payment Method -->
            <div class="mb-3">
              <label for="payment_method" class="form-label">Payment Method</label>
              <select
                name="payment_method"
                id="payment_method"
                class="form-select @error('payment_method') is-invalid @enderror"
                required
              >
                <option value="">Choose...</option>
                <option value="card"          {{ old('payment_method')=='card'?'selected':'' }}>Credit Card</option>
                <option value="cash"          {{ old('payment_method')=='cash'?'selected':'' }}>Cash on Delivery</option>
                <option value="bank_transfer" {{ old('payment_method')=='bank_transfer'?'selected':'' }}>Bank Transfer</option>
              </select>
              @error('payment_method')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Card Details (hidden unless 'card' selected) -->
            <div id="card-details" class="border p-3 mb-3" style="display: none;">
              <h5>Card Details</h5>
              <div class="mb-3">
                <label for="card_number" class="form-label">Card Number</label>
                <input
                  type="text"
                  name="card_number"
                  id="card_number"
                  value="{{ old('card_number') }}"
                  class="form-control @error('card_number') is-invalid @enderror"
                  placeholder="1234 5678 9012 3456"
                >
                @error('card_number')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="row">
                <div class="col-sm-6 mb-3">
                  <label for="expiry_date" class="form-label">Expiry Date</label>
                  <input
                    type="month"
                    name="expiry_date"
                    id="expiry_date"
                    value="{{ old('expiry_date') }}"
                    class="form-control @error('expiry_date') is-invalid @enderror"
                  >
                  @error('expiry_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-sm-6 mb-3">
                  <label for="cvv" class="form-label">CVV</label>
                  <input
                    type="text"
                    name="cvv"
                    id="cvv"
                    value="{{ old('cvv') }}"
                    class="form-control @error('cvv') is-invalid @enderror"
                    placeholder="123"
                    maxlength="4"
                  >
                  @error('cvv')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <!-- Checkout Button -->
            <button
              type="submit"
              class="btn btn-primary"
              {{ $insufficientStock ? 'disabled' : '' }}
            >
              Checkout
            </button>

            @if($insufficientStock)
              <div class="text-danger small mt-2">
                Please adjust quantities to available stock.
              </div>
            @endif
          </form>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const paymentMethodSelect = document.getElementById('payment_method');
  const cardDetails = document.getElementById('card-details');

  function toggleCardDetails() {
    if (paymentMethodSelect.value === 'card') {
      cardDetails.style.display = 'block';
    } else {
      cardDetails.style.display = 'none';
    }
  }

  // Initialize visibility on load
  toggleCardDetails();

  // Listen for changes
  paymentMethodSelect.addEventListener('change', toggleCardDetails);

  // Existing location code
  window.getLocation = function() {
    const status = document.getElementById('location-status');
    status.textContent = '';

    if (!navigator.geolocation) {
      status.textContent = 'Geolocation not supported.';
      return;
    }
    status.textContent = 'Locating…';

    navigator.geolocation.getCurrentPosition(
      (pos) => {
        const lat = pos.coords.latitude;
        const lng = pos.coords.longitude;
        document.getElementById('lat').value = lat;
        document.getElementById('lng').value = lng;
        const locInput = document.getElementById('location');
        locInput.value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        status.textContent = 'Location shared!';
      },
      (err) => {
        console.error(err);
        status.textContent = 'Unable to retrieve location.';
      }
    );
  };
});
</script>


@endsection
