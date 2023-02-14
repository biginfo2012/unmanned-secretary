<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'shop_id', 'pay_date', 'total', 'percent', 'content', 'note'
    ];
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function shop(){
        return $this->hasOne(Shop::class, 'id', 'shop_id');
    }
}
