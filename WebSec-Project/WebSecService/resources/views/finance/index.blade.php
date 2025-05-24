@extends('layouts.master')
@section('title', 'Finance Dashboard')
@section('content')

    <style>
        body {
            min-height: 100vh;
            background:
                linear-gradient(135deg, rgba(220, 20, 60, 0.3), rgba(220, 20, 60, 0.1)),
                url('https://ik.imagekit.io/jyx7871cz/2148633547.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Inter', sans-serif;
            color: #222;
        }

        .finance-container {
            max-width: 1200px;
            margin: 2rem auto 4rem;
            padding: 0 1rem;
        }

        /* Big full-width header banner */
        .finance-banner {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            padding: 2rem 1rem;
            border-radius: 1rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        .finance-banner h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 800;
            color: #b11236;
            text-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        /* Filter panel */
        .filter-panel {
            background: rgba(255, 255, 255, 0.8);
            padding: 1rem;
            border-radius: 0.8rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .filter-panel .input-group {
            max-width: 200px;
            flex: 1;
        }

        /* Summary cards */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2.5rem;
        }

        .summary-card {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 0.8rem;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .summary-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .summary-card h4 {
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
            color: #b11236;
        }

        .summary-card p {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
        }

        /* Table styling */
        .modern-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 0.8rem;
            padding: 1rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .modern-card table {
            border-collapse: separate;
            border-spacing: 0 0.5rem;
        }

        .modern-card thead th {
            background: #b11236;
            color: #fff;
            border: none;
            font-weight: 600;
            padding: 0.8rem;
        }

        .modern-card tbody tr {
            background: #fff;
            border-radius: 0.5rem;
        }

        .modern-card tbody tr:hover {
            background: #fde2e4;
        }

        .modern-card td {
            border: none;
            padding: 0.75rem 1rem;
        }

        .modern-card .collapse-row td {
            background: #fcf5f5;
        }

        /* Buttons */
        .btn-outline-primary {
            border-radius: 0.5rem;
            border-color: #b11236;
            color: #b11236;
            font-weight: 600;
        }

        .btn-outline-primary:hover {
            background: #b11236;
            color: #fff;
        }

        /* Responsive */
        @media(max-width:600px) {
            .finance-banner h1 {
                font-size: 2rem;
            }
        }
    </style>

    <div class="finance-container">

        <!-- Banner -->
        <div class="finance-banner">
            <h1>All Transactions</h1>
        </div>

        <!-- Filter -->
        <form method="GET" class="filter-panel">
            <div class="input-group">
                <span class="input-group-text">From</span>
                <input type="date" name="from" value="{{ request('from') }}" class="form-control">
            </div>
            <div class="input-group">
                <span class="input-group-text">To</span>
                <input type="date" name="to" value="{{ request('to') }}" class="form-control">
            </div>
            <button class="btn btn-outline-primary px-4" type="submit">Filter</button>
            <a href="{{ route('finance') }}" class="btn btn-outline-secondary px-4">Reset</a>
        </form>

        <!-- Summary -->
        <div class="summary-grid">
            <div class="summary-card">
                <h4>Total Orders</h4>
                <p>{{ $transactions->count() }}</p>
            </div>
            <div class="summary-card">
                <h4>Total Revenue</h4>
                <p>${{ number_format($transactions->sum('total'), 2) }}</p>
            </div>
            <div class="summary-card">
                <h4>Unique Customers</h4>
                <p>{{ $transactions->pluck('user_id')->unique()->count() }}</p>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="modern-card">
            @if ($transactions->isEmpty())
                <p class="text-center mb-0">No transactions found.</p>
            @else
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>User</th>
                                <th>Method</th>
                                <th>Total</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ ucfirst($order->payment_method) }}</td>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse"
                                            data-bs-target="#items-{{ $order->id }}">
                                            View
                                        </button>
                                    </td>
                                </tr>
                                <tr class="collapse collapse-row" id="items-{{ $order->id }}">
                                    <td colspan="6">
                                        <ul class="list-group">
                                            @foreach ($order->items as $item)
                                                <li class="list-group-item d-flex justify-content-between">
                                                    {{ $item->product->name }} × {{ $item->quantity }}
                                                    <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

@endsection
