<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'code',
        'quantity',
        'average_price',
        'status',
        'user_id'
    ];
}
