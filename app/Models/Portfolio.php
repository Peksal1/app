<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = ['work_name', 'file_path', 'description', 'category', 'size_id', 'paint_id', 'canvas_id', 'price',];

    public function portfolio_collection()
    {
        return $this->belongsTo(Collection::class);
    }
    public function portfolio_size()
    {
        return $this->belongsTo(Size::class);
    }
    public function portfolio_paint()
    {
        return $this->belongsTo(Paint::class);
    }
    public function portfolio_canvas()
    {
        return $this->belongsTo(Canvas::class);
    }
}
