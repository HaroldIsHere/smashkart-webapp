<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApparelProduct extends Model
{
    protected $table = 'apparel_product';
    protected $primaryKey = 'AppID';
    public $timestamps = false;

    protected $fillable = [
        'Name', 'SRP', 'Size', 'Material', 'Color', 'Stock'
    ];
}

