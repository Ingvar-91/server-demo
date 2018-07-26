<?php

//use Illuminate\Http\Request;

Route::group([
    'prefix'     => 'v1',
    'namespace'  => 'Api\v1'
], function (){
    
    //ПОЛЬЗОВАТЕЛИ
    Route::group(['prefix' => 'user'], function() {
        Route::get('/', ['uses' => 'Admin\UsersController@index']);
        Route::get('/{id}', ['uses' => 'Admin\UsersController@getById']);
        Route::post('/', ['uses' => 'Admin\UsersController@add']);
        Route::put('/{id}', ['uses' => 'Admin\UsersController@edit']);
        Route::delete('/{ids}', ['uses' => 'Admin\UsersController@remove']);
    });
    
    // ЗАПИСИ
    Route::group(['prefix' => 'posts'], function() {
        Route::get('/', ['uses' => 'Admin\PostsController@index']);
        Route::get('/{id}', ['uses' => 'Admin\PostsController@getById']);
        Route::post('/', ['uses' => 'Admin\PostsController@add']);
        Route::post('/upload', ['uses' => 'Admin\PostsController@upload']);
        Route::put('/{id}', ['uses' => 'Admin\PostsController@edit']);
        Route::delete('/{ids}', ['uses' => 'Admin\PostsController@remove']);
    });
    
    Route::group(['prefix' => 'stats'], function() {
        Route::get('/getCountPostsByRangeDate', ['uses' => 'Admin\PostsController@getCountPostsByRangeDate']);
    });
    
    //АВТОРИЗАЦИЯ
    Route::group(['prefix' => 'login'], function() {
        Route::post('/', ['uses' => 'Auth\LoginController@login']);
    });
    
    //РЕГИСТРАЦИЯ
    Route::group(['prefix' => 'register'], function() {
        Route::post('/', ['uses' => 'Auth\RegisterController@createUser']);
    });
    
    Route::get('/getUserByEmail', ['uses' => 'Auth\LoginController@getUserByEmail']);

    // Route::get('/getUser', ['uses' => 'Site\HomeController@getUser']);
});



/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
