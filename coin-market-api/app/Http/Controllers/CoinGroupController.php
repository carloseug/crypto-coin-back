<?php

namespace App\Http\Controllers;

use App\Models\CoinGroup;
use Illuminate\Http\Request;

class CoinGroupController extends Controller
{
    public function index()
    {
        try {
            $coinGroups = CoinGroup::all();
            return response()->json($coinGroups);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Erro ao listar os grupos de moedas.'], 500);
        }
    }
    
    public function create(Request $request)
    {
        try {
            $request->validate([
                'coin_id' => 'required|integer',
                'group_id' => 'required|integer',
            ]);

            $coinGroup = CoinGroup::create($request->all());
            return response()->json($coinGroup, 201);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Erro ao criar o grupo de moedas.'], 500);
        }
    }

    public function read($id)
    {
        try {
            $coinGroup = CoinGroup::findOrFail($id);
            return response()->json($coinGroup);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Grupo de moedas não encontrado.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'coin_id' => 'required|integer',
                'group_id' => 'required|integer',
            ]);

            $coinGroup = CoinGroup::findOrFail($id);
            $coinGroup->update($request->all());
            return response()->json($coinGroup);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Erro ao atualizar o grupo de moedas.'], 500);
        }
    }

    public function delete($id)
    {
        try {
            $coinGroup = CoinGroup::findOrFail($id);
            $coinGroup->delete();
            return response()->json(['message' => 'Grupo de moedas deletado com sucesso.']);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Erro ao deletar o grupo de moedas.'], 500);
        }
    }
}
