
@extends('admin.adminPage')

@section('content')
<style>
* {
    margin: 0;
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
.admin-container {
    display: flex;
    min-height: 100vh;
}
.admin-sidebar {
    width: 209px;
    background: #F2F2F2;
    color: #222;
    padding: 20px 0;
}
.admin-sidebar ul {
    list-style: none;
    padding: 0;
    font-weight: 500;
}
.admin-sidebar li {
    margin: 20px 0;
}
.admin-sidebar a {
    color: #222;
    text-decoration: none;
    padding: 10px 20px;
    display: block;
}
.admin-sidebar a:hover {
    background: #ddd;
}
.admin-content {
    flex: 1;
    padding: 40px;
    background: #f4f4f4;
}

.order-table-container {
    margin: 32px 0;
}
.order-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 16px;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}
.order-table th, .order-table td {
    border: 1px solid #ddd;
    padding: 8px 12px;
    text-align: left;
}
.order-table th {
    background: #f4f4f4;
    font-weight: bold;
}
.section-title {
    margin-top: 40px;
    margin-bottom: 18px;
    font-size: 1.2em;
    font-weight: bold;
}
</style>

<div class="order-table-container admin-content">
    <h2 style="margin-bottom:24px;">Order Management</h2>

    {{-- Pending & Shipped Out Orders --}}
    <div>
        <div class="section-title">Active Orders</div>
        <table class="order-table" id="ordersTable">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Date</th>
                    <th>Products</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions->where('status', '!=', 'complete') as $transaction)
                    <tr>
                        <td>
                            {{ optional($transaction->user)->name ?? 'Unknown' }}
                        </td>
                        <td>
                            {{ $transaction->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td>
                            <ul style="margin:0; padding-left:18px;">
                            @foreach(json_decode($transaction->cart, true) as $item)
                                <li>{{ $item['name'] }} (x{{ $item['quantity'] }})</li>
                            @endforeach
                            </ul>
                        </td>
                        <td>
                            ₱{{ number_format($transaction->total, 2) }}
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.transaction.status', $transaction->id) }}" class="status-form">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="status-select" style="padding:4px 8px; border-radius:4px;">
                                    <option value="pending" {{ $transaction->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="on_the_way" {{ $transaction->status === 'on_the_way' ? 'selected' : '' }}>Shipped Out</option>
                                    <option value="complete" {{ $transaction->status === 'complete' ? 'selected' : '' }}>Delivered</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            {{-- Add more actions if needed --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Completed Orders --}}
    <div>
        <div class="section-title">Completed Orders</div>
        <table class="order-table" id="completedOrdersTable">
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
                @foreach($transactions->where('status', 'complete') as $transaction)
                    <tr>
                        <td>
                            {{ optional($transaction->user)->name ?? 'Unknown' }}
                        </td>
                        <td>
                            {{ $transaction->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td>
                            <ul style="margin:0; padding-left:18px;">
                            @foreach(json_decode($transaction->cart, true) as $item)
                                <li>{{ $item['name'] }} (x{{ $item['quantity'] }})</li>
                            @endforeach
                            </ul>
                        </td>
                        <td>
                            ₱{{ number_format($transaction->total, 2) }}
                        </td>
                        <td>
                            <span style="color:green;font-weight:bold;">Delivered</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
document.querySelectorAll('.status-select').forEach(function(select) {
    select.addEventListener('change', function(e) {
        if (this.value === 'complete') {
            if (!confirm('Are you sure you want to mark this order as Delivered? This action cannot be undone.')) {
                this.selectedIndex = [...this.options].findIndex(opt => opt.defaultSelected);
                e.preventDefault();
                return false;
            }
        }
        this.form.submit();
    });
});
</script>
@endsection