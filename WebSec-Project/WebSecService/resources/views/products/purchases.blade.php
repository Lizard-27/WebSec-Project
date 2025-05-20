@extends('layouts.master')
@section('title','My Purchases')
@section('content')
  <h1>My Purchases</h1>

  @foreach($orders as $order)
    <div class="card mb-4">
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

        {{-- Map placeholder --}}
        <div id="map-{{ $order->id }}" style="height:200px;"></div>

        <button class="btn btn-outline-primary mt-2"
                onclick="trackCustomer({{ $order->id }})">
          👁️ Track My Order
        </button>
      </div>
    </div>
  @endforeach

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
