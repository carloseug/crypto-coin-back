<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Coin;

class CoinMarketAPIService
{
    /**
     * Faz uma requisição para a API externa e preenche a tabela de coins com os dados.
     *
     * @return void
     */
    public function fetchAndFillCoins()
    {
        try {
            $apiUrl = env('COINMARKET_API_URL');
            $apiKey = env('COINMARKET_API_KEY');
            $response = Http::withHeaders([
                'X-CMC_PRO_API_KEY' => $apiKey,
                'Accept' => '*/*',
            ])->get($apiUrl);

            if ($response->successful()) {
                $data = $response->json();

                $this->fillCoins($data['data']);
            } else {
                throw new \Exception('Erro ao obter resposta da API externa.');
            }
        } catch (\Throwable $e) {
            report($e);
            throw new \Exception('Erro ao preencher a tabela de coins com os dados da API externa.');
        }
    }

    /**
     * Preenche a tabela de coins com os dados da resposta da API externa.
     *
     * @param  array  $coinsData
     * @return void
     */
    protected function fillCoins(array $coinsData)
    {
        try {
            foreach ($coinsData as $coinData) {
                Coin::updateOrCreate(
                    ['id' => $coinData['id']],
                    [
                        'name' => $coinData['name'],
                        'market_cap' => $coinData['quote']['USD']['market_cap'],
                        'volume_24h' => $coinData['quote']['USD']['volume_24h'],
                        'change_24h' => $coinData['quote']['USD']['volume_change_24h'],
                        'price_usd' => $coinData['quote']['USD']['price'],
                    ]
                );
            }
        } catch (\Throwable $e) {
            report($e);
            throw new \Exception('Erro ao preencher a tabela de coins com os dados da API externa.');
        }
    }
}
