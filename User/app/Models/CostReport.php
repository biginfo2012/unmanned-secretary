<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'report_date', 'report_count', 'deleted_at'
    ];
}
