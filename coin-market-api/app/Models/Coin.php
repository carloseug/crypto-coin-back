<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'market_cap',
        'price_usd',
        'volume_24h',
        'change_24h',
    ];
}
