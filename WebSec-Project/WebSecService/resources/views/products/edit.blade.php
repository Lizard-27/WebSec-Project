@extends('layouts.master')
@section('title', 'Edit Product')
@section('content')
<style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        width: 100%;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background:
            linear-gradient(rgba(220,20,60,0.07), rgba(220,20,60,0.07)),
            url('https://ik.imagekit.io/jyx7871cz/2148132871-2.jpg') no-repeat center center fixed;
        background-size: cover;
        color: #222;
    }
    .edit-product-center {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }
    .edit-product-card {
        background: #fff;
        border-radius: 1.2rem;
        box-shadow: 0 8px 32px 0 rgba(220,20,60,0.10);
        padding: 2.5rem 2.2rem 2rem 2.2rem;
        width: 100%;
        max-width: 900px;
        color: #222;
        border: 1.5px solid #e5e7eb;
    }
    .edit-product-card h2 {
        text-align: center;
        font-size: 2.1rem;
        font-weight: 700;
        margin-bottom: 1.7rem;
        color: #dc143c;
        letter-spacing: 1px;
        text-shadow: 0 2px 8px rgba(220,20,60,0.08);
    }
    .form-label {
        font-size: 1rem;
        font-weight: 500;
        color: #dc143c;
        margin-bottom: 0.3rem;
    }
    .form-control {
        width: 100%;
        padding: 0.9rem 1.1rem;
        background: #fff;
        border: 1.5px solid #dc143c33;
        border-radius: 0.5rem;
        color: #222;
        font-size: 1.07rem;
        margin-bottom: 1.1rem;
        transition: border-color 0.3s, box-shadow 0.3s;
    }
    .form-control:focus {
        outline: none;
        border-color: #dc143c;
        box-shadow: 0 0 0 3px rgba(220,20,60,0.13);
    }
    textarea.form-control {
        min-height: 90px;
        resize: vertical;
    }
    .btn-primary {
        width: 100%;
        padding: 1rem;
        border: none;
        border-radius: 0.5rem;
        font-size: 1.09rem;
        font-weight: 600;
        background: linear-gradient(90deg, #dc143c 0%, #b11236 100%);
        color: #fff;
        box-shadow: 0 2px 12px 0 rgba(220,20,60,0.10);
        transition: background 0.2s;
        margin-top: 0.7rem;
        letter-spacing: 1px;
    }
    .btn-primary:hover {
        filter: brightness(1.08);
        background: linear-gradient(90deg, #b11236 0%, #dc143c 100%);
    }
    .alert-danger {
        background: rgba(220, 38, 38, 0.10);
        border: 1px solid #dc143c44;
        color: #dc143c;
        padding: 0.8rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.97rem;
        margin-bottom: 1.2rem;
    }
    @media (max-width: 900px) {
        .edit-product-card {
            max-width: 98vw;
            padding: 1.2rem 0.5rem 1rem 0.5rem;
        }
    }
</style>

<div class="edit-product-center">
    <div class="edit-product-card">
        <h2>Edit Product</h2>
        <form action="{{ route('products_save', $product->id) }}" method="post">
            @csrf

            @foreach($errors->all() as $error)
              <div class="alert alert-danger"><strong>Error!</strong> {{ $error }}</div>
            @endforeach

            <div class="row mb-2">
              <div class="col-md-6 col-12">
                <label class="form-label">Code:</label>
                <input type="text" name="code" class="form-control" required
                       value="{{ old('code', $product->code) }}">
              </div>
              <div class="col-md-6 col-12">
                <label class="form-label">Model:</label>
                <input type="text" name="model" class="form-control" required
                       value="{{ old('model', $product->model) }}">
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-md-6 col-12">
                <label class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" required
                       value="{{ old('name', $product->name) }}">
              </div>
              <div class="col-md-6 col-12">
                <label class="form-label">Price:</label>
                <input type="number" name="price" class="form-control" required step="0.01"
                       value="{{ old('price', $product->price) }}">
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-md-6 col-12">
                <label class="form-label">Photo:</label>
                <input type="text" name="photo" class="form-control" required
                       value="{{ old('photo', $product->photo) }}">
              </div>
              <div class="col-md-6 col-12">
                <label class="form-label">Quantity in Stock:</label>
                <input type="number" name="quantity" class="form-control" required min="0"
                       value="{{ old('quantity', $product->quantity) }}">
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-12">
                <label class="form-label">Description:</label>
                <textarea name="description" class="form-control" required>{{ old('description', $product->description) }}</textarea>
              </div>
            </div>

            <button type="submit" class="btn btn-primary">Save Product</button>
        </form>
    </div>
</div>
@endsection
