<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CoinGroup;

class CoinGroupSeeder extends Seeder
{
    public function run()
    {
        CoinGroup::create([
            'coin_id' => 1,
            'group_id' => 1,
        ]);

        CoinGroup::create([
            'coin_id' => 2,
            'group_id' => 1,
        ]);

        // Adicione mais dados conforme necessário
    }
}
