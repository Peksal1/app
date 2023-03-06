<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    use HasFactory;
    protected $fillable  = [
        'name',
        'symbol',
        'usd_price',
        'total_supply',
        'max_supply',
        'date_added',
    ];
}