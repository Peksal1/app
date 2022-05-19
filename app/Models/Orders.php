<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $fillable = [
        'completion',
        'file_path',
        'uuid',
        'text',
        'user_id',
        'size_id',
        'paint_id',
        'canvas_id',
        'price',
        'orientation',
        'is_paid',
        'tracking',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function userorders()
    {
        return $this->belongsTo(User::class,'name');
    }
    public function user_order_messages()
    {
        return $this->hasMany(Order_message::class);
    }
    public function canvas()
    {
        return $this->belongsTo(Canvas::class,'canvas_id');
    }
    public function paint()
    {
        return $this->belongsTo(Paint::class,'paint_id');
    }
    public function size()
    {
        return $this->belongsTo(Size::class,'size_id');
    }
    public function shipping()
    {
        return $this->hasOne(Shipping::class,'purchase_id','uuid');
    }
}
