@extends('layouts.master')
@section('title', 'Welcome to Japanese Delights')

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Montserrat:wght@400;600&display=swap" />

<style>
  body {
    font-family: 'Noto Sans JP', 'Montserrat', sans-serif;
    background: linear-gradient(120deg, #18181b 0%, #232526 100%);
    color: #f4f4f5;
    margin: 0;
    padding: 0;
    min-height: 100vh;
    overflow-x: hidden;
  }

  .hero {
    background: linear-gradient(120deg, rgba(220,20,60,0.92) 0%, rgba(34,193,195,0.18) 100%), 
                url('https://ik.imagekit.io/jyx7871cz/2149013723(1).jpg?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
    background-size: cover;
    background-position: center;
    color: #fff;
    padding: 7rem 0 6rem 0;
    text-align: center;
    position: relative;
    margin-bottom: 3rem;
    width: 100vw;
    left: 50%;
    margin-left: -50vw;
    margin-right: 0;
    top: 0;
    box-sizing: border-box;
    overflow: hidden;
  }

  .hero-content {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 1rem;
    position: relative;
    z-index: 2;
    animation: fadeInDown 1.2s cubic-bezier(.77,0,.18,1) both;
  }

  .hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg, rgba(24,24,27,0.7) 0%, rgba(34,193,195,0.08) 100%);
    z-index: 1;
    pointer-events: none;
  }

  .hero h1 {
    font-size: 3.2rem;
    font-weight: 800;
    margin-bottom: 1.2rem;
    text-shadow: 0 4px 24px rgba(0,0,0,0.18);
    letter-spacing: 1px;
    animation: fadeInUp 1.2s 0.2s both;
  }

  .hero p {
    font-size: 1.25rem;
    margin-bottom: 2.5rem;
    font-weight: 400;
    color: #f4f4f5;
    opacity: 0.93;
    animation: fadeInUp 1.2s 0.4s both;
  }

  .btn-primary {
    background: linear-gradient(90deg, #dc143c 60%, #b11236 100%);
    color: #fff;
    border: none;
    padding: 1rem 2.5rem;
    border-radius: 50px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 1.15rem;
    transition: all 0.3s cubic-bezier(.77,0,.18,1);
    box-shadow: 0 4px 24px rgba(220,20,60,0.18);
    position: relative;
    overflow: hidden;
    animation: fadeInUp 1.2s 0.6s both;
  }
  .btn-primary:hover {
    background: linear-gradient(90deg, #b11236 0%, #dc143c 100%);
    color: #fff;
    transform: translateY(-2px) scale(1.04);
    box-shadow: 0 8px 32px rgba(220,20,60,0.22);
  }

  /* Scroll animation */
  .fade-in-up {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 0.8s cubic-bezier(.77,0,.18,1), transform 0.8s cubic-bezier(.77,0,.18,1);
  }
  .fade-in-up.visible {
    opacity: 1;
    transform: translateY(0);
  }

  .section-header {
    text-align: center;
    margin-bottom: 3rem;
    animation: fadeInUp 1.2s 0.2s both;
  }

  .section-header h2 {
    font-size: 2.2rem;
    color: #dc143c;
    position: relative;
    display: inline-block;
    padding-bottom: 0.5rem;
    font-weight: 700;
    letter-spacing: 1px;
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
    border-radius: 2px;
  }

  .section-header p {
    color: #a1a1aa;
    font-size: 1.1rem;
    margin-top: 0.5rem;
    font-weight: 400;
  }

  .card {
    border: none;
    border-radius: 1rem;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(.77,0,.18,1);
    box-shadow: 0 5px 24px rgba(34,193,195,0.08);
    margin-bottom: 2rem;
    height: 100%;
    background: #18181b;
    color: #f4f4f5;
    position: relative;
  }

  .card:hover {
    transform: translateY(-10px) scale(1.03);
    box-shadow: 0 15px 40px rgba(220, 20, 60, 0.18);
  }

  .card-img-top, .card-img {
    width: 250px;
    height: 250px;
    object-fit: cover;
    border-radius: 1rem 1rem 0 0;
    background: #222;
    margin-left: auto;
    margin-right: auto;
    display: block;
    transition: transform 0.4s cubic-bezier(.77,0,.18,1);
  }

  .card:hover .card-img-top, .card:hover .card-img {
    transform: scale(1.07) rotate(-2deg);
  }

  .card-body {
    padding: 1.5rem;
  }

  .card-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #dc143c;
    margin-bottom: 0.75rem;
  }

  .card-text {
    color: #a1a1aa;
    margin-bottom: 1.5rem;
    font-weight: 400;
  }

  .btn-outline-primary {
    color: #dc143c;
    border-color: #dc143c;
    border-radius: 50px;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(.77,0,.18,1);
    background: transparent;
  }

  .btn-outline-primary:hover {
    background-color: #dc143c;
    color: white;
    border-color: #dc143c;
    transform: scale(1.05);
  }

  .featured-section {
    padding: 4rem 0;
    background: linear-gradient(120deg, #18181b 0%, #232526 100%);
    width: 100vw;
    margin-left: -50vw;
    left: 50%;
    position: relative;
    color: #f4f4f5;
    overflow: hidden;
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

  /* Scroll indicator */
  .scroll-down {
    position: absolute;
    left: 50%;
    bottom: 2.5rem;
    transform: translateX(-50%);
    z-index: 10;
    animation: bounce 1.6s infinite;
    opacity: 0.85;
  }
  .scroll-down svg {
    width: 36px;
    height: 36px;
    fill: #fff;
    filter: drop-shadow(0 2px 8px rgba(220,20,60,0.18));
  }

  @keyframes bounce {
    0%, 100% { transform: translateX(-50%) translateY(0);}
    50% { transform: translateX(-50%) translateY(16px);}
  }

  @keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(40px);}
    100% { opacity: 1; transform: translateY(0);}
  }
  @keyframes fadeInDown {
    0% { opacity: 0; transform: translateY(-40px);}
    100% { opacity: 1; transform: translateY(0);}
  }

  @media (max-width: 1200px) {
    .featured-section {
      padding: 2rem 0;
    }
    .card-img-top, .card-img {
      width: 100%;
      height: 180px;
    }
  }

  @media (max-width: 768px) {
    .hero {
      padding: 3rem 0 2rem 0;
    }
    .hero h1 {
      font-size: 2rem;
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
    .scroll-down {
      bottom: 1rem;
    }
  }
</style>

<!-- Hero Section -->
<section class="hero">
  <div class="hero-content">
    <h1>Authentic Japanese Cuisine Delivered</h1>
    <p>Experience the art of Japanese cooking with our premium selection of sushi, ramen, and traditional dishes &mdash; delivered straight to your door.</p>
    <a href="{{ route('products_list') }}" class="btn btn-primary">Order Now</a>
  </div>
  <div class="scroll-down" id="scrollDown">
    <svg viewBox="0 0 24 24"><path d="M12 16.5c-.28 0-.53-.11-.71-.29l-6-6a1.003 1.003 0 011.42-1.42L12 13.59l5.29-5.3a1.003 1.003 0 011.42 1.42l-6 6c-.18.18-.43.29-.71.29z"/></svg>
  </div>
</section>

<!-- Featured Categories -->
<div class="container-fluid fade-in-up">
  <div class="section-header">
    <h2>Our Specialties</h2>
    <p>Discover the authentic taste of Japan</p>
  </div>
  <div class="row">
    @foreach($products as $product)
      <div class="col-md-4 mb-4">
        <div class="card position-relative fade-in-up">
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
<section class="featured-section fade-in-up">
  <div class="container-fluid">
    <div class="section-header">
      <h2>Why Choose Us</h2>
      <p>Traditional quality meets modern convenience</p>
    </div>

    <div class="row text-center">
      <div class="col-md-4 mb-4 fade-in-up">
        <div class="p-4">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#dc143c" viewBox="0 0 24 24" class="mb-3">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
          </svg>
          <h4>Authentic Taste</h4>
          <p>Recipes passed down through generations of Japanese chefs</p>
        </div>
      </div>

      <div class="col-md-4 mb-4 fade-in-up">
        <div class="p-4">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#dc143c" viewBox="0 0 24 24" class="mb-3">
            <path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm5-3v8h2.5v8H21V2c-2.76 0-5 2.24-5 4z"/>
          </svg>
          <h4>Fresh Ingredients</h4>
          <p>Daily delivery of the freshest seafood and produce</p>
        </div>
      </div>

      <div class="col-md-4 mb-4 fade-in-up">
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

<footer style="width:100vw; background:#18181b; color:#fff; text-align:center; padding:2rem 0; margin-left:-50vw; left:50%; position:relative; font-family:'Montserrat',sans-serif; font-size:1rem; border-top:1px solid #232526;">
    <div>
        &copy; {{ date('Y') }} Japanese Delights &mdash; Authentic Taste Delivered
    </div>
    <div style="margin-top:0.5rem; font-size:0.95em;">
        <a href="{{ url('/') }}" style="color:#dc143c; text-decoration:underline; margin:0 0.5em;">Home</a>
        <a href="{{ route('products_list') }}" style="color:#dc143c; text-decoration:underline; margin:0 0.5em;">Products</a>
        <a href="{{ url('/contact') }}" style="color:#dc143c; text-decoration:underline; margin:0 0.5em;">Contact</a>
    </div>
</footer>

<script>
  // Scroll effect for fade-in-up elements
  function revealOnScroll() {
    const elements = document.querySelectorAll('.fade-in-up');
    const windowHeight = window.innerHeight;
    elements.forEach(el => {
      const rect = el.getBoundingClientRect();
      if (rect.top < windowHeight - 60) {
        el.classList.add('visible');
      }
    });
  }
  window.addEventListener('scroll', revealOnScroll);
  window.addEventListener('DOMContentLoaded', () => {
    revealOnScroll();
    // Scroll down arrow
    document.getElementById('scrollDown').addEventListener('click', function() {
      const nextSection = document.querySelector('.container-fluid');
      if(nextSection) {
        nextSection.scrollIntoView({ behavior: 'smooth' });
      }
    });
  });
</script>
@endsection