<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::take(6)->get(); // Adjust number as needed
        return view('welcome', compact('products'));
    }
}