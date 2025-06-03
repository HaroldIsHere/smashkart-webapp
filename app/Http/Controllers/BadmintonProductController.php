<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BadProduct;

class BadmintonProductController extends Controller
{
    public function index()
    {
        $bads = BadProduct::all();  // Fetch from the database
        return view('welcome', compact('bads')); // Pass to welcome.blade.php
    }
}
