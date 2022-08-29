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

// ------------------------- Admin panel ---------------------------------------


// ------------------------- Park Admin ---------------------------------------
Route::get('parkLogout', 'Admin\LoginController@parkLogin')->name('parkLogout');
Route::post('parkAdmin/doLogin', 'Admin\LoginController@doParkLogin')->name('parkAdminLogin');

Route::group(['prefix' => 'parkAdmin', 'middleware'=>['before','after']], function()
{
  Route::get('/', 'Admin\LoginController@parkLogin')->name('parkAdminHome');
  
  Route::get('parkBookings', 'Admin\ParkAdminController@parkBookings')->name('parkBookings');
  Route::get('PAtrailDetail/{bookingId}/{userId}', 'Admin\ParkAdminController@PAtrailDetail')->name('PAtrailDetail');
  Route::get('PApreBookings', 'Admin\ParkAdminController@PApreBookings')->name('PApreBookings');
  Route::get('PAplacedToday', 'Admin\ParkAdminController@PAplacedToday')->name('PAplacedToday');
  Route::get('PAsearchBookings', function () {      
      return view('Admin/adminPages/parkAdmin/bookings/searchBooking');
  })->name('PAsearchBookings');

  Route::post('PASearchedBookings', 'Admin\ParkAdminController@PASearchedBookings')->name('PASearchedBookings');

});

// ------------------- Trail and super admin ----------------------------------
Route::get('logout', 'Admin\LoginController@login')->name('adminLogout');
Route::post('admin/doLogin', 'Admin\LoginController@doLogin')->name('doLogin');

Route::group(['prefix' => 'admin', 'middleware'=>['adminBefore','after']], function()
{

  Route::get('/', 'Admin\LoginController@login')->name('adminHome');

  // Masters

  // --------------------- Circle ----------------------------------------------
  Route::get('circles', 'Admin\CircleController@getCircles')->name('getCircles');
  Route::get('circles/edit', 'Admin\CircleController@editCircles')->name('editCircles');
  Route::post('addCircle', 'Admin\CircleController@addCircle')->name('addCircle');
  Route::post('updateCircle', 'Admin\CircleController@updateCircle')->name('updateCircle');
  Route::get('deleteCircle', 'Admin\CircleController@deleteCircle')->name('deleteCircle');

  // --------------------- Park ----------------------------------------------
  Route::get('parks', 'Admin\ParkController@getParks')->name('getParks');
  Route::get('addPark', 'Admin\ParkController@addPark')->name('addPark');

  Route::post('createPark', 'Admin\ParkController@createPark')->name('createPark');
  Route::get('editPark', 'Admin\ParkController@editPark')->name('editPark');
  // Route::get('viewPark', 'ParkController@viewPark')->name('viewPark'); // Not req noow
  Route::post('updatePark', 'Admin\ParkController@updatePark')->name('updatePark');
  Route::get('deletePark', 'Admin\ParkController@deletePark')->name('deletePark');

  // --------------------- Landscape -----------------------------------
  Route::get('landscape', 'Admin\LandscapeController@getLandscapes')->name('landscape');
  Route::get('addLandscape', function()
  {
    return view('Admin/landscape/add');
  });
  Route::post('createLandscape', 'Admin\LandscapeController@createLandscape')->name('createLandscape');
  Route::get('editLandscape', 'Admin\LandscapeController@editLandscapes')->name('editLandscapes');
  Route::post('updateLandscape', 'Admin\LandscapeController@updateLandscape')->name('updateLandscape');
  Route::get('deleteLandscape', 'Admin\LandscapeController@deleteLandscape')->name('deleteLandscape');

  // --------------------- Trails ---------------------------------------
  Route::get('trail', 'Admin\TrailController@getTrails')->name('trail');
  Route::get('addTrail', 'Admin\TrailController@addTrail')->name('addTrail');
  Route::post('createTrail', 'Admin\TrailController@createTrail')->name('createTrail');
  Route::get('/createTrailTest', 'Admin\TrailController@createTrail2')->name('createTrail2');
  Route::get('editTrail', 'Admin\TrailController@editTrail')->name('editTrail');
  Route::post('updateTrail', 'Admin\TrailController@updateTrail')->name('updateTrail');
  Route::get('deleteTrail', 'Admin\TrailController@deleteTrail')->name('deleteTrail');

  Route::get('TAtrailDetail/{bookingId}/{userId}', 'Admin\TrailAdminController@TAtrailDetail')->name('TAtrailDetail');


// Bookings
  Route::get('SAtrailBookings', 'Admin\TrailBookingController@SAtrailBookings')->name('SAtrailBookings');
  Route::get('SAtrailDetail/{bookingId}/{userId}', 'Admin\TrailBookingController@SAtrailDetail')->name('SAtrailDetail');
  Route::get('SApreBookings', 'Admin\TrailBookingController@SApreBookings')->name('SApreBookings');
  Route::get('SAplacedToday', 'Admin\TrailBookingController@SAplacedToday')->name('SAplacedToday');
  Route::get('searchBookings', function () {      
      return view('Admin/adminPages/superAdmin/bookings/searchBooking');
  })->name('searchBookings');
  Route::post('getSearchedBookings', 'Admin\TrailBookingController@getSearchedBookings')->name('getSearchedBookings');


  // Admins

  // -------------------- Trails -----------------------------------
  Route::get('trailAdmins', 'Admin\TrailAdminController@getTrailAdmins')->name('getTrailAdmins');
  Route::get('addTrailAdmin', 'Admin\TrailAdminController@addTrailAdmin')->name('addTrailAdmin');
  Route::post('createTrailAdmin', 'Admin\TrailAdminController@createTrailAdmin')->name('createTrailAdmin');
  Route::get('editTrailAdmin', 'Admin\TrailAdminController@editTrailAdmin')->name('editTrailAdmin');
  Route::post('updateTrailAdmin', 'Admin\TrailAdminController@updateTrailAdmin')->name('updateTrailAdmin');
  Route::get('deleteTrailAdmin', 'Admin\TrailAdminController@deleteTrailAdmin')->name('deleteTrailAdmin');


// Trail admins
  Route::get('trailBookings', 'Admin\TrailAdminController@trailBookings')->name('trailBookings');
  Route::get('TApreBookings', 'Admin\TrailAdminController@TApreBookings')->name('TApreBookings');
  Route::get('placedToday', 'Admin\TrailAdminController@placedToday')->name('placedToday');

  //Park admins
  Route::get('parkAdmins', 'Admin\ParkAdminController@getParkAdmins')->name('getParkAdmins');
  Route::get('addParkAdmin', 'Admin\ParkAdminController@addParkAdmin')->name('addParkAdmin');
  Route::post('createParkAdmin', 'Admin\ParkAdminController@createParkAdmin')->name('createParkAdmin');  
  Route::get('editParkAdmin', 'Admin\ParkAdminController@editParkAdmin')->name('editParkAdmin');
  Route::post('updateParkAdmin', 'Admin\ParkAdminController@updateParkAdmin')->name('updateParkAdmin');
  Route::get('deletePrailAdmin', 'Admin\ParkAdminController@deletePrailAdmin')->name('deletePrailAdmin');



});



