<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

/**Prefix for route url */
Route::prefix('v1')->group(function(){
    /**Route for login API */
    Route::post('login', 'Api\v1\AuthController@login');

    /**Route for register API */
    Route::post('register', 'Api\v1\AuthController@register');

    /**Route for details user API */
    Route::middleware('auth:api')->group(function(){
        Route::post('logout','Api\v1\AuthController@logout');
        Route::post('details', 'Api\v1\AuthController@user_info');

        Route::get('list/user', 'Api\v1\AuthController@list');
        Route::get('edit/user', 'Api\v1\AuthController@edit');
        Route::post('update/user', 'Api\v1\AuthController@update');
        Route::post('delete/user', 'Api\v1\AuthController@delete');
    });

});
    
