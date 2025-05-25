@extends('layouts.master')
@section('title','My Purchases')

@push('head')
  <!-- Leaflet CSS -->
  <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
  />
  <!-- Geocoder CSS -->
  <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css"
  />

  <style>
    body {
      min-height: 100vh;
      background:
        linear-gradient(rgba(220,20,60,0.07), rgba(220,20,60,0.07)),
        url('https://ik.imagekit.io/jyx7871cz/2148633547.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #222;
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      margin: 0;
    }
    .purchases-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 32px 0 40px;
    }
    .modern-card {
      background: #fff;
      border: 1.5px solid #dc143c33;
      border-radius: 1.1rem;
      box-shadow: 0 6px 24px rgba(220,20,60,0.10);
      margin-bottom: 1.3rem;
      transition: box-shadow 0.2s;
    }
    .modern-card:hover {
      box-shadow: 0 10px 32px rgba(220,20,60,0.18);
    }
    .modern-card .card-body {
      padding: 2.2rem 2rem;
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
    .table {
      width: 100%;
    }
    @media (max-width: 800px) {
      .purchases-container {
        max-width: 98vw;
        padding: 16px 0 20px;
      }
    }
  </style>
@endpush

@section('content')
  <div class="purchases-container">
    <div class="modern-card">
      <div class="card-body">
        <h1>My Purchases</h1>

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($orders->isEmpty())
          <p>You have no purchases yet.</p>
        @else
          <table class="table">
            <thead>
              <tr>
                <th>Qty</th>
                <th>Ordered</th>
                <th>Status</th>
                <th>Address &amp; Map</th>
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
                    <div
                      id="map-{{ $order->id }}"
                      class="map-container"
                      style="height:120px; margin-top:8px; border-radius:0.7rem; box-shadow:0 2px 12px rgba(220,20,60,0.10);"
                    ></div>
                  </td>
                  <td>
                    <button
                      class="btn btn-outline-primary"
                      onclick="trackCustomer({{ $order->id }})"
                    >
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
  </div>
@endsection

@push('scripts')
  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <!-- Geocoder JS -->
  <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // one shared geocoder instance
      const geocoder = L.Control.Geocoder.nominatim();

      // initialize each map
      @foreach($orders as $order)
        (function(){
          const addr = {!! json_encode($order->location) !!};
          const mapEl = document.getElementById('map-{{ $order->id }}');
          if (!mapEl) return;

          const map = L.map(mapEl).setView([20,0], 2);
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png')
            .addTo(map);

          geocoder.geocode(addr, (results) => {
            if (results && results.length) {
              const { center } = results[0];
              map.setView(center, 13);
              L.marker(center)
                .addTo(map)
                .bindPopup(addr)
                .openPopup();
            }
          });
        })();
      @endforeach
    });

    function trackCustomer(id) {
      const el = document.getElementById('map-' + id);
      if (el) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    }
  </script>
@endpush
