<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class FinanceController extends Controller
{
    public function __construct()
    {
        // Only require authentication here
        $this->middleware('auth:web');
    }

    /**
     * Show the finance dashboard with all past transactions.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Enforce the can_finance permission
        if (! $user->hasPermissionTo('can_finance')) {
            abort(403, 'Unauthorized');
        }

        // Load every order with its user and line‐items → product
        $transactions = Order::with('user', 'items.product')
                             ->orderByDesc('created_at')
                             ->get();

        return view('finance.index', compact('transactions'));
    }
}