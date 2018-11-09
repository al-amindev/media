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

Route::group(['namespace' => 'API'], function(){
    /*property store related*/
    Route::get('image', 'MediaController@getImage');
    Route::post('media/upload', 'MediaController@upload');
    Route::delete('media/{files}', 'MediaController@delete');
});
