<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/todos', 'TodosController@index');

    Route::post('/logout','AuthController@logout');
});


Route::post('/login', 'AuthController@login')->name('login');
Route::post('/register', 'AuthController@register')->name('login');

Route::post('/todos', 'TodosController@store');
Route::patch('/todos/{todo}', 'TodosController@update');
Route::patch('/todosCheckAll', 'TodosController@updateAll');
Route::delete('/todos/{todo}', 'TodosController@destroy');
Route::delete('/todosDeleteCompleted', 'TodosController@destroyCompleted');
