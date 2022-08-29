<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
Route::get('agentlogout', 'Admin\LoginController@agentLogin')->name('agentlogout');
Route::post('agent/doLogin', 'Admin\LoginController@doAgentLogin')->name('agentLogin');

Route::group(['prefix' => 'agent', 'middleware'=>['before','after']], function()
{
  Route::get('/', 'Admin\LoginController@agentLogin')->name('agentHome');

  Route::get('agentBookings', 'Agent\AgentAdminController@agentBookings')->name('agentBookings');
  Route::get('agentPreBookings', 'Agent\AgentAdminController@agentPreBookings')->name('agentPreBookings');
  Route::get('placedToday', 'Agent\AgentAdminController@placedToday')->name('placedToday');

  Route::get('trailDetail/{bookingId}', 'Agent\AgentAdminController@trailDetail')->name('trailDetail');

  // Book
  Route::get('bookNow', 'Agent\AgentAdminController@bookNow')->name('bookNow');


});

// ------------------------- myAdmin -----------------------------------------
Route::get('myAdminlogout', 'Admin\LoginController@myAdminLogin')->name('myAdminlogout');
Route::post('myAdmin/doLogin', 'Admin\LoginController@doMyAdminLogin')->name('myadminLogin');

Route::group(['prefix' => 'myAdmin', 'middleware'=>['before','after']], function()
{
  Route::get('/', 'Admin\LoginController@myAdminLogin')->name('myAdminHome');

  // Bookings
  Route::get('SAtrailBookings', 'MyAdmin\TrailBookingController@SAtrailBookings')->name('SAtrailBookings');
  Route::get('SAtrailDetail/{bookingId}/{userId}', 'MyAdmin\TrailBookingController@SAtrailDetail')->name('SAtrailDetail');
  Route::get('SApreBookings', 'MyAdmin\TrailBookingController@SApreBookings')->name('SApreBookings');
  Route::get('SAplacedToday', 'MyAdmin\TrailBookingController@SAplacedToday')->name('SAplacedToday');
  Route::get('searchBookings', function () {
      return view('Admin/adminPages/myAdmin/bookings/searchBooking');
  })->name('searchBookings');
  Route::post('getSearchedBookings', 'MyAdmin\TrailBookingController@getSearchedBookings')->name('getSearchedBookings');

  // Reports
  Route::get('trailBookingReports', 'MyAdmin\ReportController@trailBookingReports')->name('trailBookingReports');
  Route::get('circlesParlList/{circleId}', 'MyAdmin\ReportController@circlesParlList')->name('circlesParlList');
  Route::get('parksTrailList/{parkId}', 'MyAdmin\ReportController@parksTrailList')->name('parksTrailList');


  Route::resource('SAEventBookings', 'MyAdmin\EventController');
  Route::get('SAEventBookings/sendMail/{bookingId}', 'MyAdmin\EventController@sendMail')->name('sendMail');
  Route::get('SAEventBookings/sendSMS/{bookingId}', 'MyAdmin\EventController@sendEventSMS')->name('sendEventSMS');
  Route::get('SAEventBookings/updateSuccess/{bookingId}', 'MyAdmin\EventController@updateSuccess')->name('updateSuccess');

});

// -------------------------- Circle Admin ------------------------------------
Route::get('circleLogout', 'Admin\LoginController@circleLogin')->name('circleLogout');
Route::post('circleAdmin/doLogin', 'Admin\LoginController@doCircleLogin')->name('circleAdminLogin');

Route::group(['prefix' => 'circleAdmin', 'middleware'=>['before','after']], function()
{
  Route::get('/', 'Admin\LoginController@circleLogin')->name('circleAdminHome');

  Route::get('circleBookings', 'Admin\CircleAdminController@circleBookings')->name('circleBookings');
  Route::get('CAtrailDetail/{bookingId}/{userId}', 'Admin\CircleAdminController@CAtrailDetail')->name('CAtrailDetail');
  Route::get('CApreBookings', 'Admin\CircleAdminController@CApreBookings')->name('CApreBookings');
  Route::get('CAplacedToday', 'Admin\CircleAdminController@CAplacedToday')->name('CAplacedToday');
  Route::get('CAsearchBookings', function () {
      return view('Admin/adminPages/CircleAdmin/bookings/searchBooking');
  })->name('CAsearchBookings');

  Route::post('CASearchedBookings', 'Admin\CircleAdminController@CASearchedBookings')->name('CASearchedBookings');

  Route::get('CAbookingReports', 'Admin\CircleAdminController@CAbookingReports')->name('CAbookingReports');

  Route::get('parksTrailList/{parkId}', 'Admin\CircleAdminController@parksTrailList')->name('parksTrailList');

  Route::post('downloadReport', 'Admin\ReportController@downloadReport')->name('downloadReport');


});

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

  Route::get('PAbookingReports', 'Admin\ParkAdminController@PAbookingReports')->name('PAbookingReports');

  Route::post('downloadReport', 'Admin\ReportController@downloadReport')->name('downloadReport');

});

