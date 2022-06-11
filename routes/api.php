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



//AuthController
Route::post('register','Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');


Route::middleware('auth:api')->prefix('user')->group(function () {

//AuthController
    Route::post('update/password', 'Api\AuthController@updatePassword');
    Route::post('update/profile', 'Api\AuthController@updateProfile');
    Route::delete('delete', 'Api\AuthController@delete');

//CategoryController
    Route::resource('category','Api\CategoryController');
    Route::put('category/{CategoryId}/restore', 'Api\CategoryController@restore');

    //TaskController
    Route::resource('task','Api\TaskController');
    Route::put('task/{TaskId}/restore', 'Api\TaskController@restore');
    Route::delete('task/{taskId}', 'Api\TaskController@forceDelete');

    //FileController
    Route::post('file/{TaskId}/uploade','Api\FileController@uploade');
    Route::post('file/{TaskId}/uploade','Api\FileController@uploade');
    Route::delete('file/{file}','Api\FileController@destroy');
});


