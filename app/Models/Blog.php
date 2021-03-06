<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'image',
        'blog_category_id',
        'user_id',
    ];
    public function blog_category()
    {
        return $this->belongsTo(Blog_category::class,'blog_category_id');
    }
    public function blog_comments()
    {
        return $this->hasMany(Blog_comment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
