@extends('layouts.master')
@section('title', $product->name)
@section('content')

<div class="row mt-4">
  <div class="col-md-4">
    <img src="{{ asset("images/{$product->photo}") }}"
         class="img-fluid img-thumbnail" alt="{{ $product->name }}">
  </div>
  <div class="col-md-8">
    <h2>{{ $product->name }}</h2>
    <p><strong>Price:</strong> ${{ number_format($product->price,2) }}</p>
    <p><strong>In Stock:</strong> {{ $product->quantity }}</p>
    <p>{{ $product->description }}</p>

    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('products.purchase', $product->id) }}" method="POST">
      @csrf

      <div class="mb-3">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control"
               value="{{ old('location') }}" required>
        @error('location') <div class="text-danger">{{ $message }}</div> @enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Payment Method</label>
        <select name="payment_method" class="form-select" required>
          <option value="">Choose…</option>
          <option value="card"    {{ old('payment_method')=='card'?'selected':'' }}>Credit Card</option>
          <option value="cash"    {{ old('payment_method')=='cash'?'selected':'' }}>Cash on Delivery</option>
          <option value="bank_transfer" {{ old('payment_method')=='bank_transfer'?'selected':'' }}>Bank Transfer</option>
        </select>
        @error('payment_method') <div class="text-danger">{{ $message }}</div> @enderror
      </div>

      <button type="submit" class="btn btn-primary"
              @if($product->quantity===0) disabled @endif>
        Confirm Purchase — ${{ number_format($product->price,2) }}
      </button>
    </form>
  </div>
</div>

@endsection
