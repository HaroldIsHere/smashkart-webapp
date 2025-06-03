<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BagProduct extends Model
{
    protected $table = 'bag_product';
    protected $primaryKey = 'BagID';
    public $timestamps = false;

    protected $fillable = [
        'Name', 'SRP', 'Dimensions', 'RC', 'SC', 'OF', 'Material', 'Stock', 'Type'
    ];
}

