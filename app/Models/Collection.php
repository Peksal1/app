<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = ["image", "description", "name"];

    public function collections_portfolio()
    {
        return $this->hasMany(Portfolio::class);
    }
}
