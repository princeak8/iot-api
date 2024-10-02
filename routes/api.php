<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\UserAuth;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\SuperAdmin;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::group(['prefix' => '/auth'], function () {
    Route::post('/admin/login', 'AdminAuthController@login');
    Route::post('/user/login', 'AuthController@login');

    // Route::post('/profile/change_password', 'AuthController@changeProfilePassword');
});

Route::middleware(AdminAuth::class)->group(function () {
    Route::group(['prefix' => '/admin', 'namespace' => 'Admin'], function () {

        Route::group(['prefix' => '/client'], function () {
            Route::post('/create', 'ClientController@create');
            Route::post('/update', 'ClientController@update');
            Route::get('/all', 'ClientController@clients');
            Route::get('/{id}', 'ClientController@client');
        });

        Route::group(['prefix' => '/profile'], function () {
            Route::post('/create', 'ProfileController@create');
            Route::post('/update', 'ProfileController@update');
            Route::get('/client/{id}', 'ProfileController@profiles');
            Route::get('/{id}', 'ProfileController@profile');
        });

        Route::group(['prefix' => '/user'], function () {
            Route::post('/create', 'UserController@create');
        });

        Route::group(['prefix' => '/module_types'], function () {
            Route::get('', 'ModuleTypeController@moduleTypes');
            Route::post('', 'ModuleTypeController@save');
        });
        
        Route::group(['prefix' => '/module'], function () {
            Route::post('/create', 'ModuleController@create');
            Route::post('/update', 'ModuleController@update');
            Route::delete('/delete', 'ModuleController@delete');
            Route::get('/profile/{profileId}', 'ModuleController@modules');
            Route::get('/{id}', 'ModuleController@module');
        });

        Route::group(['prefix' => '/sub_module'], function () {
            Route::post('/create', 'SubModuleController@create');
            // Route::post('/update', 'ModuleController@update');
            // Route::delete('/delete', 'ModuleController@delete');
            Route::get('/module/{moduleId}', 'SubModuleController@subModules');
            Route::get('/{id}', 'SubModuleController@subModule');
        });

        Route::group(['prefix' => '/component'], function () {
            Route::post('/create', 'ComponentController@create');
            Route::post('/update', 'ComponentController@update');
            Route::get('/sub_module/{subModuleId}', 'ComponentController@components');
            Route::get('/{id}', 'ComponentController@component');
        });

        Route::group(['prefix' => '/parameter'], function () {
            Route::post('/create', 'ParameterController@create');
            Route::post('/update', 'ParameterController@update');
            Route::get('/all', 'ParameterController@parameters');
            Route::get('/{id}', 'ParameterController@parameter');
            Route::delete('/{id}', 'ParameterController@delete');
        });

        Route::group(['prefix' => '/component_category'], function () {
            Route::post('/create', 'ComponentCategoryController@create');
            Route::post('/update', 'ComponentCategoryController@update');
            Route::get('/all', 'ComponentCategoryController@categories');
            Route::get('/{id}', 'ComponentCategoryController@category');
            Route::delete('/{id}', 'ComponentCategoryController@delete');
        });
    });
});

// Route::group(["middleware" => SuperAdminAuth::class, 'prefix' => '/client', "namespace" => "Client"], function () {
//     Route::group(['prefix' => '/user'], function () {
//         Route::post('/create', 'UserController@create');
//     });
// });

//User Routes
Route::middleware(UserAuth::class)->group(function () {
    Route::group(['prefix' => '/user', "namespace" => "User"], function () {
        Route::group(['prefix' => '/sub_module'], function () {
            Route::get('/module/{moduleId}', 'SubModuleController@subModules');
            Route::get('/{id}', 'SubModuleController@subModule');
        });
    });
});

Route::group(['prefix' => '/config'], function () {
    Route::post('/publish/save', 'PublishingConfigController@save');
});

Route::post('/broadcasting/auth', 'BroadcastAuthController@authenticate')->middleware(UserAuth::class);

Route::post('/send', 'SocketController@send');
