@extends('layouts.Admin.app')

@section('title', '')

@section('navBar')
    @include('layouts.Admin.superAdmin.topNav')

    @include('layouts.Admin.superAdmin.sideNav')
@endsection

@section('content')
<!-- include summernote wysiwyg css/js-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>  


<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-lg-12">
                <h1 class="page-header">Edit Trail</h1>
            </div>
        </div>
        <br>
        @if(Session::has('message'))
          <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
		<div class="form-group row">
		{{ Form::open(array('url' => 'admin/updateTrail', 'files' => true)) }}
			<input type="hidden" name="trailId" value="{{$trailData['id']}}">
      <input type="hidden" name="landscape_id" value="{{$trailData['landscape_id']}}">

			<div class="row">
	            <div class="col-lg-12">
					   <div class="row">
					      <div class="col-lg-12">
					         <div class="panel panel-default ">
					            <div class="panel-heading">
					               <h3>
					                  <div class='pull-right'> 
					                     <button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Update</button>
					                     <a href="trail?id={{$trailData['landscape_id']}}" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
					                  </div>
					                  Trail details
					               </h3>
					            </div>
					            <div class="panel-body">
					               <div class="" role="tabpanel" data-example-id="togglable-tabs">
					                  <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
					                     <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">General</a></li>
					                     <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false">Images</a></li>
					                     <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false">Other's</a></li>
					                  </ul>
					                  <div id="myTabContent" class="tab-content" style="margin-top: 3%;    margin-bottom: 3%;">
					                     <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
<div class="row form-group">
   <div class="col-xs-3">
      <strong>Select the park&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong>
    </div>
   <div class="col-xs-9"> 
      <select class="form-control"  name="park_id" required>
        <option value=" ">Select</option>
        @foreach ($parkList as $park)
          <option @if ($park['id'] == $trailData['park_id']) selected @endif value="{{$park['id']}}">{{ $park['name'] }}</option>
        @endforeach
      </select>
   </div>
</div>
<div class="row">
   <div class="col-xs-3"><strong>Order No.&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <input name="display_order_no" required type="number" min="1" value= "{{$trailData['display_order_no']}}" class="form-control validate[required] text-input" id="orderno">
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Trail Name&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <input name="name" type="text" value= "{{$trailData['name']}}" class="form-control validate[required] text-input" id="name" required>
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Range&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <input name="range" type="text" value= "{{$trailData['range']}}" class="form-control validate[required] text-input" id="range" required>
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Maximum Trekkers&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <input name="max_trekkers" type="number" value= "{{$trailData['max_trekkers']}}" min="1" class="form-control validate[required] text-input" id="max_trekkers" required>
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Distance&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <input name="distance" type="text" value= "{{$trailData['distance']}}" class="form-control validate[required] text-input" id="distance" required>
   </div>
</div>
<br>

<div class="row">
   <div class="col-xs-3"><strong>Duration&nbsp;</strong></div>
   <div class="col-xs-2">
    <select class="form-control" name="hours">
      @for($i = 0; $i < 25; $i++)
        <option @if($trailData['hours'] == $i) selected @endif value="{{$i}}">{{$i}}</option>
      @endfor
    </select> 
   </div>
   <div class="col-xs-1">
    <label>Hrs</label>
   </div>
   <div class="col-xs-2">
      <select class="form-control" name="minutes">
      @for($i = 0; $i < 61; $i++)
        <option @if($trailData['minutes'] == $i) selected @endif value="{{$i}}">{{$i}}</option>
      @endfor
    </select>
   </div>
    <div class="col-xs-1">
    <label>Mins</label>
   </div>
</div>
<br>

<div class="row">
   <div class="col-xs-3"><strong>Trail Type&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> 
      <select class="form-control"  name="type" required>
        <option @if ($trailData['type'] == '') selected @endif value="">Select</option>
        <option @if ($trailData['type'] == 'Soft') selected @endif value="Soft">Soft</option>
        <option @if ($trailData['type'] == 'Medium') selected @endif value="Medium">Medium</option>
        <option @if ($trailData['type'] == 'Hard') selected @endif value="Hard">Hard</option>
      </select>
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Trail Description&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> 
      <textarea name="description" rows="7" class="summernote form-control validate[required] text-input" id="description" required>
        {{$trailData['description']}}
      </textarea>

   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Starting point&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <input name="starting_point" type="text" value= "{{$trailData['starting_point']}}" class="form-control validate[required] text-input" id="starting_point" required>
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Ending point&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <input name="ending_point" type="text" value= "{{$trailData['ending_point']}}" class="form-control validate[required] text-input" id="ending_point" required>
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Reporting time&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <input name="reporting_time" type="text" value= "{{$trailData['reporting_time']}}" class="form-control validate[required] text-input" id="reporting_time" required>
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>When to visit&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <input name="when_to_visit" type="text" value= "{{$trailData['when_to_visit']}}" class="form-control validate[required] text-input" id="when_to_visit" required>
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Incharger details&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <input name="incharger_details" type="text" value= "{{$trailData['incharger_details']}}" class="form-control validate[required] text-input" id="incharger_details" placeholder="Seperate each fied by ',' Ex: Name:Vinay,PhoneNo:1234567890" required>
   </div>
