<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Models\Group;
use App\Services\CoinMarketAPIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoinMarketController extends Controller
{
    /**
     * Retorna todas as moedas.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCoins(Request $request)
    {
        try {
            $request->validate([
                'sort_by' => 'string|in:name,price_usd',
                'sort_direction' => 'string|in:asc,desc',
            ]);

            $sortBy = $request->query('sort_by', 'name'); 
            $sortDirection = $request->query('sort_direction', 'asc'); 
            $coins = Coin::orderBy($sortBy, $sortDirection)->get();

            return response()->json($coins);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Erro ao recuperar as moedas.'], 500);
        }
    }

    /**
     * Retorna todos os grupos.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGroups()
    {
        try {
            $groups = Group::all();
            return response()->json($groups);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Erro ao recuperar os grupos.'], 500);
        }
    }

    /**
     * Cria um novo grupo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createGroup(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
            ]);

            $group = Group::create($request->all());
            return response()->json($group, 201);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Erro ao criar o grupo.'], 500);
        }
    }

    /**
     * Exibe o grupo especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function readGroup($id)
    {
        try {
            $group = Group::findOrFail($id);
            return response()->json($group);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Grupo não encontrado.'], 404);
        }
    }

    /**
     * Atualiza o grupo especificado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateGroup(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
            ]);

            $group = Group::findOrFail($id);
            $group->update($request->all());
            return response()->json($group, 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Erro ao atualizar o grupo.'], 500);
        }
    }

    /**
     * Remove o grupo especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteGroup($id)
    {
        try {
            $group = Group::findOrFail($id);
            $group->delete();
            return response()->json(null, 204);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Erro ao excluir o grupo.'], 500);
        }
    }

    /**
     * Faz uma requisição para a API externa e preenche a tabela de coins com os dados.
     *
     * @param  \App\Services\CoinMarketAPIService  $externalAPIService
     * @return \Illuminate\Http\Response
     */
    public function fetchAndFillCoins(CoinMarketAPIService $externalAPIService)
    {
        try {
            $externalAPIService->fetchAndFillCoins();
            return response()->json(['message' => 'Dados da API externa foram preenchidos com sucesso.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
