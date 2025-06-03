<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link href="/css/acc.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Account Page</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
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

  <div class="account-section">
    <div class="account-info">
      <h2 class="account-title">ACCOUNT</h2>
      <div class="profile-name">{{ Auth::user()->name }}</div>
    </div>
    <div class="details-form">
      <label for="name" class="form-label">Name:</label>
      <input type="text" id="name" class="form-input" value="{{ Auth::user()->name }}" readonly>

      <label for="email" class="form-label">Email:</label>
      <input type="email" id="email" class="form-input" value="{{ Auth::user()->email }}" readonly>
    </div>
    <div class="edit-info-btn-container">
      <a href="{{ route('profile.edit') }}" class="edit-info-btn">Edit Information</a>
    </div>
  </div>

  {{-- Transaction History Section --}}
  <div class="transaction-history-section" style="margin:40px 0;">
    <h2 style="margin-bottom:18px;">Transaction History</h2>
    @php
      $transactions = \App\Models\Transaction::where('user_id', Auth::id())->latest()->get();
    @endphp
    @if($transactions->count())
      <table style="width:100%; border-collapse:collapse; background:#fff;">
        <thead>
          <tr style="background:#f4f4f4;">
            <th style="padding:8px; border:1px solid #ddd;">Date</th>
            <th style="padding:8px; border:1px solid #ddd;">Products</th>
            <th style="padding:8px; border:1px solid #ddd;">Total</th>
            <th style="padding:8px; border:1px solid #ddd;">Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($transactions as $transaction)
            <tr>
              <td style="padding:8px; border:1px solid #ddd;">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
              <td style="padding:8px; border:1px solid #ddd;">
                <ul style="margin:0; padding-left:18px;">
                  @foreach(json_decode($transaction->cart, true) as $item)
                    <li>{{ $item['name'] }} (x{{ $item['quantity'] }})</li>
                  @endforeach
                </ul>
              </td>
              <td style="padding:8px; border:1px solid #ddd;">₱{{ number_format($transaction->total, 2) }}</td>
              <td style="padding:8px; border:1px solid #ddd;">
                @if($transaction->status === 'complete')
                    <span style="color:green;font-weight:bold;">Complete</span>
                @elseif($transaction->status === 'on_the_way')
                    <span style="color:#007bff;font-weight:bold;">On the Way</span>
                @else
                    <span style="color:orange;font-weight:bold;">Pending</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <div style="padding:16px; background:#fff; border-radius:8px; box-shadow:0 1px 4px rgba(0,0,0,0.06);">
        No transactions found.
      </div>
    @endif
  </div>

</body>
</html>
