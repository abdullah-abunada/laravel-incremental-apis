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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['prefix'=> 'v1'], function(){

    Route::post('signup','Api\v1\AuthController@SignUp');
    Route::post('authenticate', 'Api\v1\AuthController@authenticate');
});

Route::group( ['prefix' => 'v1','middleware'=>['jwt.auth']] , function() {
    Route::get('lessons/{id}/tags', 'Api\V1\TagsController@index');
    Route::Resource('lessons', 'Api\V1\LessonsController');
    Route::Resource('tags', 'Api\V1\TagsController',['only'=>['index', 'show']]);
    //Route::Resource('lessons.tags','Api\V1\LessonTagsController');
});