<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'user_id', 'evaluation', 'pros', 'cons',
    ];
    
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function userfeedback()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}