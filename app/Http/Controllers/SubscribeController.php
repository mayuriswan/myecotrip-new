<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use PHPMailer\PHPMailer\PHPMailer;


class SubscribeController extends Controller
{
    public function subscribe(Request $request)
    {
    	$success = \Config::get('common.create_success_response');
        $failure = \Config::get('common.create_failure_response');

        $content = $_POST;
        try{
            // check for the email already exist
            $checkEmail = \App\Subscribe::where('email',$content['email'])->get()->toArray();

            if(count($checkEmail) > 0){
                $failure['response']['message'] = "Sorry this email is subscribed already!!";
                
                Session::flash('subscribeMessage', 'Sorry this email is subscribed already!!'); 
                Session::flash('alert-class', 'alert-danger');

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }else{
                $create  = \App\Subscribe::create($content);
                
                Session::flash('subscribeMessage', 'subscribed successfully'); 
                Session::flash('alert-class', 'alert-success');

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }
            
        }catch(\Exception $e ){
            $failure['response']['message'] = "Sorry could not insert.";
            $failure['response']['sys_msg'] = $e->getMessage();

            Session::flash('subscribeMessage', $e->getMessage()); 
            Session::flash('alert-class', 'alert-danger');

            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function contactUsMail(Request $request)
    {
        $success = \Config::get('common.create_success_response');
        $failure = \Config::get('common.create_failure_response');
        try{

            $content = $_POST;

            //your site secret key
            $secret = '6Lcz24IUAAAAAJz7C1kpAUG4Q9WQEws8N36SE47G';

            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);

            if($responseData->success){ 
                $body = '';
                foreach ($content as $key => $value) {
                    $body .= "$key : $value <br />";
                }

                $attachements = [];
                $sendMail = $this->sendEmail('support@myecotrip.com', 'Myecotrip', [], '[Myecotrip trails] Request for bulk booking', $body, $attachements, $bccTo = []);

                Session::flash('contactMessage', 'Thank you! We will conact you soon.'); 
                Session::flash('alert-class', 'alert-success');

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }else{
                Session::flash('contactMessage', 'Invalid captcha'); 
                Session::flash('alert-class', 'alert-danger');

                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }

            

        }catch(\Exception $e ){
            Session::flash('contactMessage', $e->getMessage()); 
            Session::flash('alert-class', 'alert-danger');

            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }
}
