<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use Session;

class TrailController extends Controller
{
    public function getTrails(Request $request)
    {
    	$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');
            // return redirect()->route('trail');
        }else{
	        try {

	        	$landscapeId = $content['id'];
	        	$trailslist = \App\Trail::where('landscape_id',$landscapeId)->get()->toArray();

	        	return view('Admin/trails/index', ['trailslist'=> $trailslist]);
	        } catch (Exception $e) {
	        	Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
	            Session::flash('alert-class', 'alert-danger');  
	            return redirect()->route('trail', ['id' => $landscapeId]);
	        }
	    }
    }

    public function addTrail(Request $request)
    {
    	$success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'id' => 'required',
        ]);

    	$landscapeId = $content['id'];

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('trail', ['id' => $landscapeId]);
        }else{
	        try {
	        	// get the parklist
	        	$parkList = \App\Parks::all()->toArray();

                // get the distance units
                $distanceUnit = \App\distanceMaster::all()->toArray();

	        	return view('Admin/trails/add', ['parkList'=> $parkList, 'landscapeId' => $landscapeId, 'distanceUnit' => $distanceUnit]);
	        } catch (Exception $e) {
	        	Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
	            Session::flash('alert-class', 'alert-danger');  
	            return redirect()->route('trail', ['id' => $landscapeId]);
	        }
	    }
    }

    public function priceFormat($content)
    {
        $payload = array();
        $payload['India']['adult'] = [];
        $payload['India']['child'] = [];
        $payload['India']['student'] = [];
        $payload['Foreign']['adult'] = [];
        $payload['Foreign']['child'] = [];

        // India
        $adult = ['entry_fee','guide_fee','TAC'];
        $child = ['entry_fee_child','guide_fee_child','TAC_child'];
        $child = ['entry_fee_student','guide_fee_student','TAC_student'];
        
        // foreign
        $foreignAdult = ['entry_fee_foreign','guide_fee_foreign','TAC_foreign'];
        $foreignChild = ['entry_fee_foreign_child','guide_fee_foreign_child','TAC_foreign_child'];
        
        foreach ($adult as  $key) {
            $payload['India']['adult'][$key] = $content[$key];
        }

        foreach ($child as  $key) {
            $payload['India']['child'][$key] = $content[$key];
        }

        foreach ($foreignAdult as  $key) {
            $payload['Foreign']['adult'][$key] = $content[$key];
        }

        foreach ($foreignChild as  $key) {
            $payload['Foreign']['child'][$key] = $content[$key];
        }

        return $payload;
    }

    

    public function createTrail(Request $request)
    {
    	$success = \Config::get('common.create_success_response');
        $failure = \Config::get('common.create_failure_response');

        $content      = $request->all();
    	$landscapeId = $content['landscape_id'];

        // echo '<pre>';echo json_encode($content['pricing']);exit;

        $validator = \Validator::make($request->all(), [
        	'name' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');
            // return redirect()->route('trail', ['id' => $landscapeId]);
        }else{
            try{

                // check for the name already exist
                $checkTrail = \App\Trail::whereRaw('LOWER(name) = ?', [$content['name']])->get()->toArray();

                if(count($checkTrail) > 0){                    

                    $failure['response']['message'] = "Sorry this trail exist already!!";
                    Session::flash('message', 'Sorry this circle is exist already!!'); 
					Session::flash('alert-class', 'alert-danger');

    				return redirect()->route('trail', ['id' => $landscapeId]);
                }else{

                    $content['s3_upload'] = 1;
                    $create  = \App\Trail::create($content);

                    $tailId = $create->id;

                    // Upload Image
                    $file = $request->file('logo') ;
                    $fileName = $file->getClientOriginalName() ;
                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    //Upload to S3
                    $destinationFileName = time()."_logo.$ext";
                    $filePath = "trailImages/$tailId/$destinationFileName";

                    $s3 = \Storage::disk('s3');
                    $s3->put($filePath, file_get_contents($file), 'public');
                    $s3Url = \Storage::disk('s3')->url($filePath);

                    $update['logo'] = $s3Url;

                    $update  = \App\Trail::where('id', $tailId)->update($update);

                    // Save the price data
                    // $getTheFormat = $this->priceFormat($content);
                    
                    $fromDate  = strtotime($content['fromDate']); 
                    $fromDate  =  date("Y-m-d H:i:s", $fromDate);

                    $toDate  = strtotime($content['toDate']); 
                    $toDate  =  date("Y-m-d H:i:s", $toDate);

                    $insertData['trail_id'] = $tailId;
                    $insertData['from'] = $fromDate;
                    $insertData['to'] = $toDate;
                    $insertData['price'] = json_encode($content['pricing']);

                    $createPrice = \App\TrailPricing::create($insertData);

                    // Upload the trek images
                    if ($content['trekImages']) {
                        if($files=$request->file('trekImages')){
                            foreach($files as $index => $file){
                                $fileName = $file->getClientOriginalName() ;

                                $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                                // $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/trails/'. $tailId;
                                // $destinationFileName = time().$index.".$ext";
                                
                                // $pathToSacveInDB = '/assets/img/trails/'.$tailId.'/'.$destinationFileName;
                                // $file->move($destinationPath,$destinationFileName);
                                
                                //Upload to S3
                                $destinationFileName = time()."$index.$ext";

                                $filePath = "trailImages/$tailId/$destinationFileName";

                                $s3 = \Storage::disk('s3');
                                $s3->put($filePath, file_get_contents($file), 'public');
                                $s3Url = \Storage::disk('s3')->url($filePath);

                                $trekImageList['trail_id'] = $tailId;
                                $trekImageList['s3_upload'] = 1;
                                $trekImageList['name'] = $s3Url;

                                $create  = \App\TrailImages::create($trekImageList);
                            }
                        }
                    }

                    Session::flash('message', 'Trail added successfully'); 
					Session::flash('alert-class', 'alert-success');

    				return redirect()->route('trail', ['id' => $landscapeId]);

                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not insert.";
                $failure['response']['sys_msg'] = $e->getMessage();

                Session::flash('message', 'Sorry could not insert.'. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                // areturn redirect()->route('trail');
            	return redirect()->route('trail', ['id' => $landscapeId]);
            }
        }
    }

    public function editTrail(Request $request)
    {
        $success = \Config::get('common.retrieve_success_response');
        $failure = \Config::get('common.retrieve_failure_response');

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'id'   => 'required',
            'landscape_id'=>'required'
        ]);

        $landscapeId = $content['landscape_id'];
        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('trail', ['id' => $landscapeId]);

        }else{
            try{
                // Get the ciecles details
                $trailData = \App\Trail::where('id', [$content['id']])->get()->toArray();
                
                // get the parklist
	        	$parkList = \App\Parks::all()->toArray();

                if(count($trailData) > 0){
                    $trailData[0]['imageBaseUrl'] = \Config::get('common.imageBaseUrl');

                    // Get trail images
                    $trailImages = \App\TrailImages::where('trail_id',$content['id'])->get()->toArray();
                    // print_r($trailImages);exit();
                    return view('Admin/trails/edit')->with(array('trailData'=>$trailData[0], 'parkList' => $parkList, 'trailImages' => $trailImages));
                }else{
                    Session::flash('message', 'Sorry!! Couldnt process your request. Try once again.');
                    Session::flash('alert-class', 'alert-danger');

                    return redirect()->route('trail', ['id' => $landscapeId]);
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('trail', ['id' => $landscapeId]);
            }
        }
    }

    public function updateTrail(Request $request)
    {
        $success = \Config::get('common.update_success_response');
        $failure = \Config::get('common.update_failure_response');

        $content = $request->all();
		$landscapeId = $content['landscape_id'];

        $validator = \Validator::make($request->all(), [
            'name'   => 'required',
            'landscape_id' => 'required'
        ]);

        // echo '<pre>';print_r($content);exit;
        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('trail', ['id' => $landscapeId]);

        }else{
            try{
        		$trailId = $content['trailId'];

                if (isset($content['logo'])) {

                    // Get the record to delete the existing file
                    // $getRow = \App\Trail::where('id',$trailId)->get()->toArray();

                    // Local Upload Image
                    // $file = $request->file('logo') ;
                
                    // $fileName = $file->getClientOriginalName() ;

                    // $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    // $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/trails/';
                    // $destinationFileName = time().".$ext";
                    
                    // $pathToSacveInDB = '/assets/img/trails/'.$destinationFileName;
                    // $copyFile = $file->move($destinationPath,$destinationFileName);
                    
                    // if ($copyFile) {
                    //     $filepath = \Config::get('common.myecotripHTML').'public'.$getRow[0]['logo'];
                    //     unlink($filepath);
                    // }
                    
                    // $content['logo'] = $pathToSacveInDB;

                    $file = $request->file('logo') ;
                    $fileName = $file->getClientOriginalName() ;
                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    //Upload to S3
                    $destinationFileName = time()."_logo.$ext";
                    $filePath = "trailImages/$trailId/$destinationFileName";

                    $s3 = \Storage::disk('s3');
                    $s3->put($filePath, file_get_contents($file), 'public');
                    $s3Url = \Storage::disk('s3')->url($filePath);

                    $content['logo'] = $s3Url;
                    $content['s3_upload'] = 1;

                }

                
                // echo "<pre>"; print_r($content);exit;

                // Upload the trek images
                if (isset($content['trekImages']) && count($content['trekImages'][0]) > 0) {
                    if($files=$request->file('trekImages')){
                        foreach($files as $index => $file){

                            //Local update
                            // $fileName = $file->getClientOriginalName() ;

                            // $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                            // $destinationPath = \Config::get('common.myecotripHTML').'/public/assets/img/trails/'. $trailId;
                            // $destinationFileName = time().$index.".$ext";
                            
                            // $pathToSacveInDB = '/assets/img/trails/'.$trailId.'/'.$destinationFileName;
                            // $file->move($destinationPath,$destinationFileName);
                            
                            // $trekImageList['trail_id'] = $trailId;
                            // $trekImageList['name'] = $pathToSacveInDB;

                            // $create  = \App\TrailImages::create($trekImageList);

                            // S3 upload
                            $fileName = $file->getClientOriginalName() ;
                            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                            $destinationFileName = time()."$index.$ext";

                            $filePath = "trailImages/$trailId/$destinationFileName";

                            $s3 = \Storage::disk('s3');
                            $s3->put($filePath, file_get_contents($file), 'public');
                            $s3Url = \Storage::disk('s3')->url($filePath);

                            $trekImageList['trail_id'] = $trailId;
                            $trekImageList['s3_upload'] = 1;
                            $trekImageList['name'] = $s3Url;

                            $create  = \App\TrailImages::create($trekImageList);

                        }
                    }

                }

                unset($content['trekImages']);
                unset($content['_token']);
                unset($content['trailId']);
                unset($content['dataTables-example_length']);

                // echo "<pre>";print_r($content);exit();
                $update  = \App\Trail::where('id',$trailId)->update($content);

                Session::flash('message', 'Updated successfully'); 
                Session::flash('alert-class', 'alert-success');
                return redirect()->route('trail', ['id' => $landscapeId]);                   

                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('trail', ['id' => $landscapeId]);
            }
        }
    }

    public function deleteTrail(Request $request)
    {
        $success = \Config::get('common.delete_success_response');
        $failure = \Config::get('common.delete_failure_response');

        $content      = $request->all();

        $validator = \Validator::make($request->all(), [
            'id'   => 'required',
            'landscape_id' => 'required'
        ]);

        $landscapeId = $content['landscape_id'];

        if ($validator->fails()) {
            $failure['content'] = $validator->errors();
            $failure['response']['sys_msg'] = "Invalid Payload";
            // return $failure;

            Session::flash('message', $validator->errors()); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('trail', ['id' => $landscapeId]);

        }else{
            try{
                // Get the ciecles details
                $trailData = \App\Trail::where('id', [$content['id']])->get()->toArray();

                if(count($trailData) > 0){
                	// Delete the logo
                	$filepath = public_path().$trailData[0]['logo'];
                    unlink($filepath);
                        
                    $deleteTrail = \App\Trail::where('id', [$content['id']])->delete();

                    Session::flash('message', 'Successfully deleted the records.'); 
                    Session::flash('alert-class', 'alert-success');

                    return redirect()->route('trail', ['id' => $landscapeId]);

                }else{
                    Session::flash('message', 'Sorry!! Couldnt process your request. Try once again. '); 
                    Session::flash('alert-class', 'alert-danger');

                    return redirect()->route('trail', ['id' => $landscapeId]);
                }
                
            }catch(\Exception $e ){
                $failure['response']['message'] = "Sorry could not update.";
                $failure['response']['sys_msg'] = $e->getMessage();
                // return $failure;

                Session::flash('message', 'Sorry could not process. '. $e->getMessage()); 
                Session::flash('alert-class', 'alert-danger');  
                return redirect()->route('trail', ['id' => $landscapeId]);
            }
        }
    }
}
