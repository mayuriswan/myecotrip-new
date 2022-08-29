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

Route::middleware('auth:api')->get('/apis', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/birdsanctuary'], function()
{
  //Bird Sanctuary ticket booking API
  Route::post('doLogin', 'API\UserController@doLogin')->name('birdSanctuaryLogin');
  Route::get('/getPricing/{id}' , 'API\BirdSanctuaryController@getPricing');
  Route::post('/syncTickets' , 'API\BirdSanctuaryController@syncTickets');
  Route::post('/dayReport' , 'API\BirdSanctuaryController@dayReport');

});


Route::group(['prefix' => '/trail'], function()
{
  //Trail ticket booking API
  Route::post('doLogin', 'Trail\UserController@index');
  Route::get('/getPricing/{id}' , 'Trail\TrailController@getPricing');
  Route::post('/syncTickets' , 'Trail\TrailController@syncTickets');

});