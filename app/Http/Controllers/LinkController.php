<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BagProduct;
use App\Models\BadProduct;
use App\Models\ShoeProduct;
use App\Models\AccessoriesProduct;
use App\Models\ApparelProduct;
use App\Models\Transaction;


class LinkController extends Controller
{
    public function index()
    {
        return view('payment.cart');
    }

    public function cart()
    {
        return view('payment.cart');
    }

    public function count()
    {
        $cart = session('cart', []);
        return response()->json(['count' => count($cart)]);
    }

    public function mini()
    {
        $cart = session('cart', []);
        return view('mini-cart', compact('cart'))->render();
    }

        public function cartSummary()
    {
        $cart = session('cart', []);
        $totalItems = 0;
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalItems += $item['quantity'];
            $totalPrice += $item['quantity'] * $item['price'];
        }
        return response()->json([
            'totalItems' => $totalItems,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function checkout()
    {
    $cart = session('cart', []); // or however you store your cart
    return view('payment.checkout', compact('cart'));
    }

    public function processCheckout(Request $request)
    {
    // ...validate and process payment...

    $cart = session('cart', []); // or however you store the cart
    $total = collect($cart)->sum(function($item) {
        return $item['quantity'] * $item['price'];
    });

    Transaction::create([
        'user_id' => auth()->id(),
        'cart' => json_encode($cart),
        'total' => $total,
    ]);

    // Optionally clear the cart and redirect to home
    session()->forget('cart');
    return redirect()->route('index')->with('success', 'Transaction completed!');
    }

    public function login()
    {
        return view('User.login');
    }

    public function signup()
    {
        return view('User.signup');
    }

    public function account()
    {
        return view('User.acc');
    }

    public function bag()
    {
        return view('products.bags');
    }
    public function badminton()
    {
        return view('products.rackets');
    }
    public function productView()
    {
        return view('products.productView');
    }
    public function bagView($name)
    {
        $bag = BagProduct::where('Name', $name)->first();
        $bags = BagProduct::all();  
        return view('products.bagView', compact('bag', 'bags')); 
    }
    public function badView($name)
    {
        $bad = BadProduct::where('Name', $name)->first();
        $bads = BadProduct::all();
        return view('products.badView', compact('bad', 'bads'));
    }
    public function accView($name)
    {
        $acc = AccessoriesProduct::where('Name', $name)->first();
        $accs = AccessoriesProduct::all();
        return view('products.accView', compact('acc', 'accs'));
    }
    public function appView($name)
    {
        $apparel = ApparelProduct::where('Name', $name)->first();
        $apparels = ApparelProduct::all();
        return view('products.appView', compact('apparel', 'apparels'));
    }
    public function shoeView($name)
    {
        $shoe = ShoeProduct::where('Name', $name)->first();
        $shoes = ShoeProduct::all();
        return view('products.shoeView', compact('shoe', 'shoes'));
    }
    public function productLibrary($category)
    {
        $products = [];
        $categoryNames = [
            'bag' => 'Bag',
            'rackets' => 'Rackets',
            'shoes' => 'Shoes',
            'accessories' => 'Accessories',
            'apparel' => 'Apparel'
        ];
        $categoryViewRoutes = [
            'bag' => 'bagView',
            'rackets' => 'badView',
            'shoes' => 'shoeView',
            'accessories' => 'accView',
            'apparel' => 'appView'
        ];
        $imageFolder = $category; // Use the category as the image folder name

        switch ($category) {
            case 'bag':
                $products = BagProduct::all();
                break;
            case 'rackets':
                $products = BadProduct::all();
                break;
            case 'shoes':
                $products = ShoeProduct::all();
                break;
            case 'accessories':
                $products = AccessoriesProduct::all();
                break;
            case 'apparel':
                $products = ApparelProduct::all();
                break;
        }
        $activeCategory = $category;
        $categories = $categoryNames;
        $activeCategoryName = $categoryNames[$category] ?? 'default.jpg';
        $categoryViewRoute = $categoryViewRoutes[$category] ?? null;
        return view('products.productLibrary', compact('products', 'activeCategory', 'categories', 'activeCategoryName', 'imageFolder', 'categoryViewRoute'));
    }

    
    public function dashboard(Request $request)
    {
        $bads = BadProduct::all();
        $bags = BagProduct::all();
        $shoes = ShoeProduct::all();
        $accessories = AccessoriesProduct::all();
        $apparels = ApparelProduct::all();
        $month = $request->input('salesMonth', now()->format('Y-m'));
        $start = \Carbon\Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $end = \Carbon\Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        $deliveredTransactions = \App\Models\Transaction::where('status', 'complete')
            ->whereBetween('created_at', [$start, $end])
            ->get();

        // Group by day for the selected month
        $salesPerDay = $deliveredTransactions->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
        })->map(function($group) {
            return $group->sum('total');
        });

        // Prepare labels and data for the chart
        $daysInMonth = [];
        $salesData = [];
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $daysInMonth[] = $date->format('Y-m-d');
            $salesData[] = $salesPerDay->get($date->format('Y-m-d'), 0);
        }

