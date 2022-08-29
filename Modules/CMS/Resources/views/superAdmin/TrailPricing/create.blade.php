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
            <h1 class="page-header">Create Pricing
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
            {{ Form::open(array('url' => 'cms/ecotrails/pricing', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'product_form', 'enctype'=>'multipart/form-data')) }}
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default ">
                        <div class="panel-heading">
                            <h3>
                                <div class='pull-right'>
                                    <button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
                                    <a href="{{url('cms/ecotrails/pricing')}}" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
                                </div>
                                Pricing details
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-3"><strong>From Date&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
                                <div class="col-lg-3 ">
                                    <input type="date" name="from_date" id="from_date" class="form-control validate[required]" required placeholder="MM/DD/YYY" value="">
                                </div>
                                <div class="col-lg-3" style="text-align: right"><strong>To Date&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
                                <div class="col-lg-3">
                                    <input type="date" name="to_date" id="to_date" class="form-control validate[required]" required placeholder="MM/DD/YYY" value="">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="control-label col-xs-3"><strong>Trail&nbsp;</strong></div>
                                <div class="col-xs-5"> 
                                    <select class="form-control" name="trail_id" required>
                                        <option value="">Select Trial</option>
                                        @foreach($data['trails'] as $trail)
                                            <option value="{{$trail['id']}}">{{$trail['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>

                             <div class="row">
                                <div class="control-label col-xs-3"><strong>Timeslot&nbsp;</strong></div>
                                <div class="col-xs-5"> 
                                    <select class="form-control" name="timeslot_id" required="">
                                        <option value="">Select Timeslot</option>
                                        @foreach($data['timeslots'] as $row)
                                            <option value="{{$row['id']}}">{{$row['timeslots']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                            <br>

                            


                            @foreach($data['types'] as $key => $type)
<div class="row form-group">
   <label class="control-label col-sm-3">{{$type['name']}}: </label>
   <div class="col-sm-5">
      <input type="number" min="0" class="form-control" name="type[{{$type['id']}}]" placeholder="Enter amount for {{$type['name']}}" required>
   </div>
</div>

                            @endforeach
                            
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