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
            {{ Form::open(array('url' => 'cms/jungle-stay/rooms/'.$jsData['id'], 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'product_form', 'enctype'=>'multipart/form-data')) }}
                <input type="hidden" name="js_id" value="{{$jsData['js_id']}}">
                <div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default ">
							<div class="panel-heading">
								<h3>
									<div class='pull-right'>
										<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
										<a href="{{url('cms/jungle-stay/stays')}}" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
									</div>
									Room details
								</h3>
							</div>
							<div class="panel-body">

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Room types<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">

                                        <select id="dates-field2" name="js_type" class="form-control" required>
                                            <option value="">Select room type</option>
                                            @foreach($data['roomTypes'] as $key => $row)
                                			         <option @if($jsData['js_type'] == $row['id']) selected @endif value="{{$row['id']}}">{{$row['name']}}</option>
                                			@endforeach
                                		</select>

                    		    	</div>
                    			</div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="pwd">Number Of Rooms <span class="required">*</span></label>
                                    <div class="col-sm-6 input-group">
                                        <input class="form-control" type="number" min="0" name="no_of_rooms" value="{{$jsData['no_of_rooms']}}" required/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="pwd">Display order<span class="required">*</span></label>
                                    <div class="col-sm-6 input-group">
                                        <input  class="form-control" type="number" min="1" name="display_order" value="{{$jsData['display_order']}}" required/>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="pwd">Max Capacity<span class="required">*</span></label>
                                    <div class="col-sm-6 input-group">
                                        <input  class="form-control" type="number" min="0" name="max_capacity" value="{{$jsData['max_capacity']}}" required/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="pwd">Room Maintaince charge<span class="required">*</span></label>
                                    <div class="col-sm-6 input-group">
                                        <input  class="form-control" type="number" min="0" name="maintaince_charge" value="{{$jsData['maintaince_charge']}}" required/>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="pwd">Display price<span class="required">*</span></label>
                                    <div class="col-sm-6 input-group">
                                        <input  class="form-control" type="number" min="0" name="display_price" value="{{$jsData['display_price']}}" required/>
                                    </div>
                                </div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Amenities Available</label>
                    		      	<div class="col-sm-6 input-group">

                                        <select id="dates-field2" name="amenities[]" class="multiselect-ui form-control" multiple="multiple" required>
                                            @foreach($data['amenities'] as $key => $row)

                                			<option @if(in_array($row['id'], $jsData['amenities'])) selected @endif value="{{$row['id']}}">{{$row['name']}}</option>
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
                    		      	<label class="control-label col-sm-3" for="pwd">Logo image</label>
                    		      	<div class="col-sm-6 input-group">
                        				<input  class="form-control" type="file" name="logo" accept="image/x-png,image/gif,image/jpeg"/>
                    		    	</div>
                    			</div>

                            </div>
						</div>
					</div>
				</div>
			{{ Form::close() }}

            <table class="table">
                <tr>
                    <td>Logo</td>
                    <td><img src="{{$jsData['logo']}}" alt="Logo" width="150px" height="150px"> </td>
                </tr>
            </table>

            <!-- {{ Form::open(array('url' => 'cms/jungle-stay/staysImages', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'product_form', 'enctype'=>'multipart/form-data')) }}


            <table class="table">
                <tr>
                    <th>Sl No</th>
                    <th>Image</th>
                    <th>Display Status</th>
                </tr>
                @foreach($jsData['images'] as $key => $image)

                    <tr>
                        <td>{{++$key}}</td>
                        <td><img src="{{$image['name']}}" alt="Other Images" width="150px" height="150px"> </td>
                        <td>
                            <select class="form-control" name="images[{{$image['id']}}]">
                                <option @if($image['status'] == 1) selected @endif value="1">True</option>
                                <option @if($image['status'] == 0) selected @endif value="0">False</option>
                            </select>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="row col-md-12 text-right">
                <button class="btn btn-success " type="submit">Update status</button>
            </div>
            {{ Form::close() }} -->

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
