<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Online Payment Page</title>
  <link rel="stylesheet" href="/css/checkout.css" />
</head>

<body>
  <main class="container">
    <form action="{{ route('checkout.process') }}" method="post" novalidate>
      @csrf
      <div class="row">
        <!-- Billing Address Column -->
        <div class="col">
          <h3 class="title">Billing Address</h3>

          <div class="inputBox">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name" required />
          </div>

          <div class="inputBox">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter email address" required />
          </div>

          <div class="inputBox">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" placeholder="Enter address" required />
          </div>

          <div class="inputBox">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" placeholder="Enter city" required />
          </div>

          <div class="flex">
            <div class="inputBox">
              <label for="state">State:</label>
              <input type="text" id="state" name="state" placeholder="Enter state" required />
            </div>

            <div class="inputBox">
              <label for="zip">Zip Code:</label>
              <input type="text" id="zip" name="zip" placeholder="123 456" pattern="\d{5,6}" required />
            </div>
          </div>
        </div>

        <!-- Payment Column -->
        <div class="col">
          <h3 class="title">Payment</h3>

          <div class="inputBox">
            <label>Cards Accepted:</label>
            <img src="https://media.geeksforgeeks.org/wp-content/uploads/20240715140014/Online-Payment-Project.webp"
              alt="Accepted credit cards" />
          </div>

          <div class="inputBox">
            <label for="cardName">Name on Card:</label>
            <input type="text" id="cardName" name="cardName" placeholder="Enter cardholder name" required />
          </div>

          <div class="inputBox">
            <label for="cardNum">Credit Card Number:</label>
            <input type="text" id="cardNum" name="cardNum" placeholder="1111-2222-3333-4444"
              pattern="\d{4}-\d{4}-\d{4}-\d{4}" maxlength="19" required />
          </div>

          <div class="inputBox">
            <label for="expMonth">Exp Month:</label>
            <select id="expMonth" name="expMonth" required>
              <option value="">Choose month</option>
              <option value="January">January</option>
              <option value="February">February</option>
              <option value="March">March</option>
              <option value="April">April</option>
              <option value="May">May</option>
              <option value="June">June</option>
              <option value="July">July</option>
              <option value="August">August</option>
              <option value="September">September</option>
              <option value="October">October</option>
              <option value="November">November</option>
              <option value="December">December</option>
            </select>
          </div>

          <div class="flex">
            <div class="inputBox">
              <label for="expYear">Exp Year:</label>
              <select id="expYear" name="expYear" required>
                <option value="">Choose year</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
              </select>
            </div>

            <div class="inputBox">
              <label for="cvv">CVV:</label>
              <input type="text" id="cvv" name="cvv" placeholder="123" pattern="\d{3,4}" maxlength="4" required />
            </div>
          </div>
        </div>
      </div>

      @if(isset($cart) && count($cart))
      <h3>Cart Summary</h3>
      <table style="width:100%; border-collapse:collapse; margin-bottom:24px;">
        <thead>
          <tr style="background:#f4f4f4;">
            <th style="padding:8px; border:1px solid #ddd;">Product</th>
            <th style="padding:8px; border:1px solid #ddd;">Quantity</th>
            <th style="padding:8px; border:1px solid #ddd;">Price</th>
            <th style="padding:8px; border:1px solid #ddd;">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          @php $total = 0; @endphp
          @foreach($cart as $item)
          @php $subtotal = $item['quantity'] * $item['price'];
          $total += $subtotal; @endphp
          <tr>
            <td style="padding:8px; border:1px solid #ddd;">{{ $item['name'] }}</td>
            <td style="padding:8px; border:1px solid #ddd;">{{ $item['quantity'] }}</td>
            <td style="padding:8px; border:1px solid #ddd;">${{ number_format($item['price'], 2) }}</td>
            <td style="padding:8px; border:1px solid #ddd;">${{ number_format($subtotal, 2) }}</td>
          </tr>
          @endforeach
          <tr>
            <td colspan="3"
              style="text-align:right; font-weight:bold; padding:8px; border:1px solid #ddd;">Total</td>
            <td style="padding:8px; border:1px solid #ddd; font-weight:bold;">${{ number_format($total, 2) }}</td>
          </tr>
        </tbody>
      </table>
      @endif

      <input type="submit" value="Proceed to Checkout" class="submit_btn" />
    </form>
  </main>

  <script src="index.js"></script>
</body>

</html>
