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

Route::group(['prefix' => 'cms', 'middleware'=>['adminBefore']], function() {
    Route::get('/', 'CMSController@index');


    //Jungle Stay
    Route::group(['prefix' => 'jungle-stay'], function() {
        Route::get('/pricing/{roomId}', 'SuperAdmin\JungleStay\PricingController@index');
        Route::get('/pricing/create/{roomId}', 'SuperAdmin\JungleStay\PricingController@create');


        Route::resources([
            'stays' => 'SuperAdmin\JungleStay\JungleStayController',
            'rooms' => 'SuperAdmin\JungleStay\RoomController',
            'parking' => 'SuperAdmin\JungleStay\ParkingController',
            'pricing' => 'SuperAdmin\JungleStay\PricingController',
            'entry' => 'SuperAdmin\JungleStay\EntryController'
        ]);

        Route::post('staysImages', 'SuperAdmin\JungleStay\JungleStayController@staysImages');

        //Rooms
        Route::get('/rooms-list/{jsId}', 'SuperAdmin\JungleStay\RoomController@index');
        Route::get('/create-room/{jsId}', 'SuperAdmin\JungleStay\RoomController@create');

        // Pricing

    });
    //End Jungle Stay


    // Trail 
    Route::group(['prefix' => 'ecotrails'], function() {


        Route::resources([
            'trails' => 'SuperAdmin\Trail\TrailController',
            'landscape' => 'SuperAdmin\Trail\LandscapeController',
            'timeslot' => 'SuperAdmin\Trail\TimeslotController',
            'sa-trail-bookings' => 'SuperAdmin\Trail\BookingController',
            'coming-soon' => 'SuperAdmin\Trail\ComingSoonController',
            'report' => 'SuperAdmin\Trail\ReportController',
            'pricing' => 'SuperAdmin\Trail\PricingController',


        ]);

        Route::get('/sa-trail-bookings/{bookingId}/{userId}', 'SuperAdmin\Trail\BookingController@show');
        Route::get('/upcoming-bookings', 'SuperAdmin\Trail\BookingController@upComing');
        Route::get('/booking-placed_today', 'SuperAdmin\Trail\BookingController@placedToday');
        Route::get('search-bookings', function () {      
          return view('cms::superAdmin.TrailBooking.search-booking');
        })->name('searchBookings');

        Route::post('/search-bookings', 'SuperAdmin\Trail\BookingController@searchBooking');
        Route::post('/downloadReport', 'SuperAdmin\Trail\ReportController@downloadReport');
        

    });
    // Trail 



});
