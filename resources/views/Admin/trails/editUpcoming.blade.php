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
                <h1 class="page-header">Add trail upcomings
                    <!-- <a href="{{ url('admin/createTrailUpcoming') }}" title="Edit">
                        <button type="button" class="btn btn-primary addNewButton">Add new</button>
                    </a> -->
                </h1>
            </div>
		</div>
		@if(Session::has('message'))
			<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
		@endif
		<div class="row">
            <div class="col-lg-12">
			{{ Form::open(array('url' => 'admin/updateTrailUpcoming' , 'files' => true)) }}
				   <div class="row">
				      <div class="col-lg-12">
				         <div class="panel panel-default ">
				            <div class="panel-heading">
				               <h3>
				                  <div class='pull-right'> 
				                     <button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
				                     <a href="../trailUpcoming" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
				                  </div>
				                  Trail details
				               </h3>
				            </div>
				            <div class="panel-body">
				               <div class="" role="tabpanel" data-example-id="togglable-tabs">
			                  	
				                  <div id="myTabContent" class="tab-content" style="margin-top: 3%;    margin-bottom: 3%;">
				                     <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
				                     	<input type="hidden" name="id" value="{{$upcomingData['id']}}">
				                        <div class="row">
				                           <div class="col-xs-3"><strong>Name&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
				                           <div class="col-xs-9"> <input name="name" required type="text" class="form-control validate[required] text-input" value="{{$upcomingData['name']}}">
				                           </div>
				                        </div>
				                        <br>
				                        <div class="row">
				                           <div class="col-xs-3"><strong>Short Desc&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
				                           <div class="col-xs-9"> <input name="shortDesc" type="text" class="form-control validate[required] text-input" value="{{$upcomingData['shortDesc']}}" required>
				                           </div>
				                        </div>

				                        <bR>
				                        <div class="row">
				                           <div class="col-xs-3"><strong>Google search text&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
				                           <div class="col-xs-9"> <input name="googleSearchText" type="text" class="form-control validate[required] text-input" value="{{$upcomingData['googleSearchText']}}" required>
				                           </div>
				                        </div>
				                        <br>

				                        <div class="row">
											<div class="col-xs-3"><strong>Status &nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
											<div class="col-xs-9">
												<select class="form-control" required name="status" id="isActive" required>
													<option value="1" @if($upcomingData['status']) selected @endif >Yes</option>
													<option value="0" @if(!$upcomingData['status']) selected @endif >No</option>
												</select>
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
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->




@endsection