// ------------------- Bird Sanctuary Admin ----------------------------------
Route::group(['prefix' => 'birdSanctuaryAdmin', 'middleware'=>['adminBefore','after']], function()
{

  Route::get('/', 'Admin\LoginController@birdSanctuaryAdminLogin')->name('birdSanctuaryAdminLogin');


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
  // Route::post('createTrail2', 'Admin\TrailController@createTrail2')->name('createTrail');
  Route::get('editTrail', 'Admin\TrailController@editTrail')->name('editTrail');
  Route::post('updateTrail', 'Admin\TrailController@updateTrail')->name('updateTrail');
  Route::get('deleteTrail', 'Admin\TrailController@deleteTrail')->name('deleteTrail');

  Route::get('TAtrailDetail/{bookingId}/{userId}', 'Admin\TrailAdminController@TAtrailDetail')->name('TAtrailDetail');

  // TrailUpcoming
  Route::get('trailUpcoming', 'Admin\TrialUpcomingController@trailUpcoming')->name('TrailUpcoming');
  Route::get('addTrailUpcoming', function()
  {
    return view('Admin/trails/addUpcoming');
  });
  Route::post('createTrailUpcoming', 'Admin\TrialUpcomingController@createTrailUpcoming')->name('createTrailUpcoming');
  Route::get('editTrailUpcoming/{id}', 'Admin\TrialUpcomingController@editTrailUpcoming')->name('editTrailUpcoming');
  Route::post('updateTrailUpcoming', 'Admin\TrialUpcomingController@updateTrailUpcoming')->name('updateTrailUpcoming');
  Route::get('deleteTrailUpcoming/{id}', 'Admin\TrialUpcomingController@deleteTrailUpcoming')->name('deleteTrailUpcoming');


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
  Route::get('deleteTrailImages/{imageId}', 'Admin\TrailAdminController@deleteTrailImages')->name('deleteTrailImages');

  // Trail admins
  Route::get('trailBookings', 'Admin\TrailAdminController@trailBookings')->name('trailBookings');
  Route::get('TApreBookings', 'Admin\TrailAdminController@TApreBookings')->name('TApreBookings');
  Route::get('placedToday', 'Admin\TrailAdminController@placedToday')->name('placedToday');

  // offline
  Route::get('oflineTrailBookings', 'Admin\TrailOflineBookingController@trailBookings')->name('oflineTrailBookings');
  Route::get('offlineTrailBookNow', 'Admin\TrailOflineBookingController@offlineTrailBookNow')->name('offlineTrailBookNow');
  Route::post('getTrekkersDetails', 'Admin\TrailOflineBookingController@getTrekkersDetails')->name('getTrekkersDetails');

  Route::post('saveOfflineTrailBooking', 'Admin\TrailOflineBookingController@saveOfflineTrail')->name('saveOfflineTrail');
  Route::get('offlineBookingDetails/{bookingId}', 'Admin\TrailOflineBookingController@offlineBookingDetails')->name('offlineBookingDetails');
  Route::get('TAbookingReports', function () {
      return view('Admin/adminPages/trails/reportIndex');
  })->name('TAbookingReports');
  Route::post('/ecotrails/adminResponseReceiver', 'Admin\TrailOflineBookingController@responseReceiver')->name('adminResponseReceiver');


  //Park admins
  Route::get('parkAdmins', 'Admin\ParkAdminController@getParkAdmins')->name('getParkAdmins');
  Route::get('addParkAdmin', 'Admin\ParkAdminController@addParkAdmin')->name('addParkAdmin');
  Route::post('createParkAdmin', 'Admin\ParkAdminController@createParkAdmin')->name('createParkAdmin');
  Route::get('editParkAdmin', 'Admin\ParkAdminController@editParkAdmin')->name('editParkAdmin');
  Route::post('updateParkAdmin', 'Admin\ParkAdminController@updateParkAdmin')->name('updateParkAdmin');
  Route::get('deletePrailAdmin', 'Admin\ParkAdminController@deletePrailAdmin')->name('deletePrailAdmin');


  // Circle admin
  Route::get('circleAdmins', 'Admin\CircleAdminController@getCircleAdmins')->name('getCircleAdmins');
  Route::get('addCircleAdmin', 'Admin\CircleAdminController@addCircleAdmin')->name('addCircleAdmin');
  Route::post('createCircleAdmin', 'Admin\CircleAdminController@createCircleAdmin')->name('createCircleAdmin');
  Route::get('editCircleAdmin', 'Admin\CircleAdminController@editCircleAdmin')->name('editCircleAdmin');
  Route::post('updateCircleAdmin', 'Admin\CircleAdminController@updateCircleAdmin')->name('updateCircleAdmin');
  Route::get('deleteCircleAdmin', 'Admin\CircleAdminController@deleteCircleAdmin')->name('deleteCircleAdmin');

  // My admins
  Route::get('myAdmins', 'Admin\MyAdminController@myAdmins')->name('myAdmins');
  Route::get('addMyAdmin', 'Admin\MyAdminController@addMyAdmin')->name('addMyAdmin');
  Route::post('createMyAdmin', 'Admin\MyAdminController@createMyAdmin')->name('createMyAdmin');
  Route::get('editMyAdmin', 'Admin\MyAdminController@editMyAdmin')->name('editMyAdmin');
  Route::post('updateMyAdmin', 'Admin\MyAdminController@updateMyAdmin')->name('updateMyAdmin');
  Route::get('deleteMyAdmin', 'Admin\MyAdminController@deleteMyAdmin')->name('deleteMyAdmin');

  // Agent login
  Route::get('agents', 'Agent\AgentController@getAgents')->name('getAgents');
  Route::get('addAgent', function () {
      return view('Admin/agent/add');
  })->name('addAgent');
  Route::post('createAgent', 'Agent\AgentController@createAgent')->name('createAgent');
  Route::get('editAgent', 'Agent\AgentController@editAgent')->name('editAgent');
  Route::post('updateAgent', 'Agent\AgentController@updateAgent')->name('updateAgent');
  Route::get('deleteAgent', 'Agent\AgentController@deleteAgent')->name('deleteAgent');


  // Reports
  Route::get('trailBookingReports', 'Admin\ReportController@trailBookingReports')->name('trailBookingReports');
  Route::get('circlesParlList/{circleId}', 'Admin\ReportController@circlesParlList')->name('circlesParlList');
  Route::get('parksTrailList/{parkId}', 'Admin\ReportController@parksTrailList')->name('parksTrailList');

  Route::post('downloadReport', 'Admin\ReportController@downloadReport')->name('downloadReport');

  //Bird Sanctory report
  Route::get('birdSanctuaryBookingReports', 'Admin\BirdSanctuaryReportController@birdSanctuaryBookingReports')->name('birdSanctuaryBookingReports');
  Route::post('downloadBirdSanctoryReport', 'Admin\BirdSanctuaryReportController@downloadBirdSanctoryReport')->name('downloadBirdSanctoryReport');


  //Bird Fest
  Route::get('birdFestBookingReports', 'Admin\BirdsFest\BirdsFestReportController@index')->name('birdFestBookingReports');
  Route::post('downloadBirdFestReport', 'Admin\BirdsFest\BirdsFestReportController@downloadBirdFestReport')->name('downloadBirdFestReport');


  //-----------------------TimeSlots-------------------------

    Route::get('timeslots', 'Admin\TimeSlotsController@getTimeSlots')->name('getTimeSlots');
    Route::get('addTimeSlots', function()
    {
        return view('Admin/timeslots/add');
    });
    Route::post('createTimeSlots', 'Admin\TimeSlotsController@createTimeSlots')->name('createTimeSlots');
    Route::get('editTimeSlots', 'Admin\TimeSlotsController@editTimeSlots')->name('editTimeSlots');
    Route::post('updateTimeSlots', 'Admin\TimeSlotsController@updateTimeSlots')->name('updateTimeSlots');
    Route::get('deleteTimeSlots', 'Admin\TimeSlotsController@deleteTimeSlots')->name('deleteTimeSlots');

  //----------------------Transportation------------------------

    Route::get('transportationTypes','Admin\Transportation\TransportationtypesController@getTypes')->name('getTypes');
    Route::get('addTransportationTypes', 'Admin\Transportation\TransportationtypesController@addTransportationTypes')->name('addTransportationTypes');
    Route::post('createTransportationTypes', 'Admin\Transportation\TransportationtypesController@createTransportationTypes')->name('createTransportationTypes');
    Route::get('editTransportationTypes', 'Admin\Transportation\TransportationtypesController@editTransportationTypes')->name('editTransportationTypes');
    Route::post('updateTransportationTypes', 'Admin\Transportation\TransportationtypesController@updateTransportationTypes')->name('updateTransportationTypes');
    Route::get('deleteTransportationTypes', 'Admin\Transportation\TransportationtypesController@deleteTransportationTypes')->name('deleteTransportationTypes');

  // --------------------- Safari -----------------------------------

    Route::get('safari', 'Admin\Safari\SafariController@getSafaries')->name('getSafaries');
    Route::get('addSafari', 'Admin\Safari\SafariController@addSafaries')->name('addSafaries');
    Route::post('createSafari', 'Admin\Safari\SafariController@createSafari')->name('createSafari');
    Route::get('editSafari', 'Admin\Safari\SafariController@editSafari')->name('editSafari');
    Route::post('updateSafari', 'Admin\Safari\SafariController@updateSafari')->name('updateSafari');
    Route::get('deleteSafari', 'Admin\Safari\SafariController@deleteSafari')->name('deleteSafari');
    Route::get('deleteSafariImages', 'Admin\Safari\SafariController@deleteSafariImages')->name('deleteSafariImages');

  // --------------------- Safari Vehicle-----------------------------------

    Route::get('safariVehicles', 'Admin\Safari\SafariVehicleController@getsafariVehicles')->name('getsafariVehicles');
    Route::get('addSafariVehicle', 'Admin\Safari\SafariVehicleController@addSafariVehicle')->name('addSafariVehicle');
    Route::post('createSafariVehicle', 'Admin\Safari\SafariVehicleController@createSafariVehicle')->name('createSafariVehicle');
    Route::get('editSafariVehicle', 'Admin\Safari\SafariVehicleController@editSafariVehicle')->name('editSafariVehicle');
    Route::post('updateSafariVehicle', 'Admin\Safari\SafariVehicleController@updateSafariVehicle')->name('updateSafariVehicle');
    Route::get('deleteSafariVehicle', 'Admin\Safari\SafariVehicleController@deleteSafariVehicle')->name('deleteSafariVehicle');

  //----------------------Safari Timeslots Transportationtype------------------------

    Route::get('safariTimeslotsTransportationtype','Admin\Safari\SafariTimeslotsTransportationtypeController@getSafariTimeslotsTransportationtype')->name('getSafariTimeslotsTransportationtype');
    Route::get('addSafariTimeslotsTransportationtype', 'Admin\Safari\SafariTimeslotsTransportationtypeController@addSafariTimeslotsTransportationtype')->name('addSafariTimeslotsTransportationtype');
    Route::post('createSafariTimeslotsTransportationtype', 'Admin\Safari\SafariTimeslotsTransportationtypeController@createSafariTimeslotsTransportationtype')->name('createSafariTimeslotsTransportationtype');
    Route::get('editSafariTimeslotsTransportationtype/{safariId}/{transportationId}/{timeslotsId}', 'Admin\Safari\SafariTimeslotsTransportationtypeController@editTimeSafariTimeslotsTransportationtype')->name('editTimeSafariTimeslotsTransportationtype');
    Route::post('updateSafariTimeslotsTransportationtype', 'Admin\Safari\SafariTimeslotsTransportationtypeController@updateSafariTimeslotsTransportationtype')->name('updateSafariTimeslotsTransportationtype');
    Route::get('deleteSafariTimeslotsTransportationtype', 'Admin\Safari\SafariTimeslotsTransportationtypeController@deleteSafariTimeslotsTransportationtype')->name('deleteSafariTimeslotsTransportationtype');
    Route::get('getTransportationVehicle/{safari_id}/{transportation_id}/{timeslot_id}', 'Admin\Safari\SafariTimeslotsTransportationtypeController@getTransportationVehicle')->name('getTransportationVehicle');

  //---------------------Safari Entry Fee------------------------------

    Route::get('safariEntryFee', 'Admin\Safari\SafariEntryFeeController@getsafariEntryFee')->name('getsafariEntryFee');
    Route::get('addsafariEntryFee', 'Admin\Safari\SafariEntryFeeController@addsafariEntryFee')->name('addsafariEntryFee');
    Route::post('createsafariEntryFee', 'Admin\Safari\SafariEntryFeeController@createsafariEntryFee')->name('createsafariEntryFee');
    Route::get('editsafariEntryFee', 'Admin\Safari\SafariEntryFeeController@editsafariEntryFee')->name('editsafariEntryFee');
    Route::post('updatesafariEntryFee', 'Admin\Safari\SafariEntryFeeController@updatesafariEntryFee')->name('updatesafariEntryFee');
    Route::get('deletesafariEntryFee', 'Admin\Safari\SafariEntryFeeController@deletesafariEntryFee')->name('deletesafariEntryFee');

  //-------------------TransportationSafariPrice-------------------------

    Route::get('safariTransportationPrice', 'Admin\Safari\SafariTransportationPriceController@getsafariTransportationPrice')->name('getsafariTransportationPrice');
    Route::get('addSafariTransportationPrice', 'Admin\Safari\SafariTransportationPriceController@addSafariTransportationPrice')->name('addSafariTransportationPrice');
    Route::post('createSafariTransportationPrice', 'Admin\Safari\SafariTransportationPriceController@createSafariTransportationPrice')->name('createSafariTransportationPrice');
    Route::get('editSafariTransportationPrice', 'Admin\Safari\SafariTransportationPriceController@editSafariTransportationPrice')->name('editSafariTransportationPrice');
    Route::post('updateSafariTransportationPrice', 'Admin\Safari\SafariTransportationPriceController@updateSafariTransportationPrice')->name('updateSafariTransportationPrice');
    Route::get('deleteSafariTransportationPrice', 'Admin\Safari\SafariTransportationPriceController@deleteSafariTransportationPrice')->name('deleteSafariTransportationPrice');

  //--------------------- Safari Booking ----------------------

    Route::get('safariBookings', 'Admin\Safari\SafariBookingsController@getSafariBookings')->name('getSafariBookings');
    Route::get('viewSafariBookings/{bookingId}/{userId}', 'Admin\Safari\SafariBookingsController@viewSafariBookings')->name('viewSafariBookings');

  //------------------ SafariTransportation --------------------

    Route::get('getSafariTransportation/{safari_id}', 'Controller@getSafariTransportation')->name('getSafariTransportation');

  //-----------------------EcoTrail TimeSlots-------------------------

    Route::get('ecotrailTimeslots', 'Admin\EcoTrailsTimeSlotsController@getEcotrailTimeslots')->name('getEcotrailTimeslots');
    Route::get('addEcotrailTimeSlots','Admin\EcoTrailsTimeSlotsController@addEcotrailTimeSlots')->name('addEcotrailTimeSlots');
    Route::post('createEcotrailTimeSlots', 'Admin\EcoTrailsTimeSlotsController@createEcotrailTimeSlots')->name('createEcotrailTimeSlots');
    Route::get('editEcotrailTimeSlots', 'Admin\EcoTrailsTimeSlotsController@editEcotrailTimeSlots')->name('editEcotrailTimeSlots');
    Route::post('updateEcotrailTimeSlots', 'Admin\EcoTrailsTimeSlotsController@updateEcotrailTimeSlots')->name('updateEcotrailTimeSlots');
    Route::get('deleteEcotrailTimeSlots', 'Admin\EcoTrailsTimeSlotsController@deleteEcotrailTimeSlots')->name('deleteEcotrailTimeSlots');

  //---------------------EcoTrail Pricing------------------------------

    Route::get('getTrialPricing', 'Admin\TrailPricingController@getTrialPricing')->name('getTrialPricing');
    Route::get('addTrialPricing', 'Admin\TrailPricingController@addTrialPricing')->name('addTrialPricing');
    Route::post('createTrialPricing', 'Admin\TrailPricingController@createTrialPricing')->name('createTrialPricing');
    Route::get('editTrialPricing', 'Admin\TrailPricingController@editTrialPricing')->name('editTrialPricing');
    Route::post('updateTrialPricing', 'Admin\TrailPricingController@updateTrialPricing')->name('updateTrialPricing');
    Route::get('deleteTrialPricing', 'Admin\TrailPricingController@deleteTrialPricing')->name('deleteTrialPricing');

  // ----------------------- Banner Images ---------------------------

    Route::get('bannerImages','Admin\BannerController@getBannerImages')->name('getBannerImages');
    Route::get('addBannerImages','Admin\BannerController@addBannerImages')->name('addBannerImages');
    Route::post('createBannerImages','Admin\BannerController@createBannerImages')->name('createBannerImages');
    Route::get('editBannerImages','Admin\BannerController@editBannerImages')->name('editBannerImages');
    Route::post('updateBannerImages','Admin\BannerController@updateBannerImages')->name('updateBannerImages');
    Route::get('deleteBannerImages','Admin\BannerController@deleteBannerImages')->name('deleteBannerImages');

    // --------------------- Jungle Stay Landscape -----------------------------------
    Route::get('jungleStayLandscapes', 'Admin\JungleStay\JungleStayLandscapeController@getJungleStayLandscapes')->name('getJungleStayLandscapes');
    Route::get('addJungleStayLandscape', function()
    {
        return view('Admin/jungleStay/junglestaylandscape/add');
    });
    Route::post('createJungleStayLandscape', 'Admin\JungleStay\JungleStayLandscapeController@createJungleStayLandscape')->name('createJungleStayLandscape');
    Route::get('editJungleStayLandscape', 'Admin\JungleStay\JungleStayLandscapeController@editJungleStayLandscape')->name('editJungleStayLandscape');
    Route::post('updateJungleStayLandscape', 'Admin\JungleStay\JungleStayLandscapeController@updateJungleStayLandscape')->name('updateJungleStayLandscape');
    Route::get('deleteJungleStayLandscape', 'Admin\JungleStay\JungleStayLandscapeController@deleteJungleStayLandscape')->name('deleteJungleStayLandscape');

    //------------------ Jungle Stay ----------------------
    Route::get('jungleStay','Admin\JungleStay\JungleStayController@getJungleStay')->name('getJungleStay');
    Route::get('addJungleStay','Admin\JungleStay\JungleStayController@addJungleStay')->name('addJungleStay');
    Route::post('createJungleStay','Admin\JungleStay\JungleStayController@createJungleStay')->name('createJungleStay');
    Route::get('editJungleStay','Admin\JungleStay\JungleStayController@editJungleStay')->name('editJungleStay');
    Route::post('updateJungleStay','Admin\JungleStay\JungleStayController@updateJungleStay')->name('updateJungleStay');
    Route::get('deleteJungleStay','Admin\JungleStay\JungleStayController@deleteJungleStay')->name('deleteJungleStay');
    Route::get('deleteJungleStayImages', 'Admin\JungleStay\JungleStayController@deleteJungleStayImages')->name('deleteJungleStayImages');

  //------------------ Jungle Stay Rooms ----------------------
    Route::get('jungleStayRooms','Admin\JungleStay\JungleStayRoomsController@getJungleStayRooms')->name('getJungleStayRooms');
    Route::get('addJungleStayRooms','Admin\JungleStay\JungleStayRoomsController@addJungleStayRooms')->name('addJungleStayRooms');
    Route::post('createJungleStayRooms','Admin\JungleStay\JungleStayRoomsController@createJungleStayRooms')->name('createJungleStayRooms');
    Route::get('editJungleStayRooms','Admin\JungleStay\JungleStayRoomsController@editJungleStayRooms')->name('editJungleStayRooms');
    Route::post('updateJungleStayRooms','Admin\JungleStay\JungleStayRoomsController@updateJungleStayRooms')->name('updateJungleStayRooms');
    Route::get('deleteJungleStayRooms','Admin\JungleStay\JungleStayRoomsController@deleteJungleStayRooms')->name('deleteJungleStayRooms');
    Route::get('deleteJungleStayRoomsImages', 'Admin\JungleStay\JungleStayRoomsController@deleteJungleStayRoomsImages')->name('deleteJungleStayRoomsImages');

  //------------------ Jungle Stay Rooms Price----------------------
    Route::get('jungleStayRoomsPrice','Admin\JungleStay\JungleStayRoomsPriceController@getJungleStayRoomsPrice')->name('getJungleStayRoomsPrice');
    Route::get('addJungleStayRoomsPrice','Admin\JungleStay\JungleStayRoomsPriceController@addJungleStayRoomsPrice')->name('addJungleStayRoomsPrice');
    Route::post('createJungleStayRoomsPrice','Admin\JungleStay\JungleStayRoomsPriceController@createJungleStayRoomsPrice')->name('createJungleStayRoomsPrice');
    Route::get('editJungleStayRoomsPrice','Admin\JungleStay\JungleStayRoomsPriceController@editJungleStayRoomsPrice')->name('editJungleStayRoomsPrice');
    Route::post('updateJungleStayRoomsPrice','Admin\JungleStay\JungleStayRoomsPriceController@updateJungleStayRoomsPrice')->name('updateJungleStayRoomsPrice');
    Route::get('deleteJungleStayRoomsPrice','Admin\JungleStay\JungleStayRoomsPriceController@deleteJungleStayRoomsPrice')->name('deleteJungleStayRoomsPrice');
    Route::get('getJungleStayRooms/{jungleStayId}','Admin\JungleStay\JungleStayRoomsPriceController@getJungleStayRooms')->name('getJungleStayRooms');

  //--------------------- Jungle Stay Bookings ----------------------

    Route::get('jungleStayBookings', 'Admin\JungleStay\JungleStayBookingsController@getJungleStayBookings')->name('getJungleStayBookings');
    Route::get('viewJungleStayBookings/{bookingId}/{userId}', 'Admin\JungleStay\JungleStayBookingsController@viewJungleStayBookings')->name('viewJungleStayBookings');

    //------------------ Bird Sanctuary ----------------------
    Route::get('birdSanctuary','Admin\BirdSanctuary\BirdSanctuaryController@getBirdSanctuary')->name('getBirdSanctuary');
    Route::get('addBirdSanctuary','Admin\BirdSanctuary\BirdSanctuaryController@addBirdSanctuary')->name('addBirdSanctuary');
    Route::post('createBirdSanctuary','Admin\BirdSanctuary\BirdSanctuaryController@createBirdSanctuary')->name('createBirdSanctuary');
    Route::get('editBirdSanctuary','Admin\BirdSanctuary\BirdSanctuaryController@editBirdSanctuary')->name('editBirdSanctuary');
    Route::post('updateBirdSanctuary','Admin\BirdSanctuary\BirdSanctuaryController@updateBirdSanctuary')->name('updateBirdSanctuary');
    Route::get('deleteBirdSanctuary','Admin\BirdSanctuary\BirdSanctuaryController@deleteBirdSanctuary')->name('deleteBirdSanctuary');
    Route::get('deleteBirdSanctuaryImages', 'Admin\BirdSanctuary\BirdSanctuaryController@deleteBirdSanctuaryImages')->name('deleteBirdSanctuaryImages');

  //------------------ Bird Sanctuary Entry Fee ----------------------
    Route::get('birdSanctuaryPrice/{birdSanctuary}','Admin\BirdSanctuary\BirdSanctuaryPriceController@getBirdSanctuaryPrice')->name('getBirdSanctuaryPrice');
    Route::get('addBirdSanctuaryPrice/{birdSanctuary}','Admin\BirdSanctuary\BirdSanctuaryPriceController@addBirdSanctuaryPrice')->name('addBirdSanctuaryPrice');
    Route::post('createBirdSanctuaryPrice','Admin\BirdSanctuary\BirdSanctuaryPriceController@createBirdSanctuaryPrice')->name('createBirdSanctuaryPrice');
    // Route::get('editBirdSanctuaryPrice','Admin\BirdSanctuary\BirdSanctuaryPriceController@editBirdSanctuaryPrice')->name('editBirdSanctuaryPrice');
    // Route::post('updateBirdSanctuaryPrice','Admin\BirdSanctuary\BirdSanctuaryPriceController@updateBirdSanctuaryPrice')->name('updateBirdSanctuaryPrice');
    // Route::get('deleteBirdSanctuaryPrice','Admin\BirdSanctuary\BirdSanctuaryPriceController@deleteBirdSanctuaryPrice')->name('deleteBirdSanctuaryPrice');

  //------------------ Bird Sanctuary Boat Types----------------------
    Route::get('boatType','Admin\BirdSanctuary\BoatTypeController@getBoatType')->name('getBoatType');
    Route::get('addBoatType','Admin\BirdSanctuary\BoatTypeController@addBoatType')->name('addBoatType');
    Route::post('createBoatType','Admin\BirdSanctuary\BoatTypeController@createBoatType')->name('createBoatType');
    Route::get('editBoatType','Admin\BirdSanctuary\BoatTypeController@editBoatType')->name('editBoatType');
    Route::post('updateBoatType','Admin\BirdSanctuary\BoatTypeController@updateBoatType')->name('updateBoatType');
    Route::get('deleteBoatType','Admin\BirdSanctuary\BoatTypeController@deleteBoatType')->name('deleteBoatType');
    Route::get('getBirdSanctuary/{parkId}','Admin\BirdSanctuary\BoatTypeController@getBirdSanctuary')->name('getBirdSanctuary');

  //------------------ Bird Sanctuary Boat Type Price----------------------
    Route::get('birdSanctuaryList/{requestFrom?}','Admin\BirdSanctuary\BoatTypePriceController@birdSanctuaryList')->name('birdSanctuaryList');

    Route::get('boatTypePrice/{birdSanctuaryId}','Admin\BirdSanctuary\BoatTypePriceController@getBoatTypePrice')->name('getBoatTypePrice');
    Route::get('addBoatTypePrice/{birdSanctuaryId}','Admin\BirdSanctuary\BoatTypePriceController@addBoatTypePrice')->name('addBoatTypePrice');
    Route::post('createBoatTypePrice','Admin\BirdSanctuary\BoatTypePriceController@createBoatTypePrice')->name('createBoatTypePrice');
    // Route::get('editBoatTypePrice','Admin\BirdSanctuary\BoatTypePriceController@editBoatTypePrice')->name('editBoatTypePrice');
    // Route::post('updateBoatTypePrice','Admin\BirdSanctuary\BoatTypePriceController@updateBoatTypePrice')->name('updateBoatTypePrice');
    // Route::get('deleteBoatTypePrice','Admin\BirdSanctuary\BoatTypePriceController@deleteBoatTypePrice')->name('deleteBoatTypePrice');
    Route::get('getBoatTypes/{birdSanctuaryId}','Admin\BirdSanctuary\BoatTypePriceController@getBoatTypes')->name('getBoatTypes');

  //------------------ Bird Sanctuary Parking Types----------------------
    Route::get('parkingType','Admin\BirdSanctuary\ParkingTypeController@getParkingType')->name('getParkingType');
    Route::get('addParkingType','Admin\BirdSanctuary\ParkingTypeController@addParkingType')->name('addParkingType');
    Route::post('createParkingType','Admin\BirdSanctuary\ParkingTypeController@createParkingType')->name('createParkingType');
    Route::get('editParkingType','Admin\BirdSanctuary\ParkingTypeController@editParkingType')->name('editParkingType');
    Route::post('updateParkingType','Admin\BirdSanctuary\ParkingTypeController@updateParkingType')->name('updateParkingType');
    Route::get('deleteParkingType','Admin\BirdSanctuary\ParkingTypeController@deleteParkingType')->name('deleteParkingType');

  //------------------ Bird Sanctuary Parking Vehicle Types----------------------
    Route::get('parkingVehicleType','Admin\BirdSanctuary\ParkingVehicleTypeController@getParkingVehicleType')->name('getParkingVehicleType');
    Route::get('addParkingVehicleType','Admin\BirdSanctuary\ParkingVehicleTypeController@addParkingVehicleType')->name('addParkingVehicleType');
    Route::post('createParkingVehicleType','Admin\BirdSanctuary\ParkingVehicleTypeController@createParkingVehicleType')->name('createParkingVehicleType');
    Route::get('editParkingVehicleType','Admin\BirdSanctuary\ParkingVehicleTypeController@editParkingVehicleType')->name('editParkingVehicleType');
    Route::post('updateParkingVehicleType','Admin\BirdSanctuary\ParkingVehicleTypeController@updateParkingVehicleType')->name('updateParkingVehicleType');
    Route::get('deleteParkingVehicleType','Admin\BirdSanctuary\ParkingVehicleTypeController@deleteParkingVehicleType')->name('deleteParkingVehicleType');

  //------------------ Bird Sanctuary Parking Fee ----------------------
    Route::get('parkingFee/{birdSanctuaryId}','Admin\BirdSanctuary\ParkingFeeController@getParkingFee')->name('getParkingFee');
    Route::get('addParkingFee/{birdSanctuaryId}','Admin\BirdSanctuary\ParkingFeeController@addParkingFee')->name('addParkingFee');
    Route::post('createParkingFee','Admin\BirdSanctuary\ParkingFeeController@createParkingFee')->name('createParkingFee');
    // Route::get('editParkingFee','Admin\BirdSanctuary\ParkingFeeController@editParkingFee')->name('editParkingFee');
    // Route::post('updateParkingFee','Admin\BirdSanctuary\ParkingFeeController@updateParkingFee')->name('updateParkingFee');
    // Route::get('deleteParkingFee','Admin\BirdSanctuary\ParkingFeeController@deleteParkingFee')->name('deleteParkingFee');
    Route::get('getParkingDetails/{birdSanctuaryId}','Admin\BirdSanctuary\ParkingFeeController@getParkingDetails')->name('getParkingDetails');

  //------------------ Bird Sanctuary Camera Types ----------------------
    Route::get('cameraType','Admin\BirdSanctuary\CameraTypeController@getCameraType')->name('getCameraType');
    Route::get('addCameraType','Admin\BirdSanctuary\CameraTypeController@addCameraType')->name('addCameraType');
    Route::post('createCameraType','Admin\BirdSanctuary\CameraTypeController@createCameraType')->name('createCameraType');
    Route::get('editCameraType','Admin\BirdSanctuary\CameraTypeController@editCameraType')->name('editCameraType');
    Route::post('updateCameraType','Admin\BirdSanctuary\CameraTypeController@updateCameraType')->name('updateCameraType');
    Route::get('deleteCameraType','Admin\BirdSanctuary\CameraTypeController@deleteCameraType')->name('deleteParkingType');

  //------------------ Bird Sanctuary Camera Fee ----------------------
    Route::get('cameraFee/{birdSanctuaryId}','Admin\BirdSanctuary\CameraFeeController@getCameraFee')->name('getCameraFee');
    Route::get('addCameraFee/{birdSanctuaryId}','Admin\BirdSanctuary\CameraFeeController@addCameraFee')->name('addCameraFee');
    Route::post('createCameraFee','Admin\BirdSanctuary\CameraFeeController@createCameraFee')->name('createCameraFee');
    // Route::get('editCameraFee','Admin\BirdSanctuary\CameraFeeController@editCameraFee')->name('editCameraFee');
    // Route::post('updateCameraFee','Admin\BirdSanctuary\CameraFeeController@updateCameraFee')->name('updateCameraFee');
    // Route::get('deleteCameraFee','Admin\BirdSanctuary\CameraFeeController@deleteCameraFee')->name('deleteParkingFee');
    Route::get('getCameraTypes/{birdSanctuaryId}','Admin\BirdSanctuary\CameraFeeController@getCameraTypes')->name('getCameraTypes');

  //----------------------- Bird Sanctuary TimeSlots-------------------------

    Route::get('BStimeslots', 'Admin\BirdSanctuary\BSTimeSlotsController@getBSTimeSlots')->name('getBSTimeSlots');
    Route::get('addBSTimeSlots', function()
    {
        return view('Admin/birdSanctuary/BStimeslots/add');
    });
    Route::post('createBSTimeSlots', 'Admin\BirdSanctuary\BSTimeSlotsController@createBSTimeSlots')->name('createBSTimeSlots');
    Route::get('editBSTimeSlots', 'Admin\BirdSanctuary\BSTimeSlotsController@editBSTimeSlots')->name('editBSTimeSlots');
    Route::post('updateBSTimeSlots', 'Admin\BirdSanctuary\BSTimeSlotsController@updateBSTimeSlots')->name('updateBSTimeSlots');
    Route::get('deleteBSTimeSlots', 'Admin\BirdSanctuary\BSTimeSlotsController@deleteBSTimeSlots')->name('deleteBSTimeSlots');

  //----------------------- Bird Sanctuary TimeSlots Mapping -------------------------

    Route::get('BStimeslotsMapping','Admin\BirdSanctuary\BSTimeSlotsMappingController@getBSTimeSlotsMapping')->name('getBSTimeSlotsMapping');
    Route::get('addBSTimeSlotsMapping','Admin\BirdSanctuary\BSTimeSlotsMappingController@addBSTimeSlotsMapping')->name('addBSTimeSlotsMapping');
    Route::post('createBSTimeSlotsMapping','Admin\BirdSanctuary\BSTimeSlotsMappingController@createBSTimeSlotsMapping')->name('createBSTimeSlotsMapping');
    Route::get('editBSTimeSlotsMapping','Admin\BirdSanctuary\BSTimeSlotsMappingController@editBSTimeSlotsMapping')->name('editBSTimeSlotsMapping');
    Route::post('updateBSTimeSlotsMapping','Admin\BirdSanctuary\BSTimeSlotsMappingController@updateBSTimeSlotsMapping')->name('updateBSTimeSlotsMapping');
    Route::get('deleteBSTimeSlotsMapping','Admin\BirdSanctuary\BSTimeSlotsMappingController@deleteBSTimeSlotsMapping')->name('deleteBSTimeSlotsMapping');
    Route::get('getBoatTimeSlots/{birdSanctuaryId}/{boatTypeId}','Admin\BirdSanctuary\BSTimeSlotsMappingController@getBoatTimeSlots')->name('getBoatTimeSlots');

  //--------------------- Bird Sanctuary Bookings ----------------------

    Route::get('birdSanctuaryBookings', 'Admin\BirdSanctuary\BirdSanctuaryBookingsController@getBirdSanctuaryBookings')->name('getBirdSanctuaryBookings');
    Route::get('viewBirdSanctuaryBookings/{bookingId}/{userId}', 'Admin\BirdSanctuary\BirdSanctuaryBookingsController@viewBirdSanctuaryBookings')->name('viewBirdSanctuaryBookings');

  //--------------------- Birds Fest ----------------------------------

    Route::get('birdsFest','Admin\BirdsFest\BirdsFestController@getBirdsFest')->name('getBirdsFest');
    Route::get('addBirdsFest','Admin\BirdsFest\BirdsFestController@addBirdsFest')->name('addBirdsFest');
    Route::post('createBirdsFest','Admin\BirdsFest\BirdsFestController@createBirdsFest')->name('createBirdsFest');
    Route::get('editBirdsFest','Admin\BirdsFest\BirdsFestController@editBirdsFest')->name('editBirdsFest');
    Route::post('updateBirdsFest','Admin\BirdsFest\BirdsFestController@updateBirdsFest')->name('updateBirdsFest');
    Route::get('deleteBirdsFest','Admin\BirdsFest\BirdsFestController@deleteBirdsFest')->name('deleteBirdsFest');
    Route::get('deleteBirdsFestImages', 'Admin\BirdsFest\BirdsFestController@deleteBirdsFestImages')->name('deleteBirdsFestImages');

    //Pricing
    Route::get('addEventPricing','Admin\BirdsFest\PricingController@addEventPricing')->name('addEventPricing');
    Route::post('saveEventPricing','Admin\BirdsFest\PricingController@saveEventPricing')->name('saveEventPricing');

});

