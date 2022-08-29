<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// CMS
Route::get('/bs-admin', 'BirdSanctuaryController@index')->name('bs-login');
Route::post('bs-admin/doLogin', 'BirdSanctuaryController@doLogin');

Route::group(['prefix' => 'bs-admin', 'middleware'=>['BSBeforeMiddleware']], function(){

    Route::get('logout', 'BirdSanctuaryController@logout')->name('bs-logout');
  	Route::get('dashboard', 'BirdSanctuaryController@dashboard')->name('bs-dashboard');

  	Route::get('book-ticket/{id}', 'CMS\TicketController@show')->name('book-ticket');

 	Route::resources([

	    'book-ticket' => 'CMS\TicketController',


        //Report
        'booking_report' => 'CMS\ReportController'
	]);
});
