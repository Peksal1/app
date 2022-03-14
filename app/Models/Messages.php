<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $fillable = [
        'name',
        'Email',
        'message',
        'subject',
        'phone_number',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function usermessages()
    {
        return $this->belongsTo(User::class,'name');
    }
  
       
}
