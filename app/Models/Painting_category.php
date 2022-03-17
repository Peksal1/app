<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Painting_category extends Model
{
    use HasFactory;
    protected $fillable = [
        'category',
    ];

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }
    public function shops()
    {
        return $this->hasMany(Shop::class);
    }
}
