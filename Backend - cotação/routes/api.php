<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CotacaoFreteController;
use App\Http\Controllers\TransportadoraController;

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

// Controller cotação
Route::get('cotacao/uf', [CotacaoFreteController::class, 'ListarUFS']);
Route::get('cotacao', [CotacaoFreteController::class, 'ListarImpostos']);
Route::post('cotacao', [CotacaoFreteController::class, 'CadastroCotacaoFrete']);
Route::put('cotacao', [CotacaoFreteController::class, 'SimularCotacaoFrete']);
// Controller transportadoras
Route::get('transportadoras', [TransportadoraController::class, 'ListarTransportadoras']);