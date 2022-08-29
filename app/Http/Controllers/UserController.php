<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Log;

use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $success['content'] = array();

        // Log::info('Hello world!');
        return $success;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userSignUp(Request $request)
    {
        $success = \Config::get('common.create_success_response');
        $failure = \Config::get('common.create_failure_response');
        $sessionData = session()->all();

        $content = $request->all();

        // echo "<pre>";print_r($request->session()->all()) ;exit();
        if($content['sign_in_with'] == 'myecotrip'){

            //your site secret key
            $secret = '6Lcz24IUAAAAAJz7C1kpAUG4Q9WQEws8N36SE47G';

            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);

            if(!$responseData->success){
                Session::flash('message', 'Sorry could not process!!');
                Session::flash('alert-class', 'alert-danger');
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }

            $validator = \Validator::make($request->all(), [
                'first_name'   => 'required',
                'email'   => 'required',
                'contact_no' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                $failure['content'] = $validator->errors();
                $failure['response']['sys_msg'] = "Invalid Payload";
                return $failure;
            }else{
                try{
                    // check for the email already exist
                    $checkEmail = \App\User::where('email',$content['email'])->get()->toArray();

                    if(count($checkEmail) > 0){
                        $failure['response']['message'] = "Sorry this email is registered already!!";

                        Session::flash('message', 'Sorry this email is registered already!!');
                        Session::flash('alert-class', 'alert-danger');

                        if(isset($sessionData['safariDetailURL'])){
                            return \Redirect::to($sessionData['safariDetailURL']);
                        }

                        $data =  $request->session()->get('_previous');
                        return \Redirect::to($data['url']);
                    }else{
                        $content['password'] = md5($content['password']);
                        $create  = \App\User::create($content);

                        $email = $create->email;
                        $toName = $create->first_name;
                        $subject = 'Myecotrip - Email Verification';
                        $attachements = [];

                        $userInfo['id'] = $create->id;
                        $userInfo['email'] = $create->email;
                        $userInfo['first_name'] = $create->first_name;
                        $userInfo['last_name'] = $create->last_name;
                        $body = \View::make('static.verifyEmailTemplate', ['userInfo' => $userInfo]);

                        $sendMail = $this->sendEmail($email, $toName,[], $subject, $body, $attachements);

                        Session::flash('message', 'An email has been sent to your email. Please verify it before booking any of the services.');
                        Session::flash('alert-class', 'alert-success');

                        if(isset($sessionData['safariDetailURL'])){
                            return \Redirect::to($sessionData['safariDetailURL']);
                        }

                        $data =  $request->session()->get('_previous');
                        return \Redirect::to($data['url']);
                    }

                }catch(\Exception $e ){
                    $failure['response']['message'] = "Sorry could not insert.";
                    $failure['response']['sys_msg'] = $e->getMessage();

                    Session::flash('message', 'Sorry could not Register.');
                    Session::flash('alert-class', 'alert-danger');

                    if(isset($sessionData['safariDetailURL'])){
                        return \Redirect::to($sessionData['safariDetailURL']);
                    }

                    $data =  $request->session()->get('_previous');
                    return \Redirect::to($data['url']);
                }
            }

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function userSignIn(Request $request)
    {
        $success = \Config::get('common.login_success_response');
        $failure = \Config::get('common.login_failure_response');

        $content = $request->all();
        $sessionData = session()->all();

        // echo "<pre>";print_r($sessionData);exit();
        if($content['loginType'] == 'myecotrip'){

            $validator = \Validator::make($request->all(), [
                'loginType'   => 'required',
                'userName'   => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                $failure['content'] = $validator->errors();
                $failure['response']['sys_msg'] = "Invalid Payload";

                Session::flash('message', 'Invalid Payload');
                Session::flash('alert-class', 'alert-danger');

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);

            }else{
                try{
                    // check for the email already exist
                    $checkEmail = \App\User::where('email',$content['userName'])->get()->toArray();

                    if(count($checkEmail) > 0){
                        $password = md5($content['password']);

                        $checkUser  = \App\User::where('email',$content['userName'])
                                                ->where('password', $password)
                                                ->get()
                                                ->toArray();

                        if (count($checkUser) > 0) {

                            // Set user session data
                            session(['userId' => $checkUser[0]['id']]);
                            session(['userName' => $checkUser[0]['first_name']]);
                            session(['emailVerified' => $checkUser[0]['email_verified']]);
                            session(['phoneVerified' => $checkUser[0]['phone_verified']]);

                            //For safari detail page
                            if(isset($sessionData['safariDetailURL'])){
                                return \Redirect::to($sessionData['safariDetailURL']);
                            }

                            $data =  $request->session()->get('_previous');

                            return \Redirect::to($data['url']);
                        }else{
                            $failure['response']['message'] = "Sorry credentials did not match !!";

                            Session::flash('message', 'Sorry credentials did not match !!');
                            Session::flash('alert-class', 'alert-danger');

                            //For safari detail page
                            if(isset($sessionData['safariDetailURL'])){
                                return \Redirect::to($sessionData['safariDetailURL']);
                            }
                            $data =  $request->session()->get('_previous');
                            return \Redirect::to($data['url']);

                        }
                    }else{

                        $failure['response']['message'] = "Sorry this email is not registered !! Please Sign up.";

                        Session::flash('message', 'Sorry this email is not registered !! Please Sign up.');
                        Session::flash('alert-class', 'alert-danger');

                        //For safari detail page
                        if(isset($sessionData['safariDetailURL'])){
                            return \Redirect::to($sessionData['safariDetailURL']);
                        }

                        $data =  $request->session()->get('_previous');
                        return \Redirect::to($data['url']);
                    }

                }catch(\Exception $e ){

                    $failure['response']['message'] = "Sorry could not insert.";
                    $failure['response']['sys_msg'] = $e->getMessage();
                    // return $failure;

                    Session::flash('message', 'Sorry could not Register.');
                    Session::flash('alert-class', 'alert-danger');

                    //For safari detail page
                    if(isset($sessionData['safariDetailURL'])){
                        return \Redirect::to($sessionData['safariDetailURL']);
                    }

                    $data =  $request->session()->get('_previous');
                    return \Redirect::to($data['url']);
                }
            }
        }
    }

    public function signOut(Request $request)
    {
        $fullSecssiondata = session()->all();

        session()->forget('userId');
        session()->forget('userName');
        session()->forget('bookingData');
        session()->forget('safariDetailURL');
        session()->forget('eventDetailURL');

        if(isset($fullSecssiondata['safariDetailURL'])){
            return \Redirect::to(url('/') . '/safaries');
        }

        if(isset($fullSecssiondata['eventDetailURL'])){
            return \Redirect::to($fullSecssiondata['eventDetailURL']);
        }

        $data =  $request->session()->get('_previous');

        // remove all session data
        $request->session()->flush();

        if( strpos( $data['url'], 'getTrekkersDetails' ) !== false ) {
            return \Redirect::to(url('/').'/landscapes');
        }else if( strpos( $data['url'], 'getVistiorsDetails' ) !== false ) {
            return \Redirect::to(url('/').'/safaries');
        }else if( strpos( $data['url'], 'jungleStayVisitorDetails' ) !== false ) {
            return \Redirect::to(url('/').'/JungleStayLandscapes');
        }else{
            return redirect('/');
            // return \Redirect::to($data['url']);
        }
    }

    public function userProfile(Request $request)
    {
        if ($request->session()->get('userId')) {
            $userId = $request->session()->get('userId');

            $getUserInfo = \App\User::where('id',$userId)->get()->toArray();

            // echo "<pre>";print_r($getUserInfo);exit();
            return view('User/profile', ['userInfo'=> $getUserInfo[0]]);
        }else{
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function updateProfile(Request $request)
    {
        $success = \Config::get('common.update_success_response');
        $failure = \Config::get('common.update_failure_response');

        // Read form data
        $content      = $_POST;

        $validator = \Validator::make($content, [
            'id'   => 'required',
            'first_name'   => 'required',
            'last_name'   => 'required',
            'contact_no'   => 'required',
            'country'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash('profileUpdateMessage', $validator->errors());
            Session::flash('alert-class', 'alert-danger');

            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }else{
            try{
                $updateUser = \App\User::where('id', [$content['id']])->update($content);

                session(['userName' => $content['first_name']]);

                Session::flash('profileUpdateMessage', 'Your profile updated successfully');
                Session::flash('alert-class', 'alert-success');

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);

            }catch(\Exception $e ){
                Session::flash('profileUpdateMessage', $e->getMessage());
                Session::flash('alert-class', 'alert-danger');

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }
        }
    }

    public function updatePassword(Request $request)
    {
        $success = \Config::get('common.update_success_response');
        $failure = \Config::get('common.update_failure_response');

        // Read form data
        $content      = $_POST;

        $validator = \Validator::make($content, [
            'id'   => 'required',
            'currentPass'   => 'required',
            'newPassword'   => 'required',
            'newPassword2'   => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash('passwordUpdateMessage', $validator->errors());
            Session::flash('alert-class', 'alert-danger');

            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }else{
            try{
                $checkOldPass = \App\User::where('id', [$content['id']])
                                        ->where('password', md5($content['currentPass']))
                                        ->get()
                                        ->toArray();

                if (count($checkOldPass) > 0) {
                    $update['password'] = md5($content['newPassword']);

                    $updatePass = \App\User::where('id', [$content['id']])
                                        ->update($update);

                    Session::flash('passwordUpdateMessage', 'Password updated successfully');
                    Session::flash('alert-class', 'alert-success');

                    $data =  $request->session()->get('_previous');
                    return \Redirect::to($data['url']);
                }else{
                    Session::flash('passwordUpdateMessage', 'Current password do not match');
                    Session::flash('alert-class', 'alert-danger');

                    $data =  $request->session()->get('_previous');
                    return \Redirect::to($data['url']);
                }

            }catch(\Exception $e ){
                Session::flash('passwordUpdateMessage', $e->getMessage());
                Session::flash('alert-class', 'alert-danger');

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }
        }
    }

    public function userBookingHistory(Request $request)
    {
        $success    = \Config::get('common.retrieve_success_response');
        $failure    = \Config::get('common.retrieve_failure_response');


        try{

            if ($request->session()->get('userId')) {
                $userId = $request->session()->get('userId');

                $getUserInfo = \App\User::where('id',$userId)->get()->toArray();

                $getBookings = \App\TrailBooking::where('user_id',$userId)
                            ->join('trails', 'trails.id','=','trailBooking.trail_id')
                            ->where('booking_status','Success')
                            ->select('trailBooking.*','trails.name as trailName')
                            ->orderBy('trailBooking.id', 'desc')
                            ->get()
                            ->toArray();


                $jsBookings = \App\JungleStay\Booking::where('user_id',$userId)
                            ->join('jungle_stays', 'jungle_stays.id','=','js_bookings.js_id')
                            ->where('booking_status','Success')
                            ->select('js_bookings.*','jungle_stays.name as name')
                            ->orderBy('js_bookings.id', 'desc')
                            ->get()
                            ->toArray();


                // echo "<pre>";print_r($jsBookings);exit();
                return view('User/bookings', ['bookings'=> $getBookings, 'userInfo' => $getUserInfo[0], 'jsBookings' => $jsBookings]);
            }else{
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }
        }catch(\Exception $e ){
            Session::flash('bookingMess', $e->getMessage());
            Session::flash('alert-class', 'alert-danger');

            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function verifyUserMail(Request $request)
    {
        // Read form data
        $content = $_GET;

        try{
            $id = $content['id'];
            $email = $content['ticket'];

            $getUserInfo = \App\User::where('id',$id)->get()->toArray();

            if (count($getUserInfo) > 0) {
                if ($email == md5($getUserInfo[0]['email'])) {
                    // update the user
                    $updateContent['email_verified'] = 1;
                    $update = \App\User::where('id', $id)->update($updateContent);

                    return view('static/success', ['userInfo'=> $getUserInfo[0]]);
                }else{
                    // Failure page
                    return view('static/failure', ['userInfo'=> $getUserInfo[0]]);
                }
            }else{
                // Failure page
                return view('static/failure', ['userInfo'=> $getUserInfo[0]]);

            }
        }catch(\Exception $e ){
            Session::flash('bookingMess', $e->getMessage());
            Session::flash('alert-class', 'alert-danger');

            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function emailVerify(Request $request, $userId)
    {
        try{

            $getUserInfo = \App\User::where('id',$userId)->get()->toArray();

            if (count($getUserInfo) > 0) {
                //Send email
                // $body = \View::make('payment.trailMailTemplate', ['bookingData' => $bookingData[0], 'trailData' => $trailData[0]]);
                $body = \View::make('static.verifyEmailTemplate', ['userInfo' => $getUserInfo[0]]);

                // echo $body;exit();
                $email = $getUserInfo[0]['email'];
                $toName = $getUserInfo[0]['first_name'];
                $subject = 'Myecotrip - Email Verification';
                $attachements = [];

                $sendMail = $this->sendEmail($email, $toName,[], $subject, $body, $attachements);

                Session::flash('verificationMess', 'An email has been sent to your email. Please check mail for verification mail.');
                Session::flash('alert-class', 'alert-success');

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }else{
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }
        }catch(\Exception $e ){
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function mobileVerify(Request $request, $userId)
    {
        try{
            $getUserInfo = \App\User::where('id',$userId)->get()->toArray();

            if (count($getUserInfo) > 0) {
                $otp = rand(100000, 999999);
                $message = "Dear Customer, OTP for validation of your mobile number with Myecotrip is " . $otp;

                $sendSMS = $this->sendSMS($getUserInfo[0]['contact_no'], $message);

                $updateContent['otp'] = $otp;
                $saveOtp = \App\User::where('id',$userId)->update($updateContent);

                Session::flash('sentOtp', 'Otp successfully sent to '.$getUserInfo[0]['contact_no']);
                Session::flash('alert-class', 'alert-success');

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }else{
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }
        }catch(\Exception $e ){
            Session::flash('sentOtp', $e->getMessage());
            Session::flash('alert-class', 'alert-danger');

            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function verifyOTP(Request $request)
    {
        try{
            $data = $_POST;

            $getUserInfo = \App\User::where('id',$data['userId'])->where('otp', trim($data['otp']))->get()->toArray();

            if (count($getUserInfo) > 0) {
                // Validation successfull
                $updateContent['phone_verified'] = 1;
                $update = \App\User::where('id', $data['userId'])->update($updateContent);

                Session::flash('verificationMess', 'Mobile verification completed!!');
                Session::flash('alert-class', 'alert-success');

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }else{
                Session::flash('sentOtp', 'Sorry!! Invalid OTP');
                Session::flash('alert-class', 'alert-danger');

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }
        }catch(\Exception $e ){
            Session::flash('sentOtp', $e->getMessage());
            Session::flash('alert-class', 'alert-danger');

            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function requestForgotPassword(Request $request)
    {
        $email = $_POST['email'];

        try{
            $getUserInfo = \App\User::where('email',$email)->get()->toArray();

            if (count($getUserInfo) > 0) {
                $body = \View::make('static.resetPasswordEmailTemplate', ['userInfo' => $getUserInfo[0]]);

                // return $body;
                // echo $body;exit();
                $email = $getUserInfo[0]['email'];
                $toName = $getUserInfo[0]['first_name'];
                $subject = 'Myecotrip - Password reset';
                $attachements = [];

                $sendMail = $this->sendEmail($email, $toName,[], $subject, $body, $attachements);

                Session::flash('message', 'Please login to mail and reset your password');
                Session::flash('alert-class', 'alert-success');

                //For safari detail page
                if(isset($sessionData['safariDetailURL'])){
                    return \Redirect::to($sessionData['safariDetailURL']);
                }

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }else{
                Session::flash('message', 'Sorry this email is not registered !! Please Sign up.');
                Session::flash('alert-class', 'alert-danger');

                //For safari detail page
                if(isset($sessionData['safariDetailURL'])){
                    return \Redirect::to($sessionData['safariDetailURL']);
                }

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }
        }catch(\Exception $e ){
            Session::flash('message', 'Sorry!! Could not process');
            Session::flash('alert-class', 'alert-danger');

            //For safari detail page
            if(isset($sessionData['safariDetailURL'])){
                return \Redirect::to($sessionData['safariDetailURL']);
            }

            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function resetPassword(Request $request)
    {
        // Read form data
        $content = $_POST;

        try{
            $id = $content['id'];
            $email = $content['ticket'];

            $getUserInfo = \App\User::where('id',$id)->get()->toArray();

            if (count($getUserInfo) > 0) {
                if ($email == md5($getUserInfo[0]['email'])) {
                    // update the user
                    $updateContent['password'] = md5($content['resetPassword']);
                    $update = \App\User::where('id', $id)->update($updateContent);

                    // Failure page
                    Session::flash('message', 'Successfully updated password. Please login with new pssword');
                    Session::flash('alert-class', 'alert-success');

                    //For safari detail page
                    if(isset($sessionData['safariDetailURL'])){
                        return \Redirect::to($sessionData['safariDetailURL']);
                    }

                    // $data =  $request->session()->get('_previous');
                    // return \Redirect::to($data['url']);
                    return redirect()->route('home');
                }else{
                    // Failure page
                    Session::flash('message', 'Sorry could not verify email.');
                    Session::flash('alert-class', 'alert-danger');

                    //For safari detail page
                    if(isset($sessionData['safariDetailURL'])){
                        return \Redirect::to($sessionData['safariDetailURL']);
                    }

                    $data =  $request->session()->get('_previous');
                    return \Redirect::to($data['url']);
                }
            }else{
                Session::flash('message', 'Sorry could not verify email.');
                Session::flash('alert-class', 'alert-danger');

                //For safari detail page
                if(isset($sessionData['safariDetailURL'])){
                    return \Redirect::to($sessionData['safariDetailURL']);
                }

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);

            }
        }catch(\Exception $e ){
            Session::flash('bookingMess', $e->getMessage());
            Session::flash('alert-class', 'alert-danger');

            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }


}
