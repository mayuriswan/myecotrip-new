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
                <h1 class="page-header">Create Jungle Stay Room
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
            {{ Form::open(array('url' => 'cms/jungle-stay/parking/'.$parkingData['id'], 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'product_form', 'enctype'=>'multipart/form-data')) }}
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default ">
							<div class="panel-heading">
								<h3>
									<div class='pull-right'>
										<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Update</button>
										<a href="{{url('cms/jungle-stay/parking')}}" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
									</div>
									Room details
								</h3>
							</div>
							<div class="panel-body">

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Stay<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">

                                        <select id="dates-field2" name="js_id" class="form-control" required>
                                            <option value="">Select stay</option>
                                            @foreach($data['stays'] as $key => $row)
                                			         <option @if($parkingData['js_id'] == $row['id']) selected @endif value="{{$row['id']}}">{{$row['name']}}</option>
                                			@endforeach
                                		</select>

                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Vehicles<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">

                                        <select id="dates-field2" name="vehicle_id" class="form-control" required>
                                            <option value="">Select vehicle</option>
                                            @foreach($data['vehicles'] as $key => $row)
                                			         <option @if($parkingData['vehicle_id'] == $row['id']) selected @endif value="{{$row['id']}}">{{$row['type']}}</option>
                                			@endforeach
                                		</select>

                    		    	</div>
                    			</div>


                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Price Rs. <span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<input  class="form-control" type="number" min="1" name="price" value="{{$parkingData['price']}}" required/>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd"> Status<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<select class="form-control" name="status" required/>
                                            <option @if($parkingData['status'] == 1) selected @endif value="1">True</option>
                                            <option @if($parkingData['status'] == 0) selected @endif value="0">False</option>
                                        </select>
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

</script>

@endsection