// --------------------------- Website ----------------------------------------

Route::group(['middleware'=>['before','after']], function()
{
  Route::get('/', function () {      
      // echo '<pre>';print_r(Session::all());
      return view('index');
  })->name('home');

  // Ecotrip
  Route::get('/landscapes', 'LandscapeController@index')->name('landscapes');
  Route::post('/trails/{landscapeId}/filteredTrails', 'TrailController@getFilteredTrails')->name('landscapes');
  Route::get('/trails/{landscapeId}/{landscapeName}', 'TrailController@getTrails')->name('landscapes');
  Route::get('/trailDetail/{trekId}/{trekName}', 'TrailController@getTrailDetails')->name('getTrailDetails');
  Route::post('/checkAvailability/{trekId}/{trekName}', 'TrailController@checkAvailability')->name('checkAvailability');

  Route::get('/getTrekkersDetails', 'TrailController@getTrekkersDetails')->name('getTrekkersDetails');

  Route::post('/initiateBooking', 'TrailController@initiateBooking')->name('initiateBooking');
  Route::get('/ecotrails/responseReceiver', 'TrailController@responseReceiver')->name('responseReceiver');


  Route::get('/subCategory', function () {
      return view('ecotrails/subCategory');
  });


  // User

  Route::post('/userSignUp','UserController@userSignUp')->name('userSignUp');
  Route::post('/userSignIn','UserController@userSignIn')->name('userSignIn');
  Route::get('/signOut','UserController@signOut')->name('signOut');


  // Static pages
  Route::get('/contactUs', function()
  {
      return view('static/contactUs');
  });

  Route::get('/PrivacyPolicy', function()
  {
      return view('static/PrivacyPolicy');
  });

   Route::get('/TermsofUse', function()
  {
      return view('static/TermsofUse');
  });


});
