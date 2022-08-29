<?php

namespace Modules\BirdSanctuary\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Session;

class BirdSanctuaryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('birdsanctuary::CMS.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('birdsanctuary::create');
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
        return view('birdsanctuary::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('birdsanctuary::edit');
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

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('bs-admin');

    }

    public function doLogin(Request $request)
    {
        $success = \Config::get('common.login_success_response');
        $failure = \Config::get('common.login_failure_response');

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        // echo '<pre>';print_r($content);exit;
        if ($validator->fails()) {
            \Session::flash('alert-danger', "Invalid input");
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }

        try{

            $checkEmail = \App\BirdSanctuary\BirdSanctuaryAdmin::where('email',$content['email'])->get()->toArray();

            if(count($checkEmail) > 0){
                $password = md5($content['password']);

                $checkUser  = \App\BirdSanctuary\BirdSanctuaryAdmin::where('email',$content['email'])
                                        ->where('password', $password)
                                        ->get()
                                        ->toArray();

                if (count($checkUser) > 0) {

                    // Set user session data
                    session(['userId' => $checkUser[0]['id']]);
                    session(['adminName' => $checkUser[0]['name']]);
                    session(['birdSanctuaryId' => $checkUser[0]['birdSanctuary_id']]);

                    return redirect()->route('bs-dashboard');

                }else{
                    \Session::flash('alert-danger', 'Sorry credentials did not match !!');
                    $data =  $request->session()->get('_previous');
                    return \Redirect::to($data['url']);
                }
            }else{
                \Session::flash('alert-danger', "Sorry this email is not registered !!");
                $data =  $request->session()->get('_previous');
                return \Redirect::to($data['url']);
            }

        }catch(\Exception $e ){
            \Session::flash('alert-danger', 'Sorry could not process');
            $data =  $request->session()->get('_previous');
            return \Redirect::to($data['url']);
        }
    }

    public function dashboard(Request $request)
    {
        return view('birdsanctuary::CMS.SuperAdmin.dashboard');

    }
}
