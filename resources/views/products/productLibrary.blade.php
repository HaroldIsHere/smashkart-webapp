@php
    $typeMap = [
        'Rackets' => 'bad',
        'Shoes' => 'shoe',
        'Bag' => 'bag',
        'Accessories' => 'accessory',
        'Apparel' => 'apparel'
    ];
    $typeForAddToCart = $typeMap[$activeCategoryName] ?? strtolower($activeCategoryName);
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmashKart - Rackets</title>
    <link rel="stylesheet" href="/css/style.css">
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
                <div class="cart-dropdown" id="cartDropdownMenu"
                    style="display:none; position:absolute; right:0; background:#fff; min-width:250px; box-shadow:0 8px 16px rgba(0,0,0,0.2); z-index:100; border-radius:8px; padding:10px;">
                    @php
                        $cart = session('cart', []);
                    @endphp
                    @if(count($cart) > 0)
                        <strong>Cart Items:</strong>
                        <ul style="list-style:none; padding:0; margin:0;">
                            @foreach($cart as $item)
                                <li style="padding:8px 0; border-bottom:1px solid #eee; display:flex; align-items:center;">
                                    <img src="{{ asset('img/Products/' . ($item['category'] ?? 'Bag') . '/' . $item['name'] . '.jpg') }}"
                                        alt="{{ $item['name'] }}"
                                        style="width:40px; height:40px; object-fit:cover; border-radius:4px; margin-right:10px;">
                                    <div>
                                        <div><strong>{{ $item['name'] }}</strong></div>
                                        <div>₱{{ number_format($item['price'], 2) }}</div>
                                        <div>Qty: {{ $item['quantity'] }}</div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('cart.index') }}"
                            style="display:block; margin-top:10px; text-align:center; color:#007bff;">View Cart</a>
                    @else
                        <div style="padding:10px 0;">Your cart is empty.</div>
                    @endif
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const btn = document.getElementById('cartDropdownBtn');
                    const menu = document.getElementById('cartDropdownMenu');
                    document.addEventListener('click', function (event) {
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
                <div class="acc-dropdown" id="accDropdownMenu"
                    style="display:none; position:absolute; right:0; background:#fff; min-width:180px; box-shadow:0 8px 16px rgba(0,0,0,0.2); z-index:100; border-radius:8px; padding:10px;">
                    @if(Auth::check())
                        <a href="{{ route('acc.acc') }}"
                            style="display:block; padding:8px 0; color:#333; text-decoration:none;">My Account</a>
                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit"
                                style="width:100%; padding:8px 0; background:none; border:none; color:#333; text-align:left; cursor:pointer;">Log
                                Out</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            style="display:block; padding:8px 0; color:#333; text-decoration:none;">Log In</a>
                        <a href="{{ route('acc.acc') }}"
                            style="display:block; padding:8px 0; color:#333; text-decoration:none;">My Account</a>
                    @endif
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const accBtn = document.getElementById('accDropdownBtn');
                    const accMenu = document.getElementById('accDropdownMenu');
                    document.addEventListener('click', function (event) {
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
            <a href="{{ route('products.productLibrary', ['category' => 'apparel']) }}"
                class="category-option">Apparel</a>
            <a href="{{ route('products.productLibrary', ['category' => 'shoes']) }}" class="category-option">Shoes</a>
            <a href="{{ route('products.productLibrary', ['category' => 'bag']) }}" class="category-option">Bag</a>
            <a href="{{ route('products.productLibrary', ['category' => 'rackets']) }}"
                class="category-option">Rackets</a>
            <a href="{{ route('products.productLibrary', ['category' => 'accessories']) }}"
                class="category-option">Accessories</a>
        </div>
    </div>
    <!-- BREADCRUMB -->
    <div class="breadcrumb">
        <a href="#">HOME</a> <span>›</span> <span>RACKETS</span>
    </div>

    <!-- BANNER -->
    <div class="banner">
        <img src="{{ asset('img/Banner/' . $activeCategoryName . '.png') }}" alt="Apparel Banner">
    </div>

    <!-- MAIN CONTENT -->
    <p class="category-title">{{ $activeCategoryName }}</p>
    <div class="container">
        <div class="products">
            @php
                $idProperty = match ($typeForAddToCart) {
                    'bad' => 'BadID',
                    'bag' => 'BagID',
                    'shoe' => 'ShoeID',
                    'accessory' => 'AccessoryID',
                    'apparel' => 'AppID',
                    default => 'id'
                };
            @endphp

            @forelse($products as $product)
                <div class="product">
                    <a href="{{ route('products.' . $categoryViewRoute, ['name' => $product->Name]) }}"
                        style="text-decoration:none; color:inherit;">
                        <img src="{{ asset('img/Products/' . $activeCategoryName . '/' . $product->Name . '.jpg') }}"
                            alt="{{ $product->Name ?? 'No Name' }}"
                            style="width:100%; height:150px; object-fit:cover; border-radius:8px;">
                        <h4>{{ $product->Name ?? 'No Name' }}</h4>
                        <p class="product-price">
                            ₱{{ isset($product->SRP) ? number_format($product->SRP, 2) : '0.00' }}
                        </p>
                    </a>
                    <button type="button"
                        onclick="addToCart('{{ $typeForAddToCart }}', {{ $product->{$idProperty} ?? 'null' }})"
                        class="add-to-cart-btn" style="background:none;border:none;cursor:pointer;">
                        <img src="/img/Icons/AddToCart.png" alt="Add to Cart" style="width:20px; vertical-align:middle;">
                    </button>
                </div>
            @empty
                <p>No products found in this category.</p>
            @endforelse
        </div>
    </div>

    <script>
        async function updateCartCountAndDropdown() {
            try {
                // Update cart count
                const res = await fetch('/cart/count');
                const data = await res.json();
                document.getElementById('cart-count').textContent = `(${data.count})`;

                // Update cart dropdown content
                const dropdownRes = await fetch('/cart/mini');
                const dropdownHtml = await dropdownRes.text();
                const menu = document.getElementById('cartDropdownMenu');
                if (menu) menu.innerHTML = dropdownHtml;
            } catch (err) {
                console.error('Failed to update cart info:', err);
            }
        }

        async function addToCart(type, productId) {
            try {
                const res = await fetch(`/cart/add/${type}/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ quantity: 1 })
                });

                if (res.ok) {
                    const data = await res.json();
                    if (data.success) {
                        await updateCartCountAndDropdown();
                        alert('Added to cart!');
                    } else {
                        alert('Failed to add to cart.');
                    }
                } else {
                    alert('Failed to add to cart.');
                }
            } catch (err) {
                console.error('Error:', err);
                alert('Failed to add to cart.');
            }
        }

        // Optionally, update on page load
        document.addEventListener('DOMContentLoaded', function () {
            updateCartCountAndDropdown();
        });
    </script>

    <div class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>We are a leading online store for sports equipment and accessories.</p>
            </div>
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p>Email: support@smashkart.com</p>
            </div>
        </div>
    </div>

</body>

</html>