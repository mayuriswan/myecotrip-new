<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () 
// {
//     return view('welcome');
// });


Route::get('/', function () {
    return view('index');
});





Route::group(['prefix' => 'api', 'middleware'=>['before','after']], function()
{
  Route::get('/', function()
  {
      return "Protected resource";
  });
  Route::group(array('prefix' => 'v1'), function()
  {
    

    Route::resource('user', 'UserController');


  });
});