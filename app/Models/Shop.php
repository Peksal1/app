<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'work_name',
        'description',
        'size_id',
        'paint_id',
        'canvas_id',
        'orientation',
        'category_id',
        'is_bought',
        'file_path',
        'price_in_eur',
    ];
    public function category()
    {
        return $this->belongsTo(Painting_category::class, 'category_id');
    }
    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }
    public function canvas()
    {
        return $this->belongsTo(Canvas::class, 'canvas_id');
    }
    public function paint()
    {
        return $this->belongsTo(Paint::class, 'paint_id');
    }
}
