<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BadProduct;
use App\Models\BagProduct;
use App\Models\ShoeProduct;
use App\Models\AccessoriesProduct;
use App\Models\ApparelProduct;

class MainController extends Controller
{   
    public function index()
    {
        $bads = BadProduct::all();  // Fetch from the database
        $bags = BagProduct::all();  // Fetch from the database
        $shoes = ShoeProduct::all(); // Fetch from the database
        $accessories = AccessoriesProduct::all(); // Fetch from the database
        $apparels = ApparelProduct::all(); // Fetch from the database
        return view('welcome', compact('bads', 'bags', 'shoes', 'accessories', 'apparels')); // Pass to welcome.blade.php
    }

    public function addToCart($type, $id, Request $request)
    {
        $categoryNames = [
            'bag' => 'Bag',
            'bad' => 'Rackets',
            'shoe' => 'Shoes',
            'accessory' => 'Accessories',
            'accessories' => 'Accessories',
            'apparel' => 'Apparel'
        ];

        // Determine the model based on the type
        switch (strtolower($type)) {
            case 'bag':
                $product = BagProduct::find($id);
                break;
            case 'bad':
                $product = BadProduct::find($id);
                break;
            case 'shoe':
                $product = ShoeProduct::find($id);
                break;
            case 'accessory':
            case 'accessories':
                $product = AccessoriesProduct::find($id);
                break;
            case 'apparel':
                $product = ApparelProduct::find($id);
                break;
            default:
                $product = null;
        }

        if (!$product) {
            // Return JSON for AJAX, redirect for normal requests
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Product not found.']);
            }
            return redirect()->back()->with('error', 'Product not found.');
        }

        $cart = session('cart', []);
        $cartKey = $type . '_' . $id;
        $quantity = (int) $request->input('quantity', 1);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                'id' => $product->getKey(),
                'name' => $product->Name,
                'price' => $product->SRP,
                'quantity' => $quantity,
                'type' => $type,
                'category' => $categoryNames[strtolower($type)] ?? ucfirst($type),
            ];
        }

        session()->put('cart', $cart);

        // Return JSON for AJAX, redirect for normal requests
        if ($request->ajax()) {
            // Count total items (sum of quantities) for cart count
            $cartCount = array_sum(array_column($cart, 'quantity'));
            return response()->json([
                'success' => true,
                'cartCount' => $cartCount,
                'message' => 'Product added to cart successfully!'
            ]);
        }

        return redirect()->route('index')->with('success', 'Product added to cart successfully!');
    }

    public function removeByName($name)
{
    $cart = session('cart', []);

    foreach ($cart as $key => $item) {
        if (isset($item['name']) && $item['name'] === $name) {
            unset($cart[$key]);
            session(['cart' => $cart]);
            return response()->json(['success' => true, 'message' => "Item '$name' removed from cart."]);
        }
    }

    return response()->json(['success' => false, 'message' => "Item '$name' not found."], 404);
}

}