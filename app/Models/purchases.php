<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchases extends Model
{
    use HasFactory;

    protected $fillable  = [
        'uuid',
        'product_id',
        'Price',
        'status',
        'is_paid',
        'user_id',
        'tnx_id',
    ];
}
