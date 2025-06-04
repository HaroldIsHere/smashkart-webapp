@if(count($cart) > 0)
    <strong>Cart Items:</strong>
    <ul style="list-style:none; padding:0; margin:0;">
        @foreach($cart as $item)
            <li style="padding:8px 0; border-bottom:1px solid #eee; display:flex; align-items:center;">
                <img src="{{ asset('img/Products/' . ($item['category'] ?? 'Bag') . '/' . $item['name'] . '.jpg') }}" alt="{{ $item['name'] }}" style="width:40px; height:40px; object-fit:cover; border-radius:4px; margin-right:10px;">
                <div>
                    <div><strong>{{ $item['name'] }}</strong></div>
                    <div>₱{{ number_format($item['price'], 2) }}</div>
                    <div>Qty: {{ $item['quantity'] }}</div>
                </div>
            </li>
        @endforeach
    </ul>
    <a href="{{ route('cart.index') }}" style="display:block; margin-top:10px; text-align:center; color:#007bff;">View Cart</a>
@else
    <div style="padding:10px 0;">Your cart is empty.</div>
@endif