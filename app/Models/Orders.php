<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $fillable = [
        'completion',
        'accepted',
        'file_path',
        'text',
        'user_id',
        'size_id',
        'paint_id',
        'canvas_id',
        'price',
        'orientation',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function userorders()
    {
        return $this->belongsTo(User::class,'name');
    }
    public function user_order_messages()
    {
        return $this->hasMany(Order_message::class);
    }
}
