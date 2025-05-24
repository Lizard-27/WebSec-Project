@extends('layouts.master')
@section('title','Delivery Dashboard')
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
    .delivery-container {
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
    .table th, .table td {
        vertical-align: middle !important;
    }
    .btn-primary, .btn-success {
        background: #dc143c;
        border: none;
        font-weight: bold;
        border-radius: 0.5rem;
        transition: background 0.2s;
    }
    .btn-primary:hover, .btn-success:hover {
        background: #b11236;
    }
    .btn-outline-secondary {
        border-radius: 0.5rem;
    }
    .badge.bg-success {
        background: #22c55e !important;
        color: #fff;
        font-size: 0.95em;
        padding: 0.5em 1em;
        border-radius: 0.5em;
    }
    .alert-success {
        background: rgba(34,197,94,0.15);
        color: #4ade80;
        padding: 0.8rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        border: none;
    }
    @media (max-width: 800px) {
        .delivery-container {
            max-width: 98vw;
            padding: 16px 0 20px 0;
        }
        .modern-card {
            padding: 1rem !important;
        }
        .table-responsive {
            overflow-x: auto;
        }
    }
</style>

<div class="delivery-container">
    <div class="modern-card" style="padding:2.2rem 2rem;">
        <h1>Pending Deliveries</h1>

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($orders->isEmpty())
          <p>No orders awaiting delivery.</p>
        @else
          <div class="table-responsive">
            <table class="table align-middle">
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
          </div>
        @endif
    </div>
</div>

@endsection
