<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessoriesProduct extends Model
{
    protected $table = 'acc_product';
    protected $primaryKey = 'AccID';
    public $timestamps = false;

    protected $fillable = [
        'Name', 'SRP', 'Stock'
    ];
}

