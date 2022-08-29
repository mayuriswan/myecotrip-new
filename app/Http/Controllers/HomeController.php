<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{
    public function index(Request $request)
    {
    	// get the banner images
    	$getHomeBanners = \App\BannerImages::where('type','homepage')->where('status', 1)
    					->orderBy('id', 'DESC')
    					->get()->toArray();
    	// print_r($getHomeBanners);exit();
    	return view('index',['banners'=>$getHomeBanners]);
    }
}