</div>
<br>

<div class="row">
   <div class="col-xs-3"><strong>Starting price&nbsp;</strong></div>
   <div class="col-xs-5"> <input name="display_price" type="number" class="form-control " id="display_price" min="0" placeholder="Starting Price" required value="{{$trailData['display_price']}}">
   </div>
</div>
<br>

<div class="row">
   <div class="col-xs-3"><strong>General instruction&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <textarea name="general_instruction" rows="7" class="form-control validate[required] text-input TEditor" id="general_instruction" required>{{$trailData['general_instruction']}}</textarea>
   </div>
</div>
<br>
					                     </div>
					                     <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="home-tab">
					                        <bR>
					                        <div class="row">
					                           <div class="col-xs-3"><strong>Upload New Logo</strong></div>
					                           <div class="col-xs-9"> 
					                              <input name="logo" id="logo" type="file"  >
					                           </div>
					                        </div>
					                        <div class="row">
					                        	<div class="col-xs-6">
                                      @if($trailData['s3_upload'])
                                        <img class="parkLogo" src="{{$trailData['logo']}}">
                                      @else
						                        	 <img class="parkLogo" src="{{$trailData['imageBaseUrl']}}{{$trailData['logo']}}">
                                      @endif
					                        	</div>
					                        </div>

                                  <br>
                                  <br>
                                  <div class="row">
                                     <div class="col-xs-3"><strong>Upload trek images</strong></div>
                                     <div class="col-xs-5"> 
                                        <input name="trekImages[]" id="trek[]" type="file" multiple>
                                     </div>
                                  </div>

                                  <div class="row">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                      <thead>
                                      <tr>
                                        <th>Id</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                      </tr>
                                      </thead>

                                      <tbody>
                                        @foreach($trailImages as $index => $images)
                                          <tr class="odd gradeX">
                                            <td>{{$index + 1}}</td>
                                            <td>
                                              @if($images['s3_upload'])

                                                <img class="safariLogo" style="margin-top:0px; width:300px;height: 200px;" src="{{$images['name']}}">

                                              @else

                                                <img class="safariLogo" style="margin-top:0px; width:300px;height: 200px;" src="{{$trailData['imageBaseUrl']}}{{$images['name']}}">

                                              @endif

                                              
                                            </td>
                                            <td>
                                              <a value="{{$images['id']}}" class="trailImageDelete" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                            </td>
                                          </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                  </div>
					                     </div>
					                     <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="home-tab">
					                        <br>
<div class="row">
   <div class="col-xs-3"><strong> Meta Title&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <input name="meta_title" type="text" class="form-control validate[required] text-input" id="meta_title" value="{{ $trailData['meta_title']}}" >
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Meta Description&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <textarea name="meta_description" rows="4" class="form-control validate[required] text-input" id="meta_description">{{$trailData['meta_description']}}</textarea>
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Keywords&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <textarea name="meta_keywords" rows="3" class="form-control validate[required] text-input" id="meta_keywords">{{$trailData['meta_keywords']}}</textarea>
   </div>
</div>
<br>
<div class="row">
   <div class="col-sm-3"><strong>Directions&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-sm-9">
      <textarea name="direction" rows="4"  id="direction" style="resize:none;width:100%;" class="form-control TEditor">{{$trailData['direction']}}</textarea>
   </div>
</div>
<br>
<div class="row">
   <div class="col-sm-3"><strong>Transportation&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-sm-9">
      <textarea name="transportation" rows="4"  id="transportation" style="resize:none;width:100%;" class="form-control TEditor">{{$trailData['transportation']}}</textarea>
   </div>
</div>
<br>
<br>
<div class="row">
   <div class="col-sm-3"><strong>Map URL&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-sm-9">
      <input name="map_url" type="text" class="form-control validate[required] text-input" id="map_url" value="" >
   </div>
</div>
<br>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Status&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-1"> 
    <input name="status" value="0" type="hidden"> 
    <input name="status"  value="1" type="checkbox" class="checkbox" id="status" {{  $trailData['status'] ? 'checked' : '' }}>
   </div>
</div>
					                     </div>
					                  </div>
					               </div>
					            </div>
					         </div>
					      </div>
					   </div>
	            </div>
	        </div>
		</div>
	    {{ Form::close() }}
	</div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<script>
    //For wysiwyg
    $(document).ready(function() {
        $('.summernote').summernote();
    });

    $(".trailImageDelete").on("click", function(){
        var decision = confirm("Do you want to delete this item?");

        if (decision) {
            var safariId = $(this).attr('value');
            window.location.href = "{{URL::to('admin/deleteTrailImages')}}"+"/" + safariId
        }
    });
</script>
@endsection
