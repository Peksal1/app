<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $fillable = [
        'completion',
        'accepted',
        'file_path',
        'text',
        'user_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function userorders()
    {
        return $this->belongsTo(User::class,'name');
    }
}