// --------------------------- Website ----------------------------------------

Route::group(['middleware'=>['before','after']], function()
{
  Route::get('/', 'HomeController@index')->name('home');


  // Ecotrip
  Route::get('/landscapes', 'LandscapeController@index')->name('landscapes');
  Route::post('/trails/{landscapeId}/filteredTrails', 'TrailController@getFilteredTrails')->name('landscapes');
  Route::get('/trails/{landscapeId}/{landscapeName}', 'TrailController@getTrails')->name('landscapes');
  Route::get('/trailDetail/{trekId}/{trekName}', 'TrailController@getTrailDetails')->name('getTrailDetails');
  Route::post('/checkAvailability/{trekId}/{trekName}', 'TrailController@checkAvailability')->name('checkAvailability');

  Route::get('/getTrekkersDetails', 'TrailController@getTrekkersDetails')->name('getTrekkersDetails');

  Route::post('/initiateBooking', 'TrailController@initiateBooking')->name('initiateBooking');
  // Route::post('/ecotrails/responseReceiver', 'TrailController@responseReceiver')->name('responseReceiver');
  Route::post('/ecotrails/responseReceiver', 'TrailController@sbiResponseReceiver')->name('sbiResponseReceiver');
  Route::get('/qrCode/{type}/{bookingId}', 'TrailController@qrCode')->name('qrCode');

  //Ticket request
  Route::post('ticketRequest', 'SubscribeController@contactUsMail')->name('ticketRequest');


  Route::get('/subCategory', function () {
      return view('ecotrails/subCategory');
  });

  Route::get('/comingSoon', function () {
      return view('static/comingSoon');
  });

  //G+
  Route::get('redirect/{provider}','SocialController@socialRedirect');
  Route::get('socialAuthreciever/{provider}', 'SocialController@socialAuthreciever')->name('socialAuthreciever');
  Route::post('socialSignUp', 'SocialController@socialSignUp');
  // Events
  // AITE Volunteers Registration
  Route::get('/AITE-Registration','Events\AITEController@register')->name('AITE-Registration');
  Route::post('/registerAITE','Events\AITEController@registerAITE')->name('registerAITE');

  Route::get('/eventsList','Events\EventsController@eventsList')->name('eventsList');
  Route::get('/eventDetails/{eventId}/{eventTypeId}/{eventName}', 'Events\EventsController@getEventDetails')->name('eventDetails');
  Route::get('/eventDetails/getRemaningSlotDropdown/{remaningSlots}', 'Events\EventsController@getRemaningSlotDropdown')->name('getRemaningSlotDropdown');
  Route::post('/eventDetails/eventCheckAvailability/{eventName}', 'Events\EventsController@eventCheckAvailability')->name('eventCheckAvailability');
  Route::post('/eventDetails/initiateEventBooking', 'Events\EventsController@initiateEventBooking')->name('initiateEventBooking');
  // Route::post('/eventDetails/responseReceiver', 'Events\EventsController@responseReceiver')->name('responseReceiver');
  Route::post('/eventDetails/responseReceiver', 'Events\EventsController@sbiResponseReceiver')->name('sbiResponseReceiver');


  Route::post('/userSignUp','UserController@userSignUp')->name('userSignUp');
  Route::post('/userSignIn','UserController@userSignIn')->name('userSignIn');
  Route::get('/signOut','UserController@signOut')->name('signOut');
  Route::post('/subscribe','SubscribeController@subscribe')->name('subscribe');
  Route::post('/contactUsMail','SubscribeController@contactUsMail')->name('contactUsMail');
  Route::get('/userProfile','UserController@userProfile')->name('userProfile');
  Route::post('/updateProfile','UserController@updateProfile')->name('updateProfile');
  Route::post('/passwordUpdate','UserController@updatePassword')->name('updatePassword');

  Route::get('/userBookingHistory','UserController@userBookingHistory')->name('userBookingHistory');
  Route::get('/resendTrailTicket/{bookingId}/{requestFrom?}','TrailController@sendTrailTicket')->name('resendTrailTicket');

  // Static pages
  Route::get('/contactUs','StaticController@contactUs')->name('contactUs');
  Route::get('/PrivacyPolicy','StaticController@PrivacyPolicy')->name('PrivacyPolicy');
  Route::get('/TermsofUse','StaticController@TermsofUse')->name('TermsofUse');
  Route::get('/frequently-asked-questions','StaticController@faqs')->name('faqs');
  Route::get('/verifyEmailTemplate','StaticController@verifyEmailTemplate')->name('verifyEmailTemplate');
  Route::get('/gallery','StaticController@gallery')->name('gallery');


  Route::get('/karnataka-eco-tourism-development-board','StaticController@kedb')->name('kedb');

  Route::get('/training-and-news','StaticController@trainingNews')->name('training-and-news');

  //Training
  Route::get('/nature-guide','TrainingController@natureGuide')->name('nature-guide');
  Route::get('/naturalists','TrainingController@naturalists')->name('naturalists');
  Route::get('/volunteer','TrainingController@volunteer')->name('volunteer');
  Route::get('/capacity-building-training','TrainingController@capacityTraining')->name('capacityTraining');
  Route::get('/nature-conservation-education-programme','TrainingController@ncep')->name('ncep');
  Route::get('/csr','TrainingController@csr')->name('csr');


  Route::get('verifyUserMail', 'UserController@verifyUserMail');
  Route::get('emailVerify/{userId}', 'UserController@emailVerify');
  Route::get('mobileVerify/{userId}', 'UserController@mobileVerify');
  Route::post('verifyOTP', 'UserController@verifyOTP');
  Route::post('requestForgotPassword', 'UserController@requestForgotPassword');
  Route::post('resetPassword', 'UserController@resetPassword');


  // Wild Life Safari
  Route::get('/safaries', 'SafariController@index')->name('safaries');
  Route::get('/safariDetails/{safariId}/{safariName}', 'SafariController@getSafariDetails')->name('getSafariDetails');
  Route::post('/safariCheckAvailability/{safariId}/{safariName}', 'SafariController@checkAvailability')->name('checkAvailability');
  Route::get('/getVistiorsDetails', 'SafariController@getVistiorsDetails')->name('getVistiorsDetails');

  Route::post('/confirmSafariBooking', 'SafariController@confirmSafariBooking')->name('confirmSafariBooking');
  Route::post('/initiateSafariBooking', 'SafariController@initiateBooking')->name('initiateBooking');
  Route::post('/safari/responseReceiver', 'SafariController@responseReceiver')->name('responseReceiver');

  // ---- TimeSlots For Transportation
  Route::get('/getSafariTimeSlots/{safariId}/{tranportationId}', 'SafariController@getSafariTimeSlots')->name('getSafariTimeSlots');
  Route::get('/getUserDetailsList/{transportationSeats}/{vehicleId}', 'SafariController@getUserDetailsList')->name('getUserDetailsList');

  // Bird Sanctuary
  Route::get('/birdSanctuary', 'BirdSanctuaryController@index')->name('birdSanctuary');
  Route::get('/birdSanctuaryDetails/{birdSanctuaryId}/{birdSanctuaryName}', 'BirdSanctuaryController@getBirdSanctuaryDetails')->name('getBirdSanctuaryDetails');
  Route::post('/birdSanctuaryCheckAvailability/{birdSanctuaryId}/{birdSanctuaryName}', 'BirdSanctuaryController@checkAvailability')->name('checkAvailability');
  Route::get('/birdSanctuaryVistiorsDetails', 'BirdSanctuaryController@birdSanctuaryVistiorsDetails')->name('birdSanctuaryVistiorsDetails');
  Route::get('/getTimeSlots/{boatTypeId}/{birdSanctuaryId}','BirdSanctuaryController@timeSlots')->name('timeSlots');
  Route::get('/getParkingTypeDetails/{birdSanctuaryId}/{parkingTypeId}','BirdSanctuaryController@getParkingTypeDetails')->name('getParkingTypeDetails');

  Route::post('/confirmBirdSanctuaryBooking', 'BirdSanctuaryController@confirmBirdSanctuaryBooking')->name('confirmBirdSanctuaryBooking');
  Route::post('/initiateBirdSanctuaryBooking', 'BirdSanctuaryController@initiateBooking')->name('initiateBooking');
  Route::get('/birdSanctuary/responseReceiver', 'BirdSanctuaryController@responseReceiver')->name('responseReceiver');

  //New bird sanctury flow
  Route::post('/entryDetails/{birdSanctuaryId}/{birdSanctuaryName}', 'BirdSanctuaryController@entryDetails')->name('entryDetails');




  // JungleStay

    Route::get('/JungleStayLandscapes', 'JungleStayWebLandscapeController@index')->name('JungleStayLandscapes');
    Route::get('/junglestays/{landscapeId}/{landscapeName}', 'JungleStayWebLandscapeController@getJungleStays')->name('getJungleStays');
    Route::get('/junglestayDetail/{stayId}/{stayName}', 'JungleStayWebLandscapeController@getJungleStaysDetails')->name('getJungleStaysDetails');
    Route::post('/junglestaycheckAvailability/{stayId}/{stayName}', 'JungleStayWebLandscapeController@junglestaycheckAvailability')->name('junglestaycheckAvailability');
    Route::get('/jungleStayVisitorDetails', 'JungleStayWebLandscapeController@jungleStayVisitorDetails')->name('jungleStayVisitorDetails');
    Route::post('/confirmjungleStayBooking', 'JungleStayWebLandscapeController@confirmjungleStayBooking')->name('confirmjungleStayBooking');
    Route::post('/initiateJungleStayBooking', 'JungleStayWebLandscapeController@initiateJungleStayBooking')->name('initiateJungleStayBooking');
    Route::get('/junglestays/responseReceiver', 'JungleStayWebLandscapeController@responseReceiver')->name('responseReceiver');

});


Route::get('/sendOldMail/{date}' , 'TrailBookingController@sendOldMail');
Route::get('/sendSMS/{mobileNo}/{Message}','Controller@sendSMS');

// CRON
Route::get('/smsReport' , 'CronController@smsReport');
Route::get('/trailEmailReports' , 'CronController@trailEmailReports');
Route::get('/bsDialySmsReport' , 'CronController@bsDialySmsReport');
Route::get('/bsDialySyncAlert' , 'CronController@bsDialySyncAlert');



// log
Route::get('/log' , 'Controller@writeLogTest');
Route::get('/testMail' , 'TrailBookingController@testMail');



Route::get('sendTestEmail', 'Controller@sendTestEmail');
