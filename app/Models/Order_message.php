<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_message extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
