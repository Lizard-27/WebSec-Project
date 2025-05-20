<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;       // ← import your Order model
use App\Models\OrderItem;   // ← if you also reference OrderItem
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show the cart
// app/Http/Controllers/Web/CartController.php

public function index()
{
    // Force the Cart to come back with its items and each item's product
    $cart = auth()
        ->user()
        ->cart()
        ->with('items.product')    // eager-load the product on each CartItem
        ->first();                 // get the Cart model instance

    // Now $cart->items will be a Collection of CartItem with product loaded
    return view('cart.index', compact('cart'));
}


    // Add a product to cart
    public function add(Request $request, Product $product)
    {
        $qty = max(1, (int)$request->quantity);
        $user = auth()->user();
        $cart = $user->cart ?? Cart::create(['user_id' => $user->id]);

        $item = $cart->items()->firstOrNew(['product_id' => $product->id]);
        $item->quantity += $qty;
        $item->save();

        return back()->with('success','Added to cart.');
    }

    // Update quantity
    public function update(Request $request, CartItem $item)
    {
        $item->update(['quantity' => max(1, (int)$request->quantity)]);
        return back();
    }

    // Remove
    public function remove(CartItem $item)
    {
        $item->delete();
        return back()->with('success','Removed from cart.');
    }

    

    // Checkout
    public function checkout(Request $request)
    {
        $user = auth()->user();
        $cart = $user->cart?->load('items.product');

        if (! $cart || $cart->items->isEmpty()) {
            return back()->with('error','Your cart is empty.');
        }

        // 1️⃣ Validate
        $data = $request->validate([
            'location'       => 'required|string|max:255',
            'lat'            => 'nullable|numeric',
            'lng'            => 'nullable|numeric',
            'payment_method' => 'required|in:card,cash,bank_transfer',
            // card‑fields if you still want them…
        ]);

        // 2️⃣ Total & stock check
        $total = 0;
        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->quantity) {
                return back()->with('error',
                    "Only {$item->product->quantity} “{$item->product->name}” in stock, you asked for {$item->quantity}."
                );
            }
            $total += $item->product->price * $item->quantity;
        }

        // 3️⃣ Create master Order
        $order = Order::create([
            'user_id'           => $user->id,
            'location'          => $data['location'],
            'lat'               => $data['lat'] ?? null,
            'lng'               => $data['lng'] ?? null,
            'payment_method'    => $data['payment_method'],
            'total'             => $total,
            'accepted'          => false,
            'delivery_confirmed'=> false,
        ]);

        // 4️⃣ Create line‐items & deduct stock
        DB::transaction(function() use ($order, $cart, $user) {
            foreach ($cart->items as $item) {
                $p = $item->product;
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $p->id,
                    'quantity'   => $item->quantity,
                    'price'      => $p->price,
                ]);
                $p->decrement('quantity', $item->quantity);
            }
            // 5️⃣ Empty cart
            $cart->items()->delete();
        });

        return redirect()
            ->route('my_purchases')
            ->with('success',"Checkout complete—Order #{$order->id} created.");
    }
}


