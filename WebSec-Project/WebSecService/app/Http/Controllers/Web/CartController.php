<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show the cart
    public function index()
    {
        $cart = auth()->user()->cart?->load('items.product');
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

        // Validate delivery info
        $data = $request->validate([
            'location'       => ['required','string','max:255'],
            'payment_method' => ['required','in:card,cash,bank_transfer'],
        ]);

        // Stock check
        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->quantity) {
                return back()->with('error',
                    "Insufficient stock for “{$item->product->name}”: you asked for {$item->quantity}, only {$item->product->quantity} left."
                );
            }
        }

        // Credit check
        $total = $cart->items->sum(fn($i)=> $i->product->price * $i->quantity);
        if ($user->credit < $total) {
            return back()->with('error','Not enough credit to complete this purchase.');
        }

        // Process each item
        foreach ($cart->items as $item) {
            $product = $item->product;

            $product->decrement('quantity', $item->quantity);
            $user->decrement('credit', $product->price * $item->quantity);

            // Attach with pivot data
            $user->purchases()->attach($product->id, [
                'quantity'       => $item->quantity,
                'location'       => $data['location'],
                'payment_method' => $data['payment_method'],
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        // Clear cart
        $cart->items()->delete();

        return redirect()
            ->route('my_purchases')
            ->with('success','Checkout successful!');
    }


}
