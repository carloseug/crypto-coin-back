<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coin;

class CoinSeeder extends Seeder
{
    public function run()
    {
        Coin::create([
            'name' => 'Bitcoin',
            'market_cap' => 100000000000,
            'price_usd' => 50000,
            'volume_24h' => 5000000000,
            'change_24h' => 0.05,
        ]);

        Coin::create([
            'name' => 'Ethereum',
            'market_cap' => 50000000000,
            'price_usd' => 2000,
            'volume_24h' => 2000000000,
            'change_24h' => -0.02,
        ]);

        // Adicione mais dados conforme necessário
    }
}
