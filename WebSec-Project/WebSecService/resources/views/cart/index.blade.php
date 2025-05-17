@extends('layouts.master')
@section('title','Your Cart')
@section('content')

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
        <td>${{ number_format($item->product->price,2) }}</td>
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
        <td>${{ number_format($item->product->price * $item->quantity,2) }}</td>
        <td>
          <form method="POST" action="{{ route('cart.remove', $item->id) }}">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Remove</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  @php
    $total = $cart->items->sum(fn($i)=> $i->product->price * $i->quantity);
    $insufficientStock = $cart->items->contains(fn($i)=> $i->quantity > $i->product->quantity);
  @endphp

  <h4>Total: ${{ number_format($total,2) }}</h4>

  <!-- Checkout form: collect location & payment method -->
  <form action="{{ route('cart.checkout') }}" method="POST" class="mt-4">
    @csrf

    <!-- Location -->
    <div class="mb-3">
      <label for="location" class="form-label">Delivery Location</label>
      <input
        type="text"
        name="location"
        id="location"
        value="{{ old('location') }}"
        class="form-control @error('location') is-invalid @enderror"
        required
      >
      @error('location')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

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
        <option value="card"            {{ old('payment_method')=='card'?'selected':'' }}>Credit Card</option>
        <option value="cash"            {{ old('payment_method')=='cash'?'selected':'' }}>Cash on Delivery</option>
        <option value="bank_transfer"   {{ old('payment_method')=='bank_transfer'?'selected':'' }}>Bank Transfer</option>
      </select>
      @error('payment_method')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <!-- Final Checkout Button -->
    <button
      type="submit"
      class="btn btn-primary"
      {{ $insufficientStock ? 'disabled' : '' }}
      {{ auth()->user()->credit < $total ? 'disabled' : '' }}
    >
      Checkout
    </button>

    @if(auth()->user()->credit < $total)
      <div class="text-danger small mt-2">
        Not enough credit to pay ${{ number_format($total,2) }}.
      </div>
    @endif
    @if($insufficientStock)
      <div class="text-danger small mt-2">
        Please adjust quantities to available stock.
      </div>
    @endif
  </form>
@endif

@endsection
