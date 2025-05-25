{{-- resources/views/delivery/show.blade.php --}}

@extends('layouts.master')
@section('title','Order Details')
@section('content')

@push('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
@endpush

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
        padding: 2.2rem 2rem;
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
    .btn-outline-primary {
        border-radius: 0.5rem;
        color: #dc143c;
        border-color: #dc143c;
    }
    .btn-outline-primary:hover {
        background: #dc143c;
        color: #fff;
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
    }
</style>

<div class="delivery-container">
  <div class="modern-card">
    <h1>Order #{{ $order->id }} Details</h1>

    <p><strong>Customer:</strong> {{ $order->customer_name }} &lt;{{ $order->customer_email }}&gt;</p>
    <p><strong>Address:</strong> {{ $order->location }}</p>
    <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
    <p><strong>Total:</strong> ${{ number_format($order->total,2) }}</p>
    <p><strong>Placed At:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d H:i') }}</p>

    <hr>

    <h4>Items</h4>
    <ul>
      @foreach($items as $item)
        <li>{{ $item->product_name }} &times; {{ $item->quantity }} (unit price: ${{ number_format($item->price,2) }})</li>
      @endforeach
    </ul>

    <hr>

    <div id="map" style="height:400px; margin-bottom:1rem;"></div>
    <button id="share-pos" class="btn btn-outline-primary mb-3">Share My Location</button>

    @if($order->accepted && ! $order->delivery_confirmed)
      <form action="{{ route('delivery.confirm', $order->id) }}" method="POST">
        @csrf
        <input type="hidden" name="courier_location" id="courier_location">
        <button class="btn btn-success">Confirm Delivered</button>
      </form>
    @endif
  </div>
</div>

@push('scripts')
<script>
  const map = L.map('map').setView([20, 0], 2);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution:'&copy; OpenStreetMap contributors'
  }).addTo(map);

  L.Control.Geocoder.nominatim().geocode(
    "{{ addslashes($order->location) }}",
    results => {
      if (!results.length) {
        alert('Could not find this address on the map.');
        return;
      }
      const { center, name } = results[0];
      map.setView(center, 14);
      L.marker(center)
        .addTo(map)
        .bindPopup(name)
        .openPopup();
    },
    err => {
      console.error('Geocoding error:', err);
    }
  );

  document.getElementById('share-pos').onclick = () => {
    if (!navigator.geolocation) {
      return alert('Geolocation not supported.');
    }

    navigator.geolocation.getCurrentPosition(
      pos => {
        const lat = pos.coords.latitude;
        const lng = pos.coords.longitude;
        const marker = [lat, lng];
        L.marker(marker)
          .addTo(map)
          .bindPopup('You are here')
          .openPopup();
        map.setView(marker, 14);
        document.getElementById('courier_location').value = `${lat},${lng}`;
      },
      err => alert('Error getting location: ' + err.message),
      { enableHighAccuracy: true, timeout: 10000 }
    );
  };
</script>
@endpush

@endsection
