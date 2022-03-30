<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_purchases extends Model
{
    use HasFactory;

    protected $fillable  = [
        'uuid',
        'order_id',
        'Price',
        'status',
        'is_paid',
        'user_id',
        'tnx_id',
    ];
    
}
