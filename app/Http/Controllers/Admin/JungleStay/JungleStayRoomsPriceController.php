<?php

namespace App\Http\Controllers\Admin\JungleStay;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class JungleStayRoomsPriceController extends Controller
{
    public function getJungleStayRoomsPrice(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try{
            $jungleStayRoomPriceData = \App\JungleStay\jungleStayRoomsPrice::orderBy('id','desc')->get()->toArray();

            foreach ($jungleStayRoomPriceData as $index => $jungleStayRoomPrice){
                $jungleStayList = \App\JungleStay\jungleStay::where('id',$jungleStayRoomPrice['jungleStay_id'])->get()->toArray();
                $jungleStayRoomList = \App\JungleStay\jungleStayRooms::where('id',$jungleStayRoomPrice['jungleStayRooms_id'])->get()->toArray();

                $jungleStayRoomPriceData[$index]['jungleStayName'] = $jungleStayList[0]['name'];
                $jungleStayRoomPriceData[$index]['jungleStayRoomType'] = $jungleStayRoomList[0]['type'];
            }
            return view('Admin/jungleStay/jungleStayRoomsPrice/index',['jungleStayRoomPrice'=> $jungleStayRoomPriceData]);

        }catch (Exception $e){
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/jungleStayRoomsPrice'));
        }
    }

    public function addJungleStayRoomsPrice(){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $jungleStayList = \App\JungleStay\jungleStay::all()->toArray();

            return view('Admin/jungleStay/jungleStayRoomsPrice/add', ['jungleStayList'=> $jungleStayList]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/jungleStayRoomsPrice'));
        }
    }

    public function getJungleStayRooms(Request $request, $jungleStayId){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        try {
            $jungleStayRoomsList = \App\JungleStay\jungleStayRooms::where('jungleStay_id',$jungleStayId)->get()->toArray();

            return view('Admin/jungleStay/jungleStayRoomsPrice/dynamic', ['jungleStayRoomsList'=> $jungleStayRoomsList]);
        } catch (Exception $e) {
            Session::flash('message', 'Sorry could not process. '. $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/jungleStayRoomsPrice'));
        }
    }

    public function createJungleStayRoomsPrice(Request $request){
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content = $request->all();

        $validator = \Validator::make($request->all(),[
            'jungleStay_id' => 'required',
            'jungleStayRooms_id' => 'required',
            'price_india' => 'required',
            'extra_bed_price_india' => 'required',
            'price_foreign' => 'required',
            'extra_bed_price_foreign' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'remarks' => 'required',
            'isActive' => 'required'
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/jungleStayRoomsPrice'));

        }else {
            try {
                $create  = \App\JungleStay\jungleStayRoomsPrice::create($content);

                Session::flash('message', 'Room Price added successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/jungleStayRoomsPrice'));
            }catch (Exception $e){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/jungleStayRoomsPrice'));
            }
        }
    }

    public function editJungleStayRoomsPrice(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'id'   => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/jungleStayRoomsPrice'));

        }else {
            try {
                $jungleStayRoomPriceData = \App\JungleStay\jungleStayRoomsPrice::where('id', [$content['id']])->get()->toArray();

                $jungleStaylist = \App\JungleStay\jungleStay::all()->toArray();
                $jungleStayRoomslist = \App\JungleStay\jungleStayRooms::all()->toArray();

                return view('Admin/jungleStay/jungleStayRoomsPrice/edit',['jungleStayRoomPriceData'=>$jungleStayRoomPriceData[0],'jungleStaylist'=>$jungleStaylist,'jungleStayRoomslist'=>$jungleStayRoomslist]);
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not edit.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/jungleStayRoomsPrice'));
            }
        }
    }

    public function updateJungleStayRoomsPrice(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $jungleStayRoomsPriceId     = $content['jungleStayRoomsPriceId'];

        $validator = \Validator::make($request->all(), [
            'jungleStay_id' => 'required',
            'jungleStayRooms_id' => 'required',
            'price_india' => 'required',
            'extra_bed_price_india' => 'required',
            'price_foreign' => 'required',
            'extra_bed_price_foreign' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'remarks' => 'required',
            'isActive' => 'required'
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/jungleStayRoomsPrice'));

        }else {
            try {

                unset($content['_token']);
                unset($content['jungleStayRoomsPriceId']);

                $update  = \App\JungleStay\jungleStayRoomsPrice::where('id', $jungleStayRoomsPriceId)->update($content);

                Session::flash('message', 'JungleStay Room Price updated successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/jungleStayRoomsPrice'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/jungleStayRoomsPrice'));
            }
        }
    }

    public function deleteJungleStayRoomsPrice(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');
        $content      = $request->all();

        $jungleStayRoomsPriceId     = $content['id'];

        $validator = \Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";

            Session::flash('message', $validator->errors());
            Session::flash('alert-class', 'alert-danger');
            return \Redirect::to(url('admin/jungleStayRoomsPrice'));

        }else {
            try {
                $delete  = \App\JungleStay\jungleStayRoomsPrice::where('id', $jungleStayRoomsPriceId)->delete();

                Session::flash('message', 'JungleStay Room Price deleted successfully');
                Session::flash('alert-class', 'alert-success');

                return \Redirect::to(url('admin/jungleStayRoomsPrice'));
            } catch (Exception $e) {
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not process. ' . $e->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return \Redirect::to(url('admin/jungleStayRoomsPrice'));
            }
        }
    }
}
