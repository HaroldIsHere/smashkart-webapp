@extends('admin.adminPage')

@section('content')
    <style>
        * {
            margin: 0;
            font-family: "Montserrat", sans-serif;
        }

        body {
            background: #f4f4f4;
            font-family: "Montserrat", sans-serif;
        }

        header {
            position: relative;
            top: 0;
            width: 100%;
            height: 60px;
            background-color: #3131D4;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
        }

        .logo {
            height: 60px;
        }

        .dashboard-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 32px 16px 64px 16px;
        }

        .dashboard-header {
            display: flex;
            flex-wrap: wrap;
            gap: 32px;
            margin-bottom: 32px;
            justify-content: space-between;
        }

        .dashboard-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
            padding: 32px 32px 24px 32px;
            min-width: 300px;
            flex: 1 1 320px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .dashboard-card h2 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 18px;
            color: #3131D4;
        }

        .dashboard-card .big-number {
            font-size: 2.3rem;
            font-weight: 700;
            color: #28a745;
            margin-bottom: 0;
        }

        .dashboard-card canvas {
            margin-top: 12px;
        }

        .dashboard-main {
            display: flex;
            gap: 32px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .dashboard-main .dashboard-card {
            min-width: 420px;
            flex: 1 1 420px;
        }

        .dashboard-main .dashboard-card select,
        .dashboard-main .dashboard-card input[type="month"] {
            margin-bottom: 16px;
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        .pending-orders-table-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
            padding: 32px 32px 24px 32px;
            margin: 40px 0 0 0;
            width: 94.5%;
            max-width: 100%;
        }

        .pending-orders-table-container h2 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 18px;
            color: #3131D4;
        }

        .pending-orders-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
        }

        .pending-orders-table th,
        .pending-orders-table td {
            border: 1px solid #eee;
            padding: 10px 12px;
            text-align: left;
            font-size: 15px;
        }

        .pending-orders-table th {
            background: #f4f4f4;
            font-weight: bold;
        }

        @media (max-width: 1200px) {

            .dashboard-header,
            .dashboard-main {
                flex-direction: column;
                gap: 24px;
            }

            .dashboard-card,
            .dashboard-main .dashboard-card {
                min-width: 0;
                width: 100%;
            }
        }

        @media (max-width: 700px) {

            .dashboard-wrapper,
            .pending-orders-table-container {
                padding: 12px 2px;
            }

            .dashboard-card,
            .dashboard-main .dashboard-card,
            .pending-orders-table-container {
                padding: 18px 8px 12px 8px;
            }
        }
    </style>

    <div class="dashboard-wrapper">
        <div class="dashboard-header">
            {{-- Summary Card: Sales, Users, Pending Orders --}}
            <div class="dashboard-card" style="display: flex; flex-direction: column; gap: 28px; justify-content: center;">
                <div>
                    <h2>Total Sales (This Year)</h2>
                    <div class="big-number">
                        ₱{{ number_format($totalSalesYear ?? 0, 2) }}
                    </div>
                </div>
                <div>
                    <h2>Total Users</h2>
                    <div class="big-number" style="color:#3131D4;">
                        {{ $totalUsers ?? 0 }}
                    </div>
                </div>
                <div>
                    <h2>Total Pending Orders</h2>
                    <div class="big-number" style="color:#ff9800;">
                        {{ $totalPendingOrders ?? 0 }}
                    </div>
                </div>
            </div>
            {{-- Orders Count Per Month --}}
            <div class="dashboard-card">
                <h2>Total Orders Per Month ({{ now()->year }})</h2>
                <canvas id="ordersPerMonthChart" height="160"></canvas>
            </div>
        </div>

        <div class="dashboard-main">
            {{-- Sales Per Month Dashboard --}}
            <div class="dashboard-card">
                <h2>Sales Per Month</h2>
                <form id="salesFilterForm" style="margin-bottom: 12px;">
                    <label for="salesMonth" style="font-weight:500;">Pick Month:</label>
                    <input type="month" id="salesMonth" name="salesMonth"
                        value="{{ request('salesMonth', now()->format('Y-m')) }}">
                </form>
                <canvas id="salesPerMonthChart" height="120"></canvas>
            </div>
        </div>

        {{-- Pending Orders Table --}}
        <div class="pending-orders-table-container">
            <h2>Pending Orders</h2>
            <table class="pending-orders-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Date</th>
                        <th>Products</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingOrders as $order)
                        <tr>
                            <td>{{ optional($order->user)->name ?? 'Unknown' }}</td>
                            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <ul style="margin:0; padding-left:18px;">
                                    @foreach(json_decode($order->cart, true) as $item)
                                        <li>{{ $item['name'] }} (x{{ $item['quantity'] }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>₱{{ number_format($order->total, 2) }}</td>
                            <td>
                                <span style="color:orange;font-weight:bold;">Pending</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ordersPerMonthLabels = {!! json_encode($ordersPerMonthLabels) !!};
            const ordersPerMonthData = {!! json_encode($ordersPerMonthData) !!};
            new Chart(document.getElementById('ordersPerMonthChart'), {
                type: 'bar',
                data: {
                    labels: ordersPerMonthLabels,
                    datasets: [{
                        label: 'Orders',
                        data: ordersPerMonthData,
                        backgroundColor: 'rgba(255, 159, 64, 0.7)'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        title: { display: false }
                    }
                }
            });

            // Sales Per Month Chart (now monthly, not daily)
            const salesPerMonthLabels = {!! json_encode($salesPerMonthLabels) !!}; // e.g. ['January', 'February', ...]
            const salesPerMonthData = {!! json_encode($salesPerMonthData) !!};     // e.g. [10000, 12000, ...]
            new Chart(document.getElementById('salesPerMonthChart'), {
                type: 'bar',
                data: {
                    labels: salesPerMonthLabels,
                    datasets: [{
                        label: 'Sales (₱)',
                        data: salesPerMonthData,
                        backgroundColor: 'rgba(40, 167, 69, 0.7)'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        title: { display: false }
                    }
                }
            });

            // Month picker filter (optional, can be removed if not needed)
            const salesMonthInput = document.getElementById('salesMonth');
            if (salesMonthInput) {
                salesMonthInput.addEventListener('change', function () {
                    document.getElementById('salesFilterForm').submit();
                });
            }
        });
    </script>
@endsection