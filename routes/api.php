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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('register','Api\AuthController');
Route::post('register','Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');
Route::middleware('auth:api')->prefix('user')->group(function () {

    Route::post('update/password', 'Api\AuthController@updatePassword');
    Route::post('update/profile', 'Api\AuthController@updateProfile');

    Route::put('category/{CategoryId}/restore', 'Api\CategoryController@restore');

    Route::delete('delete', 'Api\AuthController@delete');

    Route::resource('category','Api\CategoryController');
    Route::resource('task','Api\TaskController');
});


