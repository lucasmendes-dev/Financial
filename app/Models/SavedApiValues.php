<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedApiValues extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol',
        'regular_market_price',
        'regular_market_change_percent',
        'regular_market_change',
        'logo_url',
        'user_id'
    ];
}
