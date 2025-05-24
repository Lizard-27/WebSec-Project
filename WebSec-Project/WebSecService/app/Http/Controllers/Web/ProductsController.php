<?php

namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class ProductsController extends Controller
{
    use ValidatesRequests;

    public function __construct()
    {
        // Guests can browse; everything else requires login
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
    public function show(Product $product)
    {
        $avg = round($product->averageRating(), 1); // e.g. 4.2
        $userRating = auth()->check()
            ? $product->ratings()->where('user_id', auth()->id())->value('rating')
            : null;

        return view('products.show', compact('product', 'avg', 'userRating'));
    }

    // Store or update the authenticated user's rating for this product
    public function rate(Request $request, Product $product)
    {
        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Rating::updateOrCreate(
            [
                'user_id'    => auth()->id(),
                'product_id' => $product->id,
            ],
            ['rating'     => $data['rating']]
        );

        return back()->with('success', 'Thank you for rating!');
    }

    /**
     * Handle the purchase submission:
     *   1) Validate location & payment_method
     *   2) Check stock
     *   3) Create one Order
     *   4) Create each OrderItem
     *   5) Deduct stock, clear cart (if you still use cart)
     */
    public function purchase(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $user    = auth()->user();

        $data = $request->validate([
            'location'       => ['required','string','max:255'],
            'payment_method' => ['required','in:card,cash,bank_transfer'],
        ]);

        if ($product->quantity <= 0) {
            return back()->with('error', 'This product is out of stock.');
        }

        // 1️⃣ Create the Order master record
        $order = Order::create([
            'user_id'        => $user->id,
            'location'       => $data['location'],
            'payment_method' => $data['payment_method'],
            'total'          => $product->price,   // single‑item total
        ]);

        // 2️⃣ Record line item
        OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $product->id,
            'quantity'   => 1,
            'price'      => $product->price,
        ]);

        // 3️⃣ Deduct stock
        $product->decrement('quantity');

        return redirect()
            ->route('my_purchases')
            ->with('success', "Purchase complete! Order #{$order->id} created.");
    }

    /**
     * Show the logged-in user’s order history.
     */
    public function myProducts()
    {
        // Eager‑load items→product for display
        $orders = auth()->user()
                       ->orders()
                       ->with('items.product')
                       ->orderByDesc('created_at')
                       ->get();

        return view('products.purchases', compact('orders'));
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
            'code'        => ['required','string','max:32'],
            'name'        => ['required','string','max:128'],
            'model'       => ['required','string','max:256'],
            'description' => ['required','string','max:1024'],
            'quantity'    => ['required','numeric','min:0'],
            'price'       => ['required','numeric','min:0'],
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
