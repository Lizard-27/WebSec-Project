@extends('layouts.master')
@section('title', 'My Purchases')
@section('content')

<h1>My Purchase History</h1>

@if($products->isEmpty())
  <p>You haven’t bought anything yet.</p>
@else
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Price</th>
        <th>Purchased At</th>
      </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $product->name }}</td>
        <td>${{ number_format($product->price, 2) }}</td>
        <td>{{ $product->pivot->created_at->format('Y-m-d H:i') }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
@endif

@endsection
