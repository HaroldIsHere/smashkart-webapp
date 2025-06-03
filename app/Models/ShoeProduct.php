<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShoeProduct extends Model
{
    protected $table = 'shoe_product';
    protected $primaryKey = 'ShoeID';
    public $timestamps = false;

    protected $fillable = [
        'Name', 'SRP', 'Size', 'Material', 'Midsole', 'Upper', 'Stock'
    ];
}

