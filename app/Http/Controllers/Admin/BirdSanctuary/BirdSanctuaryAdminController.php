<?php

namespace App\Http\Controllers\Admin\BirdSanctuary;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class BirdSanctuaryAdminController extends Controller
{
	public function checkLogin($request)
	{
		try {
			$check = $this->getLoggedInUserDetails($request, 'userId');
	    	if (!$check){
	            Session::flash('message', 'Session timeout. Please login.'); 
	            Session::flash('alert-class', 'alert-danger');  
	            return redirect()->route('adminHome');
	        }
		} catch (Exception $e) {
			Session::flash('message', 'Something went wrong.'); 
            Session::flash('alert-class', 'alert-danger');  
            return redirect()->route('adminHome');
		}
	}

    public function index(Request $request)
    {	
    	$this->checkLogin($request);
        return view('Admin/adminPages/birdSanctuary/index', []);
    }
}










