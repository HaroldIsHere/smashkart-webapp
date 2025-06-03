<!DOCTYPE html>
<html>
    <head>
        <link href="/css/main.css" rel="stylesheet">
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
        <div class="album">
            <img id="albumImage" src="/img/1.png" alt="Image 1">
        </div>
        <div class="controls">
            <button onclick="prevImage()" class="prevBtn"><</button>
            <button onclick="nextImage()" class="nextBtn">></button>
        </div>

        <div class="onsale">
            <h2 class="title1">New Bag Collection</h2>
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
                        <a href="javascript:void(0);" onclick="addToCart('bag', {{ $bag->BagID }})" class="add-to-cart-btn">
                            <img src="/img/Icons/AddToCart.png" alt="Add to Cart" style="width:20px; vertical-align:middle;">
                        </a>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <div class="add-container">
            <img class="adds" src="/img/adds/adds1.png" alt="adds1">
        </div>

        <div class="shoe-container">
            <h2 class="title1">New Shoes Collection</h2>
            <div class="slider-container">
                @foreach($shoes as $shoe)
                <a href="{{ route('products.shoeView', ['name' => $shoe->Name]) }}" style="text-decoration:none; color:inherit;">
                    <div class="bag-card">
                        <img src="{{ asset('img/Products/Shoes/' . $shoe->Name . '.jpg') }}" alt="{{ $shoe->Name }}" style="width:100%; height:150px; object-fit:cover; border-radius:8px;">
                        <h3>{{ $shoe->Name }}</h3>
                        <p><strong>Price:</strong> ₱{{ number_format($shoe->SRP, 2) }}</p>
                        <a href="javascript:void(0);" onclick="addToCart('shoe', {{ $shoe->ShoeID }})" class="add-to-cart-btn">
                            <img src="/img/Icons/AddToCart.png" alt="Add to Cart" style="width:20px; vertical-align:middle;">
                        </a>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <div class="badminton-container">
            <h2 class="title1">New Badminton Collection</h2>
            <div class="slider-container">
                @foreach($bads as $bad)
                <a href="{{ route('products.badView', ['name' => $bad->Name]) }}" style="text-decoration:none; color:inherit;">
                    <div class="bag-card">
                        <img src="{{ asset('img/Products/Rackets/' . $bad->Name . '.jpg') }}" alt="{{ $bad->Name }}" style="width:100%; height:150px; object-fit:cover; border-radius:8px;">
                        <h3>{{ $bad->Name }}</h3>
                        <p><strong>Price:</strong> ₱{{ number_format($bad->SRP, 2) }}</p>
                        @if($bad->RC)
                            <span class="badge">RC</span>
                        @endif
                        @if($bad->SC)
                            <span class="badge">SC</span>
                        @endif
                        <a href="javascript:void(0);" onclick="addToCart('bad', {{ $bad->BadID }})" class="add-to-cart-btn">
                            <img src="/img/Icons/AddToCart.png" alt="Add to Cart" style="width:20px; vertical-align:middle;">
                        </a>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <div class="add-container">
            <img class="adds" src="/img/adds/adds2.png" alt="adds2">
        </div>

        <div class="apparel-container">
            <h2 class="title1">New Apparel Collection</h2>
            <div class="slider-container">
            @foreach($apparels as $apparel)
            <a href="{{ route('products.appView', ['name' => $apparel->Name]) }}" style="text-decoration:none; color:inherit;">
                <div class="bag-card">
                <img src="{{ asset('img/Products/Apparel/' . $apparel->Name . '.jpg') }}" alt="{{ $apparel->Name }}" style="width:100%; height:150px; object-fit:cover; border-radius:8px;">
                <h3>{{ $apparel->Name }}</h3>
                <p><strong>Price:</strong> ₱{{ number_format($apparel->SRP, 2) }}</p>
                <a href="javascript:void(0);" onclick="addToCart('apparel', {{ $apparel->AppID }})" class="add-to-cart-btn">
                    <img src="/img/Icons/AddToCart.png" alt="Add to Cart" style="width:20px; vertical-align:middle;">
                </a>
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
    async function updateCartCount() {
        try {
            const res = await fetch('/cart/count');
            const data = await res.json();
            document.getElementById('cart-count').textContent = `(${data.count})`;
        } catch (err) {
            console.error('Failed to fetch cart count:', err);
        }
    }

    // ...existing code...
    async function addToCart(type, productId) {
        try {
            const res = await fetch(`/cart/add/${type}/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            if (res.ok) {
                await updateCartCount();
            } else {
                alert('Failed to add to cart.');
            }
        } catch (err) {
            console.error('Error:', err);
        }
    }
// ...existing code...
    </script>
    </body>
</html>
