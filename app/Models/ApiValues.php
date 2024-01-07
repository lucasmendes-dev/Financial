<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiValues extends Model
{
    use HasFactory;

    private $protected = [
        'code',
        'last_saved_price'
    ];
}
