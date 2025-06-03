<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BadProduct extends Model
{
    protected $table = 'bad_product';
    protected $primaryKey = 'BadID';
    public $timestamps = false;

    protected $fillable = [
        'Name', 'SRP'
    ];
}
