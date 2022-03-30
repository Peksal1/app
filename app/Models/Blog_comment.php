<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog_comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'message',
        'user_id',
        'blog_id',
    ];

    public function userComment()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function blogComment()
    {
        return $this->belongsTo(Blog::class,'blog_id');
    }
}
