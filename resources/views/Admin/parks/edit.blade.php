@extends('layouts.Admin.app')

@section('title', '')

@section('navBar')
    @include('layouts.Admin.superAdmin.topNav')

    @include('layouts.Admin.superAdmin.sideNav')
@endsection

@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-lg-12">
                <h1 class="page-header">Edit Park</h1>
            </div>
        </div>
		<div class="form-group row">
		{{ Form::open(array('url' => 'admin/updatePark', 'files' => true)) }}
			<input type="hidden" name="parkId" value="{{$parkData['id']}}">
			<div class="row">
	            <div class="col-lg-12">
	            	<form action="createPark" method="post" enctype="multipart/form-data">
					   <div class="row">
					      <div class="col-lg-12">
					         <div class="panel panel-default ">
					            <div class="panel-heading">
					               <h3>
					                  <div class='pull-right'> 
					                     <button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Update</button>
					                     <a href="parks" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
					                  </div>
					                  Park details
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
<div class="row">
   <div class="col-xs-3"><strong>Order No.&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <input name="display_order_no" required type="text" class="form-control validate[required] text-input" value="{{ $parkData['display_order_no']}}" id="orderno">
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Park Name&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <input name="name" type="text" class="form-control validate[required] text-input" id="name" value="{{ $parkData['name']}}" required>
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Park Type&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <input name="type" type="text" class="form-control validate[required] text-input" id="type" value="{{ $parkData['type']}}" required>
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Park Description&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <textarea name="description" rows="7" class="form-control validate[required] text-input TEditor" id="description" required>{{$parkData['description']}}</textarea>
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Park City&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <input name="city" type="text" class="form-control validate[required] text-input" id="city" value="{{ $parkData['city']}}" required>
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Safari&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-1">
    <input name="safari" value="0" type="hidden"> 
    <input name="safari" value="1" type="checkbox" class="checkbox" id="safari" {{  $parkData['safari'] ? 'checked' : '' }}>
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Properties/Lodging&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-1"> 
    <input name="properties" value="0" type="hidden"> 
    <input name="properties"  value="1" type="checkbox" class="checkbox" id="properties" {{  $parkData['properties'] ? 'checked' : '' }}>
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Park&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-1"> 
    <input name="park" value="0" type="hidden"> 
   <input name="park"  value="1" type="checkbox" class="checkbox" id="park" {{  $parkData['park'] ? 'checked' : '' }}>
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Ecotrails&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-1"> 
    <input name="ecotrails" value="0" type="hidden"> 
   <input name="ecotrails"  value="1" type="checkbox" class="checkbox" id="ecotrails" {{  $parkData['ecotrails'] ? 'checked' : '' }}>
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Zoo&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-1"> 
    <input name="zoo" value="0" type="hidden"> 
    <input name="zoo"  value="1" type="checkbox" class="checkbox" id="zoo" {{  $parkData['zoo'] ? 'checked' : '' }}>
   </div>
</div>
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
						                        	<img class="parkLogo" src="{{$parkData['imageBaseUrl']}}{{$parkData['logo']}}">
					                        	</div>
					                        </div>
					                     </div>
					                     <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="home-tab">
					                        <br>
<div class="row">
   <div class="col-xs-3"><strong> Meta Title&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <input name="meta_title" type="text" class="form-control validate[required] text-input" id="meta_title" value="{{ $parkData['meta_title']}}" >
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Meta Description&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <textarea name="meta_description" rows="4" class="form-control validate[required] text-input" id="meta_description">{{$parkData['meta_description']}}</textarea>
   </div>
</div>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Keywords&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-9"> <textarea name="meta_keywords" rows="3" class="form-control validate[required] text-input" id="meta_keywords">{{$parkData['meta_keywords']}}</textarea>
   </div>
</div>
<br>
<div class="row">
   <div class="col-sm-3"><strong>Directions&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-sm-9">
      <textarea name="direction" rows="4"  id="direction" style="resize:none;width:100%;" class="form-control TEditor">{{$parkData['direction']}}</textarea>
   </div>
</div>
<br>
<div class="row">
   <div class="col-sm-3"><strong>Transportation&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-sm-9">
      <textarea name="transportation" rows="4"  id="transportation" style="resize:none;width:100%;" class="form-control TEditor">{{$parkData['transportation']}}</textarea>
   </div>
</div>
<br>
<br>
<div class="row">
   <div class="col-sm-3"><strong>Map URL&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-sm-9">
      <input name="map_url" type="text" class="form-control validate[required] text-input" id="map_url" value="{{ $parkData['map_url']}}" >
   </div>
</div>
<br>
<br>
<div class="row">
   <div class="col-xs-3"><strong>Status&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
   <div class="col-xs-1"> 
    <input name="status" value="0" type="hidden"> 
    <input name="status"  value="1" type="checkbox" class="checkbox" id="status" {{  $parkData['status'] ? 'checked' : '' }}>
   </div>
</div>
					                     </div>
					                  </div>
					               </div>
					            </div>
					         </div>
					      </div>
					   </div>
					</form>
	            </div>
	        </div>
		</div>
	    {{ Form::close() }}
	</div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection
