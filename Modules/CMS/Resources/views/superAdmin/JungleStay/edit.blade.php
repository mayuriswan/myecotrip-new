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
                <h1 class="page-header">Create Jungle Stay
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
            {{ Form::open(array('url' => 'cms/jungle-stay/stays/'.$jsData["id"] , 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'product_form', 'enctype'=>'multipart/form-data')) }}
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default ">
							<div class="panel-heading">
								<h3>
									<div class='pull-right'>
										<button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
										<a href="{{url('cms/jungle-stay/stays')}}" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
									</div>
									Jungle stay details
								</h3>
							</div>
							<div class="panel-body">
                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Park Type <span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<select class="form-control" name="park_type" required>
                                            <option value="">Select Park type</option>
                                            @foreach($data['parkType'] as $key => $row)
                                                <option @if($jsData['park_type'] == $row['id']) selected @endif value="{{$row['id']}}">{{$row['name']}}</option>
                                            @endforeach
                                        </select>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Name <span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<input class="form-control" type="text" name="name" value="{{$jsData['name']}}" required/>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Address <span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<input class="form-control" type="text" name="address" value="{{$jsData['address']}}" required/>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">SEO URL<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<input  class="form-control" type="text" name="seo_url" value="{{$jsData['seo_url']}}" required/>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Display order number <span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<input  class="form-control" type="number" min="1" name="display_order" value="{{$jsData['display_order']}}" required/>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Short Description <span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<textarea  class="form-control" name="short_desc" required rows="5"/>{{$jsData['short_desc']}}</textarea>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Description <span class="required">*</span></label>
                    		      	<div class="col-sm-8 input-group">
                                        <textarea name="description" rows="7" class="summernote form-control validate[required] text-input" id="description" required>{{$jsData['description']}}</textarea>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">General instructions <span class="required">*</span></label>
                                    <div class="col-sm-8 input-group">
                                        <textarea name="general_instructions" rows="7" class="summernote form-control validate[required] text-input" id="description" required>{{$jsData['general_instructions']}}</textarea>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Google Embed map <span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<input  class="form-control" type="text" name="map_url" value="{{$jsData['map_url']}}" required/>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd"> Incharger details<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<input  class="form-control" type="text" name="incharger_details" value="{{$jsData['incharger_details']}}" placeholder="Shamnayak, Forest Guard,+91 94499 70540" required/>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Price starting from<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<input  class="form-control" type="number" name="price_starting_from" value="{{$jsData['price_starting_from']}}" placeholder="500" required/>
                    		    	</div>
                    			</div>



                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Meta title<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<input  class="form-control" type="text" name="meta_title" value="{{$jsData['meta_title']}}" required/>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd"> Meta description<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<input  class="form-control" type="text" name="meta_description" value="{{$jsData['meta_description']}}" required/>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd"> Meta keywords<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<input  class="form-control" type="text" name="meta_keywords" value="{{$jsData['meta_keywords']}}" required/>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd"> Status<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<select class="form-control" name="status" required/>
                                            <option @if($jsData['status'] == 1) selected @endif value="1">True</option>
                                            <option @if($jsData['status'] == 0) selected @endif value="0">False</option>
                                        </select>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Available Room types<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">

                                        <select id="dates-field2" name="room_types[]" class="multiselect-ui form-control" multiple="multiple" required>
                                            @foreach($data['roomTypes'] as $key => $row)

                                			<option @if(in_array($row['id'], $jsData['room_types'])) selected @endif value="{{$row['id']}}">{{$row['name']}} [{{$row['description']}}]</option>
                                			@endforeach
                                		</select>

                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Does it include Trails<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">

                                        <select id="dates-field2" name="trails[]" class="multiselect-ui form-control" multiple="multiple">
                                            @if($jsData['trails'])
                                                @foreach($data['trailList'] as $key => $row)
                                			             <option @if(in_array($row['id'], $jsData['trails'])) selected @endif value="{{$row['id']}}">{{$row['name']}}</option>
            			                        @endforeach
                                            @else
                                                @foreach($data['trailList'] as $key => $row)
                                                         <option value="{{$row['id']}}">{{$row['name']}}</option>
                                                @endforeach
                                            @endif
                                		</select>

                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Logo image<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                        				<input  class="form-control" type="file" name="logo" accept="image/x-png,image/gif,image/jpeg"/>
                    		    	</div>
                    			</div>

                                <div class="form-group">
                    		      	<label class="control-label col-sm-3" for="pwd">Other Images<span class="required">*</span></label>
                    		      	<div class="col-sm-6 input-group">
                                        <input  class="form-control" type="file" name="otherImages[]" accept="image/x-png,image/gif,image/jpeg" multiple/>

                    		    	</div>
                    			</div>
                            {{ Form::close() }}


                                <table class="table">
                                    <tr>
                                        <td>Logo</td>
                                        <td><img src="{{$jsData['logo']}}" alt="Logo" width="150px" height="150px"> </td>
                                    </tr>
                                </table>

                                {{ Form::open(array('url' => 'cms/jungle-stay/staysImages', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'product_form', 'enctype'=>'multipart/form-data')) }}


                                <table class="table">
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Image</th>
                                        <th>Status</th>
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
                                {{ Form::close() }}





                            </div>
						</div>
					</div>
				</div>
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
