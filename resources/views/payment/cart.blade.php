<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="/css/cart.css" />
</head>
<body>
    <div class="header">
    <div class="navigation_top">
        <a href="{{ url('/') }}">
            <img src="/img/Logo.png" class="Logo" alt="Logo Smashkart">
        </a>
        <div class="searchbar-container">
            <img src="/img/Icons/Search.png" class="searchIcon">
            <input type="text" id="searchbar" placeholder="Looking for something?">
        </div>
        <div class="cart-dropdown-container" style="position: relative;">
            <a href="javascript:void(0);" id="cartDropdownBtn">
                <img class="shopIcon" src="/img/Icons/Shopping cart.png" alt="Shopping Cart">
            </a>
            <div class="cart-dropdown" id="cartDropdownMenu" style="display:none; position:absolute; right:0; background:#fff; min-width:250px; box-shadow:0 8px 16px rgba(0,0,0,0.2); z-index:100; border-radius:8px; padding:10px;">
                @php
                    $cart = session('cart', []);
                @endphp
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
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const btn = document.getElementById('cartDropdownBtn');
                const menu = document.getElementById('cartDropdownMenu');
                document.addEventListener('click', function(event) {
                    if (btn.contains(event.target)) {
                        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
                    } else if (!menu.contains(event.target)) {
                        menu.style.display = 'none';
                    }
                });
            });
        </script>
        <p class="cart-text">My Cart <strong id="cart-count">({{ count(session('cart', [])) }})</strong></p>
        <div class="acc-dropdown-container">
            <a href="javascript:void(0);" id="accDropdownBtn">
                <img class="accIcon" src="/img/Icons/User.png" alt="Account">
            </a>
            <div class="acc-dropdown" id="accDropdownMenu" style="display:none; position:absolute; right:0; background:#fff; min-width:180px; box-shadow:0 8px 16px rgba(0,0,0,0.2); z-index:100; border-radius:8px; padding:10px;">
                @if(Auth::check())
                    <a href="{{ route('acc.acc') }}" style="display:block; padding:8px 0; color:#333; text-decoration:none;">My Account</a>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" style="width:100%; padding:8px 0; background:none; border:none; color:#333; text-align:left; cursor:pointer;">Log Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" style="display:block; padding:8px 0; color:#333; text-decoration:none;">Log In</a>
                    <a href="{{ route('acc.acc') }}" style="display:block; padding:8px 0; color:#333; text-decoration:none;">My Account</a>
                @endif
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const accBtn = document.getElementById('accDropdownBtn');
                const accMenu = document.getElementById('accDropdownMenu');
                document.addEventListener('click', function(event) {
                    if (accBtn.contains(event.target)) {
                        accMenu.style.display = (accMenu.style.display === 'block') ? 'none' : 'block';
                    } else if (!accMenu.contains(event.target)) {
                        accMenu.style.display = 'none';
                    }
                });
            });
        </script>
    </div>
    <div class="categories_tab">
        <a href="{{ route('products.productLibrary', ['category' => 'apparel']) }}" class="category-option">Apparel</a>
        <a href="{{ route('products.productLibrary', ['category' => 'shoes']) }}" class="category-option">Shoes</a>
        <a href="{{ route('products.productLibrary', ['category' => 'bag']) }}" class="category-option">Bag</a>
        <a href="{{ route('products.productLibrary', ['category' => 'rackets']) }}" class="category-option">Rackets</a>
        <a href="{{ route('products.productLibrary', ['category' => 'accessories']) }}" class="category-option">Accessories</a>
    </div>
