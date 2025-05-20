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
        max-width: 700px;
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
    .modern-card .card-body {
        padding: 1.1rem 1.3rem 1.1rem 1.3rem;
    }
    .modern-card strong {
        color: #dc143c;
        font-weight: 600;
        font-size: 1.13rem;
        letter-spacing: 0.2px;
    }
    .modern-card p {
        margin-bottom: 0.6rem;
        font-size: 1.13rem;
        line-height: 1.6;
        color: #222;
        letter-spacing: 0.1px;
    }
    .modern-card .btn {
        background: linear-gradient(90deg, #dc143c 0%, #b11236 100%);
        color: #fff;
        border: none;
        border-radius: 2rem;
        font-weight: bold;
        font-size: 1.09rem;
        padding: 0.7rem 1.3rem;
        letter-spacing: 1px;
        margin-top: 0.7rem;
        box-shadow: 0 2px 12px 0 rgba(220,20,60,0.10);
        transition: none;
    }
    .modern-card .btn:active {
        filter: brightness(0.95);
    }
    .modern-card .btn-outline-primary {
        background: transparent;
        color: #dc143c;
        border: 1.5px solid #dc143c;
        border-radius: 2rem;
        font-weight: 600;
        transition: none;
    }
    .modern-card .btn-outline-primary:active,
    .modern-card .btn-outline-primary:hover {
        background: #dc143c;
        color: #fff;
    }
    .modern-card .leaflet-container {
        border-radius: 0.7rem;
        box-shadow: 0 2px 12px 0 rgba(220,20,60,0.10);
        margin-bottom: 0.5rem;
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
        .modern-card .card-body {
            padding: 1rem 0.5rem 1rem 0.5rem;
        }
        .modern-card p {
            font-size: 1.05rem;
        }
    }
</style>

<div class="purchases-container">
  <h1>My Purchases</h1>

  @foreach($orders as $order)
    <div class="card modern-card">
      <div class="card-body">

        <p>
          <strong>Qty:</strong> {{ $order->quantity }}<br>
          <strong>Ordered:</strong> {{ $order->created_at->format('Y-m-d H:i') }}<br>
          <strong>Status:</strong>
            @if(! $order->accepted) Waiting<br>
            @elseif(! $order->delivery_confirmed) En Route<br>
            @else Delivered<br>
            @endif
        </p>
        <p><strong>Address:</strong> {{ $order->location }}</p>

        <div id="map-{{ $order->id }}" style="height:180px;"></div>

        <button class="btn btn-outline-primary"
                onclick="trackCustomer({{ $order->id }})">
          👁️ Track My Order
        </button>
      </div>
    </div>
  @endforeach
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
