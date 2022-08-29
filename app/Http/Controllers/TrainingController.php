<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function natureGuide(Request $request)
    {
    	try {
    		return view('training/nature-guide');

    	} catch (\Exception $e) {
    		return \Redirect::back();
    	}
    }

    public function naturalists(Request $request)
    {
    	try {
    		return view('training/naturalists');

    	} catch (\Exception $e) {
    		return \Redirect::back();
    	}
    }

    public function volunteer(Request $request)
    {
    	try {
    		return view('training/volunteer');

    	} catch (\Exception $e) {
    		return \Redirect::back();
    	}
    }

    public function capacityTraining(Request $request)
    {
    	try {
    		return view('training/capacity-building-training');

    	} catch (\Exception $e) {
    		return \Redirect::back();
    	}
    }

    public function ncep(Request $request)
    {
    	try {
    		return view('training/ncep');

    	} catch (\Exception $e) {
    		return \Redirect::back();
    	}
    }

    public function csr(Request $request)
    {
    	try {
    		return view('training/csr');

    	} catch (\Exception $e) {
    		return \Redirect::back();
    	}
    }






}
