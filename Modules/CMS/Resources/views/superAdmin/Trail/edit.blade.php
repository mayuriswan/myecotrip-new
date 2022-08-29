@extends('cms::layouts.app')
@section('title', 'Trails')
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
            <h1 class="page-header">Edit trail
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
            {{ Form::open(array('url' => 'cms/ecotrails/trails/'.$trailData['id'], 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'product_form', 'enctype'=>'multipart/form-data')) }}
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default ">
                        <div class="panel-heading">
                            <h3>
                                <div class='pull-right'>
                                    <button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Update</button>
                                    <a href="{{url('cms/ecotrails/trails')}}" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
                                </div>
                                Trail details
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="row form-group">
                                <div class="col-xs-3">
                                    <strong>Select the park&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong>
                                </div>
                                <div class="col-xs-5">
                                    <select class="form-control"  name="park_id" required>
                                        <option value=" ">Select</option>
                                        @foreach ($parkList as $park)
                                        <option @if ($park['id'] == $trailData['park_id']) selected @endif value="{{$park['id']}}">{{ $park['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-3">
                                    <strong>Select the landscape&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong>
                                </div>
                                <div class="col-xs-5">
                                    <select class="form-control"  name="landscape_id" required>
                                        <option value=" ">Select</option>
                                        @foreach ($landscapelist as $park)
                                        <option @if ($park['id'] == $trailData['landscape_id']) selected @endif value="{{$park['id']}}">{{ $park['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3"><strong>Order No.&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="display_order_no" required type="number" min="1" value= "{{$trailData['display_order_no']}}" class="form-control validate[required] text-input" id="orderno">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Trail Name&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="name" type="text" value= "{{$trailData['name']}}" class="form-control validate[required] text-input" id="name" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Range&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="range" type="text" value= "{{$trailData['range']}}" class="form-control validate[required] text-input" id="range" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Maximum Trekkers&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="max_trekkers" type="number" value= "{{$trailData['max_trekkers']}}" min="1" class="form-control validate[required] text-input" id="max_trekkers" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Distance&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="distance" type="text" value= "{{$trailData['distance']}}" class="form-control validate[required] text-input" id="distance" required>
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
                                <div class="col-xs-5"> 
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
                                <div class="col-xs-8"> 
                                    <textarea name="description" rows="7" class="summernote form-control validate[required] text-input" id="description" required>
                                    {{$trailData['description']}}
                                    </textarea>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Starting point&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="starting_point" type="text" value= "{{$trailData['starting_point']}}" class="form-control validate[required] text-input" id="starting_point" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Ending point&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="ending_point" type="text" value= "{{$trailData['ending_point']}}" class="form-control validate[required] text-input" id="ending_point" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Reporting time&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="reporting_time" type="text" value= "{{$trailData['reporting_time']}}" class="form-control validate[required] text-input" id="reporting_time" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>When to visit&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="when_to_visit" type="text" value= "{{$trailData['when_to_visit']}}" class="form-control validate[required] text-input" id="when_to_visit" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Incharger details&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="incharger_details" type="text" value= "{{$trailData['incharger_details']}}" class="form-control validate[required] text-input" id="incharger_details" placeholder="Seperate each fied by ',' Ex: Name:Vinay,PhoneNo:1234567890" required>
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
                                <div class="col-xs-5"> <textarea name="general_instruction" rows="7" class="form-control validate[required] text-input TEditor" id="general_instruction" required>{{$trailData['general_instruction']}}</textarea>
                                </div>
                            </div>
                            <br>               
                            <div class="row">
                                <div class="col-sm-3"><strong>Map URL&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
                                <div class="col-sm-9">
                                    <input name="map_url" type="text" class="form-control validate[required] text-input" id="map_url" value="{{$trailData['map_url']}}" >
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
                            <bR>
                            <div class="row">
                                <div class="col-xs-3"><strong>Upload New Logo</strong></div>
                                <div class="col-xs-9"> 
                                    <input name="logo" id="logo" type="file" accept="image/x-png,image/gif,image/jpeg"  >
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
                                    <input name="trekImages[]" id="trek[]" type="file" accept="image/x-png,image/gif,image/jpeg" multiple>
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