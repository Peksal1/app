<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Digital_painting extends Model
{
    protected $fillable = [
        'portfolio_id',
        'price',
        'resolution',
        'image',
    ];
    public function digitalPortfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
 
}
