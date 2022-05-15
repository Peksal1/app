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
        'tracking_number',
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function store()
    {
        return $this->belongsTo(Shop::class, 'product_id');
    }
    public function shipping()
    {
        return $this->hasOne(Shipping::class,'purchase_id','uuid');
    }
}
