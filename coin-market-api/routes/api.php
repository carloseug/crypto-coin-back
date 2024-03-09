<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoinMarketController as CoinMarketController;
use App\Http\Controllers\CoinGroupController as CoinGroupController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/*
* CoinMarketController Routes
*/
Route::get('/coins', [CoinMarketController::class, 'indexCoins']);
Route::get('/groups', [CoinMarketController::class, 'indexGroups']);
Route::post('/groups', [CoinMarketController::class, 'createGroup']);
Route::get('/groups/{id}', [CoinMarketController::class, 'readGroup']);
Route::put('/groups/{id}', [CoinMarketController::class, 'updateGroup']);
Route::delete('/groups/{id}', [CoinMarketController::class, 'deleteGroup']);
Route::get('/fetch-coins', [CoinMarketController::class, 'fetchAndFillCoins']);

/*
* CoinGroupController Routes
*/

Route::get('/coin-groups', [CoinGroupController::class, 'index']);
Route::post('/coin-groups', [CoinGroupController::class, 'create']);
Route::get('/coin-groups/{id}', [CoinGroupController::class, 'read']);
Route::put('/coin-groups/{id}', [CoinGroupController::class, 'update']);
Route::delete('/coin-groups/{id}', [CoinGroupController::class, 'delete']);
