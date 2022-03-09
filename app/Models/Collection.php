<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = ["image", "description", "name", "start_date", "end_date"];

    public function collection_portfolio()
    {
        return $this->hasMany(Portfolio::class);
    }
}
