<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * GET /delivery
     * Show all pending (not yet accepted) orders.
     */
    public function index()
    {
        $user = auth()->user();
        if (! $user->hasRole('Delivery') && ! $user->hasPermissionTo('deliver_orders')) {
            abort(403);
        }

        // Fetch orders not yet accepted
        $orders = DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select([
                'orders.id',
                'users.name    AS customer_name',
                'orders.location',
                'orders.created_at',
                'orders.accepted',
                'orders.delivery_confirmed',
                'orders.total',
            ])
            ->where('orders.accepted', false)
            ->orderBy('orders.created_at', 'asc')
            ->get();

        return view('delivery.index', compact('orders'));
    }

    /**
     * POST /delivery/{order}/accept
     * Mark accepted = true, then redirect to show().
     */
    public function accept(Request $request, $orderId)
    {
        $user = auth()->user();
        if (! $user->hasRole('Delivery') && ! $user->hasPermissionTo('deliver_orders')) {
            abort(403);
        }

        DB::table('orders')
          ->where('id', $orderId)
          ->update(['accepted' => true]);

        return redirect()
            ->route('delivery.show', $orderId)
            ->with('success', 'Order accepted for delivery.');
    }

    /**
     * GET /delivery/{order}
     * Show full details for one order, including its items.
     */
    public function show($orderId)
    {
        $user = auth()->user();
        if (! $user->hasRole('Delivery') && ! $user->hasPermissionTo('deliver_orders')) {
            abort(403);
        }

        // 1️⃣ fetch the order itself
        $order = DB::table('orders')
            ->join('users','users.id','=','orders.user_id')
            ->select([
            'orders.id',
            'users.name   AS customer_name',
            'users.email  AS customer_email',
            'orders.location',
            'orders.lat',
            'orders.lng',
            'orders.payment_method',
            'orders.accepted',
            'orders.delivery_confirmed',
            'orders.created_at',
            'orders.total',
            ])
            ->where('orders.id', $orderId)
            ->first();

        if (! $order) {
            abort(404,'Order not found.');
        }

        // 2️⃣ fetch **all** of its items
        $items = DB::table('order_items')
            ->join('products','products.id','=','order_items.product_id')
            ->select([
            'products.name as product_name',
            'order_items.quantity',
            'order_items.price',
            ])
            ->where('order_items.order_id', $orderId)
            ->get();

        return view('delivery.show', compact('order','items'));
    }

    /**
     * POST /delivery/{order}/confirm
     * Mark delivery_confirmed = true.
     */
    public function confirm(Request $request, $orderId)
    {
        $user = auth()->user();
        if (! $user->hasRole('Delivery') && ! $user->hasPermissionTo('deliver_orders')) {
            abort(403);
        }

        DB::table('orders')
          ->where('id', $orderId)
          ->update(['delivery_confirmed' => true]);

        return redirect()
            ->route('delivery.index')
            ->with('success','Order marked delivered.');
    }
}
