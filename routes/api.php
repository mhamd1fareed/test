<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\SolveController;


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


Route::post('add_project',[ProjectController::class,'store']);
Route::post('add_currency',[CurrencyController::class,'store']);
Route::post('add_cost',[CostController::class,'store']);

Route::get('convert',[SolveController::class,'convert']);
Route::get('cost_in_usd',[SolveController::class,'costInUSD']);
Route::get('cost_any_corrency',[SolveController::class,'costInAnyCurrency']);
