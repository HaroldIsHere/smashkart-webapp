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

    
    public function dashboard()
    {
        $bads = BadProduct::all();
        $bags = BagProduct::all();
        $shoes = ShoeProduct::all();
        $accessories = AccessoriesProduct::all();
        $apparels = ApparelProduct::all();
        return view('admin.dashboard', compact('bads', 'bags', 'shoes', 'accessories', 'apparels'));
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

    

}
