<?php


namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;

class WelcomeController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::take(6)->get(); // or whatever you want to show
        return view('welcome', compact('products'));
    }
}