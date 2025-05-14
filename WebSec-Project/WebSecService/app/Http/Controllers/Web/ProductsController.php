<?php

namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductsController extends Controller
{
    use ValidatesRequests;

    public function __construct()
    {
        // Require authentication for everything except viewing the product list
        $this->middleware('auth:web')->except('list');
    }

    /**
     * Show the product catalog with optional filters.
     */
    public function list(Request $request)
    {
        $query = Product::query();

        $query->when($request->keywords,
            fn($q) => $q->where('name', 'like', "%{$request->keywords}%")
        );

        $query->when($request->min_price,
            fn($q) => $q->where('price', '>=', $request->min_price)
        );

        $query->when($request->max_price,
            fn($q) => $q->where('price', '<=', $request->max_price)
        );

        $query->when($request->order_by,
            fn($q) => $q->orderBy($request->order_by, $request->order_direction ?? 'ASC')
        );

        $products = $query->get();

        return view('products.list', compact('products'));
    }

    /**
     * Display the product details & purchase form.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Handle the purchase submission:
     * - Validate location & payment_method
     * - Check credit & stock
     * - Deduct stock & credit
     * - Attach purchase to pivot with extra data
     */
    public function purchase(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $user    = auth()->user();

        $data = $request->validate([
            'location'       => ['required', 'string', 'max:255'],
            'payment_method' => ['required', 'in:card,cash,bank_transfer'],
        ]);

        if ($user->credit < $product->price) {
            return back()->with('error', 'Not enough credit.');
        }

        if ($product->quantity <= 0) {
            return back()->with('error', 'This product is out of stock.');
        }

        // Deduct one unit from stock
        $product->decrement('quantity');

        // Deduct cost from user credit
        $user->decrement('credit', $product->price);

        // Record the purchase in the pivot table, including location & payment
        $user->purchases()->attach($product->id, [
            'location'       => $data['location'],
            'payment_method' => $data['payment_method'],
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return redirect()
            ->route('my_purchases')
            ->with('success', 'Purchase complete!');
    }

    /**
     * Show the logged-in user’s purchase history.
     */
    public function myProducts()
    {
        $products = auth()->user()->purchases()->get();
        return view('products.purchases', compact('products'));
    }

    /**
     * Show the product create/edit form.
     */
    public function edit(Request $request, Product $product = null)
    {
        if (! auth()->user()) {
            return redirect('/');
        }

        $product = $product ?? new Product();
        return view('products.edit', compact('product'));
    }

    /**
     * Save a new or existing product.
     */
    public function save(Request $request, Product $product = null)
    {
        $this->validate($request, [
            'code'        => ['required', 'string', 'max:32'],
            'name'        => ['required', 'string', 'max:128'],
            'model'       => ['required', 'string', 'max:256'],
            'description' => ['required', 'string', 'max:1024'],
            'quantity'    => ['required', 'numeric', 'min:0'],
            'price'       => ['required', 'numeric', 'min:0'],
        ]);

        $product = $product ?? new Product();
        $product->fill($request->all());
        $product->save();

        return redirect()->route('products_list');
    }

    /**
     * Delete a product (requires delete_products permission).
     */
    public function delete(Request $request, Product $product)
    {
        $user = auth()->user();

        if (! $user || ! $user->hasPermissionTo('delete_products')) {
            abort(403);
        }

        $product->delete();
        return redirect()->route('products_list');
    }
}
