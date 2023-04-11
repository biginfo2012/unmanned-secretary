<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject', 'assistant', 'code', 'keyword', 'status', 'type', 'user_id'
    ];
    public function tax(){
        return $this->hasOne(TaxType::class, 'id', 'type');
    }
}