        // Total sales for the year (delivered only)
        $totalSalesYear = \App\Models\Transaction::where('status', 'complete')
            ->whereYear('created_at', now()->year)
            ->sum('total');

        // Orders per month for the year (all statuses)
        $ordersPerMonthLabels = [];
        $ordersPerMonthData = [];
        for ($m = 1; $m <= 12; $m++) {
            $label = date('F', mktime(0, 0, 0, $m, 1));
            $ordersPerMonthLabels[] = $label;
            $ordersPerMonthData[] = \App\Models\Transaction::whereYear('created_at', now()->year)
                ->whereMonth('created_at', $m)
                ->count();
        }

        // Get sales per month for the current year (delivered only)
        $salesPerMonthLabels = [];
        $salesPerMonthData = [];
        for ($m = 1; $m <= 12; $m++) {
            $label = date('F', mktime(0, 0, 0, $m, 1));
            $salesPerMonthLabels[] = $label;
            $salesPerMonthData[] = \App\Models\Transaction::where('status', 'complete')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', $m)
                ->sum('total');
        }

        // Pending orders
        $pendingOrders = \App\Models\Transaction::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $totalUsers = \App\Models\User::count();
        $totalPendingOrders = \App\Models\Transaction::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'bads', 'bags', 'shoes', 'accessories', 'apparels',
            'totalSalesYear', 'ordersPerMonthLabels', 'ordersPerMonthData', 'pendingOrders',
            'totalUsers', 'totalPendingOrders'
        ))->with([
            'salesPerMonthLabels' => $daysInMonth,
            'salesPerMonthData' => $salesData,
        ]);
    }

    public function users()
    {
        $users = \App\Models\User::all();
        return view('admin.users', compact('users'));
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function reports()
    {
        return view('admin.reports');
    }

    public function adminPage()
    {
        return view('admin.adminPage');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

    public function history()
    {
    $transactions = \App\Models\Transaction::where('user_id', auth()->id())->latest()->get();
    return view('payment.history', compact('transactions'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,on_the_way,complete',
        ]);
        $transaction->status = $request->input('status');
        $transaction->save();

        return back()->with('success', 'Order status updated!');
    }

    public function orderManagement()
    {
        $transactions = \App\Models\Transaction::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.orderManagement', compact('transactions'));
    }

    public function reportInventory()
    {
        $bads = \App\Models\BadProduct::all();
        $bags = \App\Models\BagProduct::all();
        $shoes = \App\Models\ShoeProduct::all();
        $accessories = \App\Models\AccessoriesProduct::all();
        $apparels = \App\Models\ApparelProduct::all();

        return view('admin.reportInventory', compact('bads', 'bags', 'shoes', 'accessories', 'apparels'));
    }

        public function updateQuantity(Request $request, $name)
    {
        $cart = session('cart', []);
        foreach ($cart as &$item) {
            if ($item['name'] === $name) {
                $item['quantity'] = max(1, (int)$request->quantity);
                $item['subtotal'] = $item['quantity'] * $item['price'];
                break;
            }
        }
        session(['cart' => $cart]);
        // Return new subtotal for this item
        foreach ($cart as $item) {
            if ($item['name'] === $name) {
                return response()->json(['subtotal' => $item['subtotal']]);
            }
        }
        return response()->json(['subtotal' => 0]);
    }

}
