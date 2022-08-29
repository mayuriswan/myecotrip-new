<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticController extends Controller
{
    public function contactUs(Request $request)
    {
    	try {
    		return view('static/contactUs');
    	} catch (\Exception $e) {
    		return \Redirect::back();
    	}
    }

    public function PrivacyPolicy(Request $request)
    {
    	try {
    		return view('static/PrivacyPolicy');

    	} catch (\Exception $e) {
    		return \Redirect::back();
    	}
    }

    public function gallery(Request $request)
    {
    	try {
    		return view('static/gallery');

    	} catch (\Exception $e) {
    		return \Redirect::back();
    	}
    }



    public function TermsofUse(Request $request)
    {
    	try {
    		return view('static/TermsofUse');

    	} catch (\Exception $e) {
    		return \Redirect::back();
    	}
    }

    public function faqs(Request $request)
    {
    	try {
    		return view('static/faqs');

    	} catch (\Exception $e) {
    		return \Redirect::back();
    	}
    }

    public function verifyEmailTemplate(Request $request)
    {
    	try {
    		return view('static/verifyEmailTemplate');

    	} catch (\Exception $e) {
    		return \Redirect::back();
    	}
    }
    public function kedb(Request $request)
    {
    	try {
    		return view('static/karnataka-eco-tourism-development-board');

    	} catch (\Exception $e) {
    		return \Redirect::back();
    	}
    }

    public function trainingNews(Request $request)
    {
    	try {
            // return view('static/training-and-news');
    		return view('kedb/training-and-news');

    	} catch (\Exception $e) {
            echo "$e"; exit;
    		return \Redirect::back();
    	}
    }


}
