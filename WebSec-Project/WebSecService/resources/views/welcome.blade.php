@extends('layouts.master')
@section('title', 'Welcome')

@section('content')
{{-- Add a custom Google font --}}
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" />

<style>
  /* Body font */
  body {
    font-family: 'Montserrat', sans-serif;
  }

  /* Page header section with a gradient background */
  .page-header {
    padding: 4rem 0;
    background: linear-gradient(135deg, #fe5900 0%, #f06d06 100%);
    color: #fff;
    text-align: center;
    margin-bottom: 2rem;
  }
  
  .page-header h2 {
    font-weight: 600;
    margin-bottom: 0;
  }
  
  /* Card styling */
  .card {
    border: none;
    border-radius: 0.75rem;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  
  /* Subtle hover effect */
  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
  }
  
  /* Card image with rounded top corners */
  .card-img-top {
    border-top-left-radius: 0.75rem;
    border-top-right-radius: 0.75rem;
  }

  /* Card body with your orange background color */
  .card-body {
    background-color: #fe5900;
    border-bottom-left-radius: 0.75rem;
    border-bottom-right-radius: 0.75rem;
    color: #fff;
    padding: 1.5rem;
  }
  
  .card-title {
    margin-bottom: 0.5rem;
    font-weight: 600;
  }
  
  .btn-dark {
    border-radius: 2rem;
    font-weight: 600;
    padding: 0.5rem 1.5rem;
    transition: background-color 0.3s ease, color 0.3s ease;
  }
  
  .btn-dark:hover {
    background-color: #343a40cc;
    color: #ffffff;
  }
</style>

<div class="page-header">
  <h2>Welcome to Our Services</h2>
  <p style="margin-top: 0.5rem;">Find everything you need, delivered fast!</p>
</div>

<div class="container">
    <!-- Row of cards (3 per row on MD+, 1 column on XS) -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <!-- Card 1: Order food -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <!-- Replace this image path with your actual image asset -->
                <img src="{{ asset('images/food.jpg') }}" class="card-img-top" alt="Order Food">
                <div class="card-body">
                    <h5 class="card-title">Order Food</h5>
                    <p class="card-text">
                        Find deals, free delivery, and more from our restaurant partners.
                    </p>
                    <a href="#" class="btn btn-dark">Order now</a>
                </div>
            </div>
        </div>

        <!-- Card 2: Order groceries -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/pasta.jpg') }}" class="card-img-top" alt="Order Groceries">
                <div class="card-body">
                    <h5 class="card-title">Order Groceries</h5>
                    <p class="card-text">
                        Don’t stand in line. Order from top stores delivering groceries to you.
                    </p>
                    <a href="#" class="btn btn-dark">Shop now</a>
                </div>
            </div>
        </div>

        <!-- Card 3: Order flowers -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/OIP.jpg') }}" class="card-img-top" alt="Order Flowers">
                <div class="card-body">
                    <h5 class="card-title">Order Flowers</h5>
                    <p class="card-text">
                        Whatever the occasion, say it with flowers. We deliver to your loved ones.
                    </p>
                    <a href="#" class="btn btn-dark">Shop now</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Another row of 3 cards, if you'd like more options -->
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
        <!-- Card 4: Order medicine -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/food.jpg') }}" class="card-img-top" alt="Order Medicine">
                <div class="card-body">
                    <h5 class="card-title">Order Medicine</h5>
                    <p class="card-text">
                        Stay healthy without leaving home. Order your medicine online.
                    </p>
                    <a href="#" class="btn btn-dark">Order now</a>
                </div>
            </div>
        </div>

        <!-- Card 5: Donations -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/food.jpg') }}" class="card-img-top" alt="Donations">
                <div class="card-body">
                    <h5 class="card-title">Donations</h5>
                    <p class="card-text">
                        Make a difference by donating to those in need.
                    </p>
                    <a href="#" class="btn btn-dark">Donate now</a>
                </div>
            </div>
        </div>

        <!-- Card 6: Other services (example) -->
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/food.jpg') }}" class="card-img-top" alt="More Services">
                <div class="card-body">
                    <h5 class="card-title">More Services</h5>
                    <p class="card-text">
                        Browse through our full range of offerings to find exactly what you need!
                    </p>
                    <a href="#" class="btn btn-dark">Explore now</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
