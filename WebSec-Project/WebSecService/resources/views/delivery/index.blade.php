@extends('layouts.master')
@section('title','Delivery Dashboard')
@section('content')

<h1>Pending Deliveries</h1>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($orders->isEmpty())
  <p>No orders awaiting delivery.</p>
@else
  <table class="table">
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Customer</th>
        <th>Location</th>
        <th>Placed At</th>
        <th>Total</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($orders as $o)
        <tr>
          <td>{{ $o->id }}</td>
          <td>{{ $o->customer_name }}</td>
          <td>{{ $o->location }}</td>
          <td>{{ \Carbon\Carbon::parse($o->created_at)->format('Y-m-d H:i') }}</td>
          <td>${{ number_format($o->total, 2) }}</td>
          <td>
            @if(! $o->accepted)
              {{-- Not yet accepted: show “Accept” --}}
              <form action="{{ route('delivery.accept', $o->id) }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-sm btn-primary">Accept</button>
              </form>
            @elseif(! $o->delivery_confirmed)
              {{-- Accepted but not delivered: show “Confirm Delivered” --}}
              <form action="{{ route('delivery.confirm', $o->id) }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-sm btn-success">Confirm Delivered</button>
              </form>
            @else
              {{-- Already delivered --}}
              <span class="badge bg-success">Delivered</span>
            @endif

            {{-- Always offer “View Details” --}}
            <a href="{{ route('delivery.show', $o->id) }}" class="btn btn-sm btn-outline-secondary ms-1">
              Details
            </a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endif

@endsection
