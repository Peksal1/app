<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = ["work_name", "file_path", "description", "category", "size", "paint", "canvas", "price"];

    public function portfolio_collections()
    {
        return $this->belongsTo(Collection::class);
    }
}
