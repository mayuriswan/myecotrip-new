@extends('cms::layouts.app')

@section('title', '')

@section('navBar')
    @include('cms::layouts.superAdmin.topNav')

    @include('cms::layouts.superAdmin.sideNav')
@endsection

@section('content')
<!-- multiselect -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/multiselect.css')}}">
<script src="{{ URL::asset('assets/js/multiselect.js')}}"></script>

<!-- include summernote wysiwyg css/js-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>

<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Create Jungle Stay Rooms
                </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

    <div class="flash-message">
	  @foreach (['danger', 'warning', 'success', 'info'] as $msg)
	    @if(Session::has('alert-' . $msg))
	    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
	    @endif
	  @endforeach
	</div>

    <div class="row">
		<div class="col-lg-12">
            {{ Form::open(array('url' => 'cms/jungle-stay/rooms', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'product_form', 'enctype'=>'multipart/form-data')) }}
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default ">
                            <input type="hidden" name="js_id" value="{{$jsId}}">
							<div class="panel-heading">
								<h3>
									<div class='pull-right'>
										<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
										<a href="{{url('cms/jungle-stay/rooms-list')}}/{{$jsId}}" class="btn btn-info btn-sm"><i class="fa fa-remove"></i> Back to room list</a>
									</div>
									Rooms Details
								</h3>
							</div>
							<div class="panel-body">

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Room types<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">

                                        <select id="dates-field2" name="js_type" class="form-control" required>
                                            <option value="">Select room type</option>
                                            @foreach($data['roomTypes'] as $key => $row)
                                			         <option value="{{$row['id']}}">{{$row['name']}} [{{$row['description']}}]</option>
                                			@endforeach
                                		</select>

                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Number Of Rooms <span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<input class="form-control" type="number" min="0" name="no_of_rooms" value="" required/>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Display order<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<input  class="form-control" type="number" min="1" name="display_order" value="" required/>
                    		    	</div>
                    			</div>


                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Max Capacity<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<input  class="form-control" type="number" min="0" name="max_capacity" value="" required/>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="pwd">Room Maintaince charge<span class="required">*</span></label>
                                    <div class="col-sm-6 input-group">
                                        <input  class="form-control" type="number" min="0" name="maintaince_charge" value="" required/>
                                    </div>
                                </div>


                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Display price<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<input  class="form-control" type="number" min="0" name="display_price" value="" required/>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Amenities Available<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">

                                        <select id="dates-field2" name="amenities[]" class="multiselect-ui form-control" multiple="multiple" required>
                                            @foreach($data['amenities'] as $key => $row)

                                			<option value="{{$row['id']}}">{{$row['name']}}</option>
                                			@endforeach
                                		</select>

                    		    	</div>
                    			</div>


                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd"> Status<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<select class="form-control" name="status" required/>
                                            <option value="1">True</option>
                                            <option value="0">False</option>
                                        </select>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Logo image<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<input  class="form-control" type="file" name="logo" accept="image/x-png,image/gif,image/jpeg" required/>
                    		    	</div>
                    			</div>

                            </div>
						</div>
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>

</div>
    <!-- /#page-wrapper -->

<script>

    $('.multiselect-ui').multiselect({
        includeSelectAllOption: true
    });

    //For wysiwyg
    $(document).ready(function() {
        $('.summernote').summernote();
    });


    $(".deleteRow").on("click", function(){
        var decision = confirm("Do you want to delete this item?");
        var id = $(this).attr('value');

        if (decision) {
        	$.ajax({
    		 	headers: {
				    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				  },
			  	type: "DELETE",
			  	url: "{{URL::to('cms/jungle-stay/stays')}}/" + id,
                success: function(data, textStatus, jqXHR){
	                console.log(jqXHR.status);
	                window.location.href= "{{url('/')}}" + '/cms/jungle-stay/stays';
	            }
			});
        }
    });

</script>

@endsection
