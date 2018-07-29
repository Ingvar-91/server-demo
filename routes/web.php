<?php

/*
Route::group([
    'namespace'  => 'Api\v1'
], function (){
    
    Route::get('/{id}', ['uses' => 'Admin\UsersController@getById']);
});
*/

Route::get('/', ['uses' => 'Site\HomeController@index']);
