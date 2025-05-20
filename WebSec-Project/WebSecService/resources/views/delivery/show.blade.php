{{-- resources/views/delivery/show.blade.php --}}

@extends('layouts.master')
@section('title','Order Details')
@section('content')

  <h1>Order #{{ $order->id }} Details</h1>

  <p>
    <strong>Customer:</strong>
    {{ $order->customer_name }}
    &lt;{{ $order->customer_email }}&gt;
  </p>

  <p>
    <strong>Address:</strong>
    {{ $order->location }}
  </p>

  <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
  <p><strong>Total:</strong> ${{ number_format($order->total,2) }}</p>
  <p><strong>Placed At:</strong>
    {{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d H:i') }}
  </p>

  <hr>

  <h4>Items</h4>
  <ul>
    @foreach($items as $item)
      <li>
        {{ $item->product_name }}
        &times; {{ $item->quantity }}
        (unit price: ${{ number_format($item->price,2) }})
      </li>
    @endforeach
  </ul>

  <hr>

  {{-- Map & share controls (leaflet + geolocation) --}}
  <div id="map" style="height:400px; margin-bottom:1rem;"></div>
  <button id="share-pos" class="btn btn-outline-primary mb-3">
    Share My Location
  </button>

  @if($order->accepted && ! $order->delivery_confirmed)
    <form action="{{ route('delivery.confirm', $order->id) }}" method="POST">
      @csrf
      <button class="btn btn-success">Confirm Delivered</button>
    </form>
  @endif

  @push('scripts')
  <script>
    // initialize map
    const map = L.map('map').setView([20,0],2);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
      attribution:'&copy; OpenStreetMap contributors'
    }).addTo(map);

    // geocode the delivery address
    L.Control.Geocoder.nominatim().geocode(
      "{{ addslashes($order->location) }}",
      results => {
        if (!results.length) return;
        const { center, name } = results[0];
        map.setView(center,14);
        L.marker(center)
         .addTo(map)
         .bindPopup(name)
         .openPopup();
      }
    );

    // share driver’s live GPS location
    document.getElementById('share-pos').onclick = () => {
      navigator.geolocation.getCurrentPosition(
        pos => {
          const c = [ pos.coords.latitude, pos.coords.longitude ];
          L.marker(c)
           .addTo(map)
           .bindPopup('You are here')
           .openPopup();
          map.setView(c,14);
        },
        err => alert('Error: '+err.message)
      );
    };
  </script>
  @endpush

@endsection
