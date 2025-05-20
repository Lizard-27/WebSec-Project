@extends('layouts.master')
@section('title', 'Welcome to Japanese Delights')

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Montserrat:wght@400;600&display=swap" />

<style>
  body {
    font-family: 'Noto Sans JP', 'Montserrat', sans-serif;
    background-color: #fff;
    color: #333;
    line-height: 1.6;
    margin: 0;
    padding: 0;
  }

  .container, .container-fluid {
    width: 100vw !important;
    max-width: 100vw !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
  }

  .row {
    margin-left: 0 !important;
    margin-right: 0 !important;
  }

  .col-md-4, .col-md-6, .col-md-5, .col-md-7, .col-12, .col-md-3, .col-md-8, .col-md-9, .col-md-2 {
    padding-left: 0.5rem !important;
    padding-right: 0.5rem !important;
  }

  .hero {
    background: linear-gradient(rgba(220, 20, 60, 0.85), rgba(220, 20, 60, 0.85)), 
                url('https://ik.imagekit.io/jyx7871cz/2149013723(1).jpg?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
    background-size: cover;
    background-position: center;
    color: white;
    padding: 6rem 0;
    text-align: center;
    position: relative;
    margin-bottom: 3rem;
    width: 100vw;
    left: 0;
    margin-left: 0;
    margin-right: 0;
    top: 0;
    box-sizing: border-box;
  }

  .hero-content {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 1rem;
  }

  .hero h1 {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
  }

  .hero p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    font-weight: 300;
  }

  .btn-primary {
    background-color: white;
    color: #dc143c;
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,
  }

  .btn-primary:hover {
    background-color: #f8f8f8;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
  }

  .section-header {
    text-align: center;
    margin-bottom: 3rem;
  }

  .section-header h2 {
    font-size: 2.2rem;
    color: #b11236;
    position: relative;
    display: inline-block;
    padding-bottom: 0.5rem;
  }

  .section-header h2:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background-color: #dc143c;
  }

  .card {
    border: none;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    margin-bottom: 2rem;
    height: 100%;
  }

  .card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(220, 20, 60, 0.15);
  }

  .card-img-top, .card-img {
  width: 250px;
  height: 250px;
  object-fit: cover;
  border-radius: 8px 8px 0 0;
  background: #fff0f3;
  margin-left: auto;
  margin-right: auto;
  display: block;
}

  .card:hover .card-img-top, .card:hover .card-img {
    transform: scale(1.05);
  }

  .card-body {
    padding: 1.5rem;
  }

  .card-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #b11236;
    margin-bottom: 0.75rem;
  }

  .card-text {
    color: #666;
    margin-bottom: 1.5rem;
  }

  .btn-outline-primary {
    color: #dc143c;
    border-color: #dc143c;
    border-radius: 50px;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
  }

  .btn-outline-primary:hover {
    background-color: #dc143c;
    color: white;
  }

  .featured-section {
    padding: 4rem 0;
    background-color: #f9f9f9;
    width: 100vw;
    margin-left: -50vw;
    left: 50%;
    position: relative;
  }

  .special-badge, .badge-danger {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #dc143c;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    z-index: 2;
  }

  .badge-danger {
    position: static;
    margin-bottom: 0.5rem;
    background-color: #dc143c !important;
  }



  @media (max-width: 1200px) {
    .container, .container-fluid {
      max-width: 100vw !important;
      padding-left: 0 !important;
      padding-right: 0 !important;
    }
    .featured-section {
      padding: 2rem 0;
    }
  }

  @media (max-width: 768px) {
    .hero {
      padding: 3rem 0;
    }
    .hero h1 {
      font-size: 2.2rem;
    }
    .section-header h2 {
      font-size: 1.3rem;
    }
    .card-img-top, .card-img {
      height: 140px;
    }
    .card-body {
      padding: 1rem;
    }
    .featured-section {
      padding: 1.5rem 0;
    }
  }
</style>

<!-- Hero Section -->
<section class="hero">
  <div class="hero-content">
    <h1>Authentic Japanese Cuisine Delivered</h1>
    <p>Experience the art of Japanese cooking with our premium selection of sushi, ramen, and traditional dishes - delivered straight to your door.</p>
    <a href="{{ route('products_list') }}" class="btn btn-primary">Order Now</a>
  </div>
</section>

<!-- Featured Categories -->
<div class="container-fluid">
  <div class="section-header">
    <h2>Our Specialties</h2>
    <p>Discover the authentic taste of Japan</p>
  </div>
  <div class="row">
    @foreach($products as $product)
      <div class="col-md-4 mb-4">
        <div class="card position-relative">
          <img 
            src="{{ Str::startsWith($product->photo, ['http://', 'https://']) ? $product->photo : asset('images/' . $product->photo) }}" 
            class="card-img-top" 
            alt="{{ $product->name }}">
          <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text">{{ $product->description }}</p>
            <p class="card-text"><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
            <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary">View Details</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

<!-- Featured Section -->
<section class="featured-section">
  <div class="container-fluid">
    <div class="section-header">
      <h2>Why Choose Us</h2>
      <p>Traditional quality meets modern convenience</p>
    </div>

    <div class="row text-center">
      <div class="col-md-4 mb-4">
        <div class="p-4">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#dc143c" viewBox="0 0 24 24" class="mb-3">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
          </svg>
          <h4>Authentic Taste</h4>
          <p>Recipes passed down through generations of Japanese chefs</p>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="p-4">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#dc143c" viewBox="0 0 24 24" class="mb-3">
            <path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z"/>
          </svg>
          <h4>Fresh Ingredients</h4>
          <p>Daily delivery of the freshest seafood and produce</p>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="p-4">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#dc143c" viewBox="0 0 24 24" class="mb-3">
            <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
          </svg>
          <h4>Easy Ordering</h4>
          <p>Simple online ordering with fast delivery</p>
        </div>
      </div>
    </div>
  </div>
</section>

<footer style="width:100vw; background:#dc143c; color:#fff; text-align:center; padding:2rem 0; margin-left:-50vw; left:50%; position:relative; font-family:'Montserrat',sans-serif; font-size:1rem;">
    <div>
        &copy; {{ date('Y') }} Japanese Delights &mdash; Authentic Taste Delivered
    </div>
    <div style="margin-top:0.5rem; font-size:0.95em;">
        <a href="{{ url('/') }}" style="color:#fff; text-decoration:underline; margin:0 0.5em;">Home</a>
        <a href="{{ route('products_list') }}" style="color:#fff; text-decoration:underline; margin:0 0.5em;">Products</a>
        <a href="{{ url('/contact') }}" style="color:#fff; text-decoration:underline; margin:0 0.5em;">Contact</a>
    </div>
</footer>
@endsection