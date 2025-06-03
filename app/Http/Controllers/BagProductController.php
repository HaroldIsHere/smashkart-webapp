<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BagProduct;

class BagProductController extends Controller
{
    public function index()
    {
        $bags = BagProduct::all();  // Fetch from the database
        return view('welcome', compact('bags')); // Pass to welcome.blade.php
    }
}
