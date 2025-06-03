{{-- filepath: c:\xampp\htdocs\smashkart-webapp\resources\views\admin\orderManagement.blade.php --}}
@php
    use App\Models\Transaction;
    use App\Models\User;
    $transactions = Transaction::with('user')->orderBy('created_at', 'desc')->get();
@endphp

<div style="padding:32px;">
    <h2 style="margin-bottom:24px;">Order Management</h2>
    <table style="width:100%; border-collapse:collapse; background:#fff;">
        <thead>
            <tr style="background:#f4f4f4;">
                <th style="padding:8px; border:1px solid #ddd;">User</th>
                <th style="padding:8px; border:1px solid #ddd;">Date</th>
                <th style="padding:8px; border:1px solid #ddd;">Products</th>
                <th style="padding:8px; border:1px solid #ddd;">Total</th>
                <th style="padding:8px; border:1px solid #ddd;">Status</th>
                <th style="padding:8px; border:1px solid #ddd;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td style="padding:8px; border:1px solid #ddd;">
                        {{ optional($transaction->user)->name ?? 'Unknown' }}
                    </td>
                    <td style="padding:8px; border:1px solid #ddd;">
                        {{ $transaction->created_at->format('Y-m-d H:i') }}
                    </td>
                    <td style="padding:8px; border:1px solid #ddd;">
                        <ul style="margin:0; padding-left:18px;">
                        @foreach(json_decode($transaction->cart, true) as $item)
                            <li>{{ $item['name'] }} (x{{ $item['quantity'] }})</li>
                        @endforeach
                        </ul>
                    </td>
                    <td style="padding:8px; border:1px solid #ddd;">
                        ₱{{ number_format($transaction->total, 2) }}
                    </td>
                    <td style="padding:8px; border:1px solid #ddd;">
                        <form method="POST" action="{{ route('admin.transaction.status', $transaction->id) }}">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" style="padding:4px 8px; border-radius:4px;">
                                <option value="pending" {{ $transaction->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="on_the_way" {{ $transaction->status === 'on_the_way' ? 'selected' : '' }}>On the Way</option>
                                <option value="complete" {{ $transaction->status === 'complete' ? 'selected' : '' }}>Complete</option>
                            </select>
                        </form>
                    </td>
                    <td style="padding:8px; border:1px solid #ddd;">
                        {{-- Add more actions if needed --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
