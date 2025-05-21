@extends('layouts.master')
@section('title','My Purchases')

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
    .purchases-container {
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
        .purchases-container {
            max-width: 98vw;
            padding: 16px 0 20px 0;
        }
    }
</style>

<div class="purchases-container">
    <div class="modern-card" style="padding:2.2rem 2rem;">
        <h1>My Purchases</h1>

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(!$orders || $orders->isEmpty())
          <p>You have no purchases yet.</p>
        @else
          <table class="table">
            <thead>
              <tr>
                <th>Qty</th>
                <th>Ordered</th>
                <th>Status</th>
                <th>Address</th>
                <th>Track</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders as $order)
                <tr>
                  <td>{{ $order->quantity }}</td>
                  <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                  <td>
                    @if(! $order->accepted)
                      Waiting
                    @elseif(! $order->delivery_confirmed)
                      En Route
                    @else
                      Delivered
                    @endif
                  </td>
                  <td>
                    {{ $order->location }}
                    <div id="map-{{ $order->id }}" style="height:120px; margin-top:8px; border-radius:0.7rem; box-shadow:0 2px 12px 0 rgba(220,20,60,0.10);"></div>
                  </td>
                  <td>
                    <button class="btn btn-outline-primary"
                            onclick="trackCustomer({{ $order->id }})">
                      👁️ Track My Order
                    </button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
    </div>
</div>

<script>
    // Initialize a nominatim geocoder once
    const geocoder = L.Control.Geocoder.nominatim();

    @foreach($orders as $order)
      (function(){
        const addr = {!! json_encode($order->location) !!};
        const map = L.map('map-{{ $order->id }}').setView([20,0],2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        geocoder.geocode(addr, (results) => {
          if (!results.length) return;
          map.setView(results[0].center, 13);
          L.marker(results[0].center)
           .addTo(map)
           .bindPopup(addr)
           .openPopup();
        });
      })();
    @endforeach

    function trackCustomer(id){
      document
        .getElementById('map-'+id)
        .scrollIntoView({ behavior:'smooth' });
    }
</script>

@endsection
