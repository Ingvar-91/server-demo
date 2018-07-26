<?php

/*Route::get('/image', function(){
    $originalWidth = 3840;
    $originalHeight = 2160;
    $maxWidth = 382;
    $maxHeight = 215;
    $ratio = $originalHeight / $maxHeight;
    $x1 = ceil(167 * $ratio);
    $x2 = ceil(382 * $ratio);
    $y1 = ceil(0 * $ratio);
    $y2 = ceil(215 * $ratio);
    $w = $y2 - $y1;
    $h = $y2 - $y1;
    $img = Image::make('1.jpg')->heighten($originalHeight)->crop($w, $h, $x1, $y1);
    return $img->response('jpg');
});*/

Route::group([
    'namespace'  => 'Api\v1'
], function (){
    
    Route::get('/{id}', ['uses' => 'Admin\UsersController@getById']);
});

/*
Route::get('/', function () {
    return view('welcome');
});
 */
