<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Digital_purchase extends Model
{
    use HasFactory;

    protected $fillable  = [
        'uuid',
        'digital_painting_id',
        'Price',
        'status',
        'is_paid',
        'user_id',
        'tnx_id',
    ];
    public function userDigitalPurchases()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function painting()
    {
        return $this->belongsTo(Digital_painting::class, 'digital_painting_id');
    }
}
