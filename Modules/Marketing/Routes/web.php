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

Route::prefix('marketing')->group(function() {
    Route::get('/', 'MarketingController@index');

    Route::get('/sendMail', 'MarketingController@sendMail');
    Route::get('/sendMail2', 'MarketingController@queueMail');


    Route::get('/sendMailForSubscribers', 'MarketingController@sendMailForSubscribers');
    Route::get('/sendMailForVTP', 'MarketingController@sendMailForVTP');

});
