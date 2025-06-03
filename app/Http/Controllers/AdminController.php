<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AdminMiddleware;

class AdminController extends Controller
{
    public function __construct()
    {
    $this->middleware(\App\Http\Middleware\AdminMiddleware::class);
    }
}