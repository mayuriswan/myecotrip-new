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

Route::group(['prefix' => 'jungle-stays', 'middleware'=>['before','after']], function() {

    Route::get('/', 'JungleStayController@index');
    Route::get('/{jsId}/{jungleStayName}', 'JungleStayController@show')->name('stay-details');
    Route::post('/room-list/{jsId}', 'JungleStayController@checkAvailability');
    Route::post('/guest-details/{jsId}', 'JungleStayController@getGuestDetails');
    Route::get('/add-guest/{count}/{index}/{roomId}', 'JungleStayController@addGuest');
    Route::post('/initiateBooking/{jsId}', 'JungleStayController@initiateBooking');
    Route::post('/response-receiver', 'JungleStayController@responseReceiver');

    Route::get('/resend-mail/{bookingId}/{requestFrom}', 'JungleStayController@sendStayTicket')->name('resend-mail');


});