</div>
    <div class="cart-summary">
        <h2>Cart Summary</h2>
        <div class="summary-item">
            <span>Total Items:</span>
            <span id="total-items">0</span>
        </div>
        <div class="summary-item">
            <span>Total Price:</span>
            <span id="total-price">₱0.00</span>
        </div>
        @if(Auth::check())
            <a href="{{ route('checkout') }}">
                <button type="button" class="checkout-button">Checkout</button>
            </a>
        @else
            <div class="login-required-message" style="color: #d9534f; margin: 10px 0;">
                You need to log in first to checkout.
            </div>
            <a href="{{ route('login') }}">
                <button type="button" class="checkout-button">Log In to Checkout</button>
            </a>
        @endif
    </div>
    <div class="cart-container">
        <header class="cart-header">
            <h1>My Cart</h1>
        </header>
        @if(session('cart') && count(session('cart')) > 0)
            <table class="cart-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalItems = 0;
                        $totalPrice = 0;
                    @endphp
                    @foreach(session('cart') as $item)
                        @php
                            $subtotal = $item['price'] * $item['quantity'];
                            $totalItems += $item['quantity'];
                            $totalPrice += $subtotal;
                            $itemID = $item['id'] ?? $item['name'];
                        @endphp
                        <tr>
                            <td>
                                @php
                                    $imageName = $item['name'] . '.jpg';
                                    $type = isset($item['type']) ? $item['type'] : 'default';
                                    $imageUrl = asset('/img/Products/' . $type . '/' . $imageName);
                                @endphp
                                <img src="{{ $imageUrl }}" alt="{{ $item['name'] }}" class="cart-product-img" width="50" onerror="this.style.display='none'; this.insertAdjacentHTML('afterend', '<span>No Image</span>');">
                            </td>
                            <td>{{ $item['name'] }}</td>
                            <td>₱{{ number_format($item['price'], 2) }}</td>
                            <td>
                                <input 
                                    type="number" 
                                    min="1" 
                                    class="quantity-input" 
                                    data-name="{{ $item['name'] }}" 
                                    value="{{ $item['quantity'] }}" 
                                    style="width:60px; padding:4px; border-radius:4px; border:1px solid #ccc; text-align:center;"
                                >
                            </td>
                            <td class="subtotal-cell">₱{{ number_format($subtotal, 2) }}</td>
                            <td>
                                <button type="button" class="remove-button" data-name="{{ $item['name'] }}">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <script>
                document.getElementById('total-items').textContent = '{{ $totalItems }}';
                document.getElementById('total-price').textContent = '₱{{ number_format($totalPrice, 2) }}';
            </script>
        @else
            <p>Your cart is empty.</p>
            <script>
                document.getElementById('total-items').textContent = '0';
                document.getElementById('total-price').textContent = '₱0.00';
            </script>
        @endif
    </div>

</body>
<script>
function updateCartSummary() {
    fetch('/cart/summary')
        .then(res => res.json())
        .then data => {
            document.getElementById('cart-total-items').textContent = data.totalItems;
            document.getElementById('cart-total-price').textContent = '₱' + parseFloat(data.totalPrice).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});
        };
}
</script>
<script>
    document.querySelectorAll('.remove-button').forEach(button => {
        button.addEventListener('click', async () => {
            const itemName = button.getAttribute('data-name');
            const encodedName = encodeURIComponent(itemName);
            const row = button.closest('tr');

            const response = await fetch(`/cart/remove-by-name/${encodedName}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            });

            if (response.ok) {
                row.remove();
                updateCartSummary();
            } else {
                alert('Error removing item.');
            }
        });
    });

    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', async function() {
            let newQty = parseInt(this.value);
            if (isNaN(newQty) || newQty < 1) {
                this.value = 1;
                newQty = 1;
            }
            const itemName = this.getAttribute('data-name');
            const encodedName = encodeURIComponent(itemName);

            // Send AJAX request to update quantity
            const response = await fetch(`/cart/update-quantity/${encodedName}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ quantity: newQty })
            });

            if (response.ok) {
                const data = await response.json();
                // Update subtotal cell
                const row = this.closest('tr');
                row.querySelector('.subtotal-cell').textContent = `₱${parseFloat(data.subtotal).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2})}`;
                updateCartSummary();
            } else {
                alert('Failed to update quantity.');
            }
        });
    });

    function updateCartSummary() {
        let totalItems = 0;
        let totalPrice = 0;

        document.querySelectorAll('.cart-table tbody tr').forEach(row => {
            // Get the quantity from the input field, not from textContent
            const quantityInput = row.querySelector('input.quantity-input');
            const quantity = quantityInput ? parseInt(quantityInput.value) : 0;

            // Get the subtotal from the .subtotal-cell, remove ₱ and commas
            const subtotalText = row.querySelector('.subtotal-cell').textContent.replace(/[₱,]/g, '');
            const subtotal = parseFloat(subtotalText) || 0;

            totalItems += quantity;
            totalPrice += subtotal;
        });

        document.getElementById('total-items').textContent = totalItems;
        document.getElementById('total-price').textContent = `₱${totalPrice.toFixed(2)}`;
    }
</script>

</html>