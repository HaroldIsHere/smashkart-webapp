<DOCTYPE html>
<html>
    <head>
        <link href="/css/product.css" rel="stylesheet">
        <script src="{{ asset('/js/slider.js') }}"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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
        <div class="product-container">
            <img src="{{ asset('/img/Products/Bag/' . $bag->Name . '.jpg') }}" alt="Bag Image" class="product-image">
            <div class="product-options">
                <h1>{{ $bag->Name }}</h1>
                <p><strong>Price:</strong> ₱{{ number_format($bag->SRP, 2) }}</p>
                <label for="quantity"><strong>Quantity:</strong></label>
                <div class="quantity-selector">
                    <button type="button" class="quantity-btn" onclick="changeQuantity(-1)">-</button>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $bag->Stock }}" class="quantity-input" readonly>
                    <button type="button" class="quantity-btn" onclick="changeQuantity(1)">+</button>
                </div>
                <script>
                    function changeQuantity(amount) {
                        var input = document.getElementById('quantity');
                        var min = parseInt(input.min);
                        var max = parseInt(input.max);
                        var value = parseInt(input.value) + amount;
                        if (value >= min && value <= max) {
                            input.value = value;
                        }
                    }
                </script>
                <button class="add-to-cart-btn" onclick="addToCart('bag', {{ $bag->BagID }})" type="button">Add to Cart</button>
            </div>
            <div class="product-details">
                <h2>Description</h2>
                <p> "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
                <table class="product-details-table">
                    <tr>
                        <th>Dimensions</th>
                        <td>{{ $bag->Dimensions }}</td>
                    </tr>
                    <tr>
                        <th>Racket Compartment</th>
                        <td>{{ $bag->RC ? 'Yes' : 'No' }}</td>
                    </tr>
                    <tr>
                        <th>Shoe Compartment</th>
                        <td>{{ $bag->SC ? 'Yes' : 'No' }}</td>
                    </tr>
                    <tr>
                        <th>Other Features</th>
                        <td>{{ $bag->OF }}</td>
                    </tr>
                    <tr>
                        <th>Material</th>
                        <td>{{ $bag->Material }}</td>
                    </tr>
                </table>
                <!-- <p><strong>Stock:</strong> {{ $bag->Stock }}</p> -->
            </div>
        </div>
        <div class="onsale">
            <h2 class="title1">You might also like</h2>
            <div class="slider-container">
                @foreach($bags as $bag)
                <a href="{{ route('products.bagView', ['name' => $bag->Name]) }}" style="text-decoration:none; color:inherit;">
                    <div class="bag-card">
                        <img src="{{ asset('img/Products/Bag/' . $bag->Name . '.jpg') }}" alt="{{ $bag->Name }}" style="width:100%; height:150px; object-fit:cover; border-radius:8px;">
                        <h3>{{ $bag->Name }}</h3>
                        <p><strong>Price:</strong> ₱{{ number_format($bag->SRP, 2) }}</p>
                        @if($bag->RC)
                            <span class="badge">RC</span>
                        @endif
                        @if($bag->SC)
                            <span class="badge">SC</span>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
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
        <script>
            function addToCart(type, id) {
                const quantity = parseInt(document.getElementById('quantity').value) || 1;
                fetch(`/cart/add/${type}/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ quantity: quantity })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        document.getElementById('cart-count').textContent = '(' + data.cartCount + ')';
                        alert('Added to cart!');
                    } else {
                        alert('Failed to add to cart.');
                    }
                })
                .catch(() => alert('Failed to add to cart.'));
            }
        </script>
    </body>
    <style>
        .add-to-cart-btn {
        background: #3C2EFF;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 12px 28px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 18px;
        transition: background 0.2s;
    }
    .add-to-cart-btn:hover {
        background: #2a22b8;
    }
    .quantity-selector {
        display: flex;
        align-items: center;
        margin: 12px 0;
    }
    .quantity-btn {
        background: #f2f2f2;
        border: 1px solid #ccc;
        color: #333;
        font-size: 18px;
        width: 32px;
        height: 32px;
        border-radius: 4px;
        cursor: pointer;
        margin: 0 6px;
        transition: background 0.2s;
    }
    .quantity-btn:hover {
        background: #e0e0e0;
    }
    .quantity-input {
        width: 48px;
        text-align: center;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background: #fafafa;
        margin: 0 4px;
    }
    </style>
</html>
