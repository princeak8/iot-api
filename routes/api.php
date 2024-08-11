<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ProfileAuth;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::group(['prefix' => '/auth'], function () {
    Route::post('/client/login', 'AuthController@login');
    Route::post('/profile/login', 'AuthController@profileLogin');
    Route::post('/viewer/login', 'AuthController@viewerLogin');
});

Route::group(['prefix' => '/client'], function () {
    Route::post('/create', 'ClientController@create');
    Route::post('/update', 'ClientController@update');
    Route::get('/all', 'ClientController@clients');
});

Route::group(['prefix' => '/profile'], function () {
    Route::post('/create', 'ProfileController@create');
    Route::post('/update', 'ProfileController@update');
    Route::get('/all', 'ProfileController@profiles');
});

Route::group(['prefix' => '/viewer'], function () {
    Route::post('/create', 'ViewerController@create');
});

Route::group(['prefix' => '/module', 'middleware'=>[ProfileAuth::class]], function () {
    Route::post('/create', 'ModuleController@create');
    Route::post('/update', 'ModuleController@update');
    Route::delete('/delete', 'ModuleController@delete');
    Route::get('/all', 'ModuleController@modules');
    Route::get('/get/{id}', 'ModuleController@module');
});

Route::group(['prefix' => '/config'], function () {
    Route::post('/publish/save', 'PublishingConfigController@save');
});

Route::get('/send', 'SocketController@send');
