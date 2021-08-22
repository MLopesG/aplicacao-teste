<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CotacaoFreteController;

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

Route::get('cotacao', [CotacaoFreteController::class, 'ListarImpostos']);
Route::post('cotacao', [CotacaoFreteController::class, 'CadastroCotacaoFrete']);
Route::put('cotacao', [CotacaoFreteController::class, 'SimularCotacaoFrete']);