<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
    'work_name', 
    'orientation', 
    'file_path', 
    'description', 
    'category_id', 
    'size_id', 
    'collection_id', 
    'paint_id', 
    'canvas_id', 
    'price'
    ];

    public function portfolio_collection()
    {
        return $this->belongsTo(Collection::class, 'collection_id');
    }
    public function portfolio_category()
    {
        return $this->belongsTo(Painting_category::class, 'category_id');
    }
    public function portfolio_size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }
    public function portfolio_paint()
    {
        return $this->belongsTo(Paint::class, 'paint_id');
    }
    public function portfolio_canvas()
    {
        return $this->belongsTo(Canvas::class, 'canvas_id');
    }
    public function digital_paintings()
    {
        return $this->hasMany(Digital_painting::class);
    }
}
