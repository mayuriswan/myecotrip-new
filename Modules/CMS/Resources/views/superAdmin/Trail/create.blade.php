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
            <h1 class="page-header">Create trail
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
            {{ Form::open(array('url' => 'cms/ecotrails/trails', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'product_form', 'enctype'=>'multipart/form-data')) }}
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default ">
                        <div class="panel-heading">
                            <h3>
                                <div class='pull-right'>
                                    <button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
                                    <a href="{{url('cms/ecotrails/trails')}}" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
                                </div>
                                Trail details
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="row form-group">
                                <div class="col-xs-3">
                                    <strong>Select the park&nbsp;</strong>
                                </div>
                                <div class="col-xs-5">
                                    <select class="form-control"  name="park_id" required>
                                        <option value="">Select</option>
                                        @foreach ($parkList as $park)
                                        <option value="{{$park['id']}}">{{ $park['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-3">
                                    <strong>Select the landscape&nbsp;</strong>
                                </div>
                                <div class="col-xs-5">
                                    <select class="form-control"  name="landscape_id" required>
                                        <option value="">Select</option>
                                        @foreach ($landscapelist as $park)
                                        <option value="{{$park['id']}}">{{ $park['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3"><strong>Order No.&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="display_order_no" required type="number" min="1" class="form-control " id="orderno">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Trail Name&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="name" type="text" class="form-control " id="name" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Range&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="range" type="text" class="form-control " id="range" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Maximum Trekkers&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="max_trekkers" type="number" min="1" class="form-control " id="max_trekkers" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Distance&nbsp;</strong></div>
                                <div class="col-xs-2"> <input name="distance" type="text" class="form-control " id="distance" required></div>
                                <div class="col-xs-2">
                                    <select class="form-control" name="distance_unit">
                                        @foreach ($distanceUnit as $disUnit)
                                        <option value="{{$disUnit['name']}}">{{$disUnit['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Duration&nbsp;</strong></div>
                                <div class="col-xs-2">
                                    <select class="form-control" name="hours">
                                        @for($i = 0; $i < 25; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-xs-1">
                                    <label>Hrs</label>
                                </div>
                                <div class="col-xs-2">
                                    <select class="form-control" name="minutes">
                                        @for($i = 0; $i < 61; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-xs-1">
                                    <label>Mins</label>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Trail Type&nbsp;</strong></div>
                                <div class="col-xs-5">
                                    <select class="form-control"  name="type" required>
                                        <option value="">Select</option>
                                        <option value="Soft">Soft</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Hard">Hard</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Trail Description&nbsp;</strong></div>
                                <div class="col-xs-9"> 
                                    <textarea name="description" rows="7" class="summernote form-control validate[required] text-input" id="description" required>
                                    </textarea>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Starting point&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="starting_point" type="text" class="form-control " id="starting_point" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Ending point&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="ending_point" type="text" class="form-control " id="ending_point" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Reporting time&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="reporting_time" type="text" class="form-control " id="reporting_time" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>When to visit&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="when_to_visit" type="text" class="form-control " id="when_to_visit" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Incharger details&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="incharger_details" type="text" class="form-control " id="incharger_details" placeholder="Seperate each fied by ',' Ex: Name:Vinay,PhoneNo:1234567890" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Starting price&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="display_price" type="number" class="form-control " id="display_price" min="0" placeholder="Starting Price" required>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-sm-3"><strong>Map URL&nbsp;</strong></div>
                                <div class="col-sm-5">
                                    <input name="map_url" type="text" class="form-control " id="map_url" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>General instruction&nbsp;</strong></div>
                                <div class="col-xs-5"> <textarea name="general_instruction" rows="7" class="form-control  TEditor" id="general_instruction" required></textarea>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Upload New Logo</strong></div>
                                <div class="col-xs-5"> 
                                    <input name="logo" id="logo" type="file" accept="image/x-png,image/gif,image/jpeg"  required>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Upload trek images</strong></div>
                                <div class="col-xs-5"> 
                                    <input name="trekImages[]" id="trek[]" accept="image/x-png,image/gif,image/jpeg" type="file" multiple>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong> Meta Title&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="meta_title" type="text" class="form-control " id="meta_title">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Meta Description&nbsp;</strong></div>
                                <div class="col-xs-5"> <textarea name="meta_description" rows="4" class="form-control " id="meta_description"></textarea>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-3"><strong>Keywords&nbsp;</strong></div>
                                <div class="col-xs-5"> <textarea name="meta_keywords" rows="3" class="form-control " id="meta_keywords"></textarea>
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