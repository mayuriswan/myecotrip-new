<?php

namespace Modules\Marketing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
// use App\Mail\SendMailable;
use App\Jobs\SendEmailJob;
use App\Jobs\EmailSubscribers;

class MarketingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('marketing::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('marketing::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('marketing::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('marketing::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function queueMail(Request $request)
    {
        // $getUsers=['vinay@kimzuka.com', 'vinayan17@gmail.com'];
        // $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
        
        // foreach ($getUsers as $key => $user) {
        //     $beautymail->queue('marketing::Mail/birdfest2019', [], function($message) use($user)
        //     {
        //         $email = $user;
        //         $message
        //             ->from('support@myecotrip.com')
        //             ->to($email, '')
        //             ->subject('Myecotrip - Butterfly & Bee Festival 23rd Nov 2019');
        //     }); 
        // } 

        dispatch(new SendEmailJob());
        echo 'Email sent';
    }

    public function sendMail(Request $request)
    {
        
        dispatch(new SendEmailJob());

        echo 'Email sent';
    }

    public function sendMailForSubscribers(Request $request)
    {
        dispatch(new EmailSubscribers());

        echo 'Email sent';
    }

    public function sendMailForVTP(Request $request)
    {
        dispatch(new EmailVTP());

        echo 'Email sent';
    }


}
