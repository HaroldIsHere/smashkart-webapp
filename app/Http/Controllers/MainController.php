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

    public function addToCart(Request $request, $type, $id)
    {
        $categoryNames = [
            'bag' => 'Bag',
            'bad' => 'Rackets',
            'shoe' => 'Shoes',
            'accessory' => 'Accessories',
            'accessories' => 'Accessories',
            'apparel' => 'Apparel'
        ];

        // Determine the model and ID property based on the type
        switch (strtolower($type)) {
            case 'bag':
                $product = BagProduct::find($id);
                $idField = 'BagID';
                break;
            case 'bad':
                $product = BadProduct::find($id);
                $idField = 'BadID';
                break;
            case 'shoe':
                $product = ShoeProduct::find($id);
                $idField = 'ShoeID';
                break;
            case 'accessory':
            case 'accessories':
                $product = AccessoriesProduct::find($id);
                $idField = 'AccessoryID';
                break;
            case 'apparel':
                $product = ApparelProduct::find($id);
                $idField = 'AppID';
                break;
            default:
                return response()->json(['success' => false, 'message' => 'Invalid product type.']);
        }

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.']);
        }

        $cart = session('cart', []);
        $found = false;
        foreach ($cart as &$item) {
            // Check type, then name, then id
            if (
                isset($item['type'], $item['name'], $item['id']) &&
                $item['type'] === $type &&
                $item['name'] === $product->Name &&
                $item['id'] == $product->{$idField}
            ) {
                $item['quantity'] += $request->input('quantity', 1);
                $found = true;
                break;
            }
        }
        unset($item);

        if (!$found) {
            $cart[] = [
                'id' => $product->{$idField},
                'name' => $product->Name,
                'price' => $product->SRP,
                'quantity' => $request->input('quantity', 1),
                'category' => ucfirst($type),
                'type' => $type,
            ];
        }

        session(['cart' => $cart]);

        return response()->json([
            'success' => true,
            'cartCount' => count($cart)
        ]);
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