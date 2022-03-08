<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'work_name',
        'description',
        'size',
        'paint',
        'canvas',
        'category',
        'file_path',
        'price_in_eur',
    ];
}
