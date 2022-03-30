<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'surname',
        'phone_number',
        'avatar',
        'display_name',
        'email',
        'password',
        'role',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function contact()
    {
        return $this->hasOne(Contacts::class, 'id', 'contact_id');
    }
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
    public function purchases()
    {
        return $this->hasMany(Purchases::class);
    }
    public function digitalPurchases()
    {
        return $this->hasMany(Digital_purchase::class);
    }
    public function posts()
    {
        return $this->hasMany(qna_post::class);
    }

    public function topics()
    {
        return $this->hasMany(qna_topics::class);
    }
    public function user_orders()
    {
        return $this->hasMany(Orders::class);
    }
    public function user_order_messages()
    {
        return $this->hasMany(Order_message::class);
    }
    public function getId()
{
  return $this->id;
}
}
