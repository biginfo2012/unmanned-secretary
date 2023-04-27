<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject', 'assistant', 'code', 'keyword_id', 'status', 'type', 'type_id', 'user_id'
    ];
    public function tax(){
        return $this->hasOne(TaxType::class, 'id', 'type');
    }
    public function keyword(){
        return $this->hasOne(AccountKeyword::class, 'id', 'keyword_id');
    }
}
