@extends('layouts.master')
@section('title', 'Edit Product')
@section('content')

<form action="{{ route('products_save', $product->id) }}" method="post">
    @csrf

    @foreach($errors->all() as $error)
      <div class="alert alert-danger"><strong>Error!</strong> {{ $error }}</div>
    @endforeach

    <div class="row mb-2">
      <div class="col-6">
        <label class="form-label">Code:</label>
        <input type="text" name="code" class="form-control" required
               value="{{ old('code', $product->code) }}">
      </div>
      <div class="col-6">
        <label class="form-label">Model:</label>
        <input type="text" name="model" class="form-control" required
               value="{{ old('model', $product->model) }}">
      </div>
    </div>

    <div class="row mb-2">
      <div class="col-6">
        <label class="form-label">Name:</label>
        <input type="text" name="name" class="form-control" required
               value="{{ old('name', $product->name) }}">
      </div>
      <div class="col-6">
        <label class="form-label">Price:</label>
        <input type="number" name="price" class="form-control" required step="0.01"
               value="{{ old('price', $product->price) }}">
      </div>
    </div>

    <div class="row mb-2">
      <div class="col-6">
        <label class="form-label">Photo:</label>
        <input type="text" name="photo" class="form-control" required
               value="{{ old('photo', $product->photo) }}">
      </div>
      <div class="col-6">
        <label class="form-label">Quantity in Stock:</label>
        <input type="number" name="quantity" class="form-control" required min="0"
               value="{{ old('quantity', $product->quantity) }}">
      </div>
    </div>

    <div class="row mb-2">
      <div class="col">
        <label class="form-label">Description:</label>
        <textarea name="description" class="form-control" required>{{ old('description', $product->description) }}</textarea>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Save Product</button>
</form>

@endsection
