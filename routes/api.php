<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/getCities/{id}', [\App\Http\Controllers\QueryController::class,
    'getCities']);
Route::get('/getRegions', [\App\Http\Controllers\QueryController::class,
    'getRegions']);
Route::get('/getDistricts/{fias_code}', [\App\Http\Controllers\QueryController::class,
    'getDistricts']);
Route::get('/getStreets/{cityCode}', [\App\Http\Controllers\QueryController::class,
    'getStreets']);
Route::get('/getHouses/{streetId}', [\App\Http\Controllers\QueryController::class,
    'getHouses']);
Route::get('/district', [\App\Http\Controllers\TableSeparatorController::class,
    'fillDistrictTable']);
Route::get('/city', [\App\Http\Controllers\TableSeparatorController::class,
    'fillCitiesTable']);
Route::get('/street', [\App\Http\Controllers\TableSeparatorController::class,
    'fillStreetsTable']);


