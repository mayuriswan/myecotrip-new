<?php

namespace Modules\APIS\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('apis::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('apis::create');
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
        return view('apis::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('apis::edit');
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

    public function doLogin(Request $request)
    {
        $success = \Config::get('common.login_success_response');
        $failure = \Config::get('common.login_failure_response');

        $contentJson = $request->getcontent();
        $content     = json_decode($contentJson,true);

        $email      = $content['email'];
        $password   = $content['password'];

        $getUser = \App\BirdSanctuary\BirdSanctuaryAdmin::leftJoin('birdSanctuary', 'birdSanctuary.id' ,'birdSanctuaryAdmins.birdSanctuary_id')
                    ->where('email',$email)
                    ->select('birdSanctuaryAdmins.*', 'birdSanctuary.name as bsName','birdSanctuary.sanctuary_code', 'birdSanctuary.division')
                    ->get()
                    ->toArray();
        
        // echo "<pre>"; print_r($getUser);exit;
        if (count($getUser) > 0) {
            if ($getUser[0]['password'] == md5($password)) {
                unset($getUser[0]['password']);
                $getUser[0]['charges'] = json_decode($getUser[0]['charges']);
               $success['content'] = $getUser[0];
               return \Response::json($success);
            }else{
                return \Response::json($failure);
            }
        }else{
            return \Response::json($failure);
        }
    }
}
