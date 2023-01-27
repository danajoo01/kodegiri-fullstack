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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login', [ 'as' => 'login', 'uses' => 'App\Http\Controllers\AuthController@login']);
Route::group([
    'middleware' => 'auth:api',
], function () {
        Route::get('/logout', 'App\Http\Controllers\AuthController@logout');
        Route::post('/doc', 'App\Http\Controllers\DocController@create');
        Route::put('doc/{id}', 'App\Http\Controllers\DocController@update')->where('id', '[0-9]+');
        Route::get('/doc', 'App\Http\Controllers\DocController@index');
        Route::get('/doc/{id}', 'App\Http\Controllers\DocController@show')->where('id', '[0-9]+');   
        Route::delete('/doc/{id}', 'App\Http\Controllers\DocController@delete');

        // Route::delete("/delete/{id}",[TodoController::class,"delete"]);
});