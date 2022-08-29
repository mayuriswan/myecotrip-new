<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Session;

class SocialController extends Controller
{
	public function socialRedirect(Request $request, $provider)
	{
        $data =  $request->session()->get('_previous');
        session(['redirectUrl'=> $data['url']]);

		return \Socialite::driver($provider)->redirect();
	}

    public function socialAuthreciever(Request $request, $provider)		
    {
        $success = \Config::get('common.create_success_response');
        $failure = \Config::get('common.create_failure_response');

        if ($provider == "google") {
            $user = \Socialite::driver('google')->stateless()->user();
        }else{
            $user = \Socialite::driver('facebook')->user();
        }

        // echo "<pre>";
        // print_r($request->session());
        // exit();
        try{

            $email = $user->email;
            // check for the email already exist
            $checkEmail = \App\User::where('email',$email)->get()->toArray();

            if(count($checkEmail) > 0){
                // Set user session data
                session(['userId' => $checkEmail[0]['id']]);
                session(['userName' => $checkEmail[0]['first_name']]);
                session(['emailVerified' => $checkEmail[0]['email_verified']]);
                session(['phoneVerified' => $checkEmail[0]['phone_verified']]);

                Session::flash('headerMess', 'Logged in successfull'); 
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to($request->session()->get('redirectUrl'));
            }else{
                //Create user
                if ($provider == "google") { 
                    $content['first_name'] =$user->user['given_name']; 
                    $content['last_name'] =$user->user['family_name']; 
                    $content['email'] =$user->email; 
                    $content['country'] = 'India'; 
                    $content['sign_in_with'] = 'Google plus'; 
                    $content['email_verified'] = 1; 
                }else{
                    //Facebook
                    $content['first_name'] =$user->name; 
                    $content['email'] =$user->email; 
                    $content['country'] = 'India'; 
                    $content['sign_in_with'] = 'Facebook'; 
                    $content['email_verified'] = 1; 
                }
                
                // $create  = \App\User::create($content);
                    
                // Set user session data
                // session(['userId' => $create->id]);
                // session(['userName' => $create->first_name]);
                // session(['emailVerified' => $create->email_verified]);
                // session(['phoneVerified' => $create->phone_verified]);

                Session::flash('getPhoneNumber', 'Please provide the following details to complete the sign up.'); 
                Session::flash('socialData', json_encode($content)); 
                Session::flash('alert-class', 'alert-success');

                
                return \Redirect::to($request->session()->get('redirectUrl'));
            }
            
        }catch(\Exception $e ){
            $failure['response']['message'] = "Sorry could not sign up.";
            $failure['response']['sys_msg'] = $e->getMessage();

            Session::flash('message', 'Sorry could not Register.'. $e); 
            Session::flash('alert-class', 'alert-danger');

            return \Redirect::to($request->session()->get('redirectUrl'));
        }
    }

    public function socialSignUp(Request $request)
    {
        try {
            $createContent = json_decode($_POST['userData'],true);
            $createContent['contact_no'] = $_POST['contact_no'];

            $create  = \App\User::create($createContent);
                
            // Set user session data
            session(['userId' => $create->id]);
            session(['userName' => $create->first_name]);
            session(['emailVerified' => $create->email_verified]);
            session(['phoneVerified' => $create->phone_verified]);

            Session::flash('headerMess', 'Sign up successfull'); 
            Session::flash('alert-class', 'alert-success');

            return \Redirect::to($request->session()->get('redirectUrl'));


        } catch (\Exception $e) {
            Session::flash('headerMess', 'Sorry could not sign up.'); 
            Session::flash('alert-class', 'alert-danger');

            return \Redirect::to($request->session()->get('redirectUrl'));
        }
    }
}
