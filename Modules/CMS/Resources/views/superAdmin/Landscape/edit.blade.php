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
            <h1 class="page-header">Update landscape
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
            {{ Form::open(array('url' => 'cms/ecotrails/landscape/'.$data['id'], 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'product_form', 'enctype'=>'multipart/form-data')) }}
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default ">
                        <div class="panel-heading">
                            <h3>
                                <div class='pull-right'>
                                    <button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
                                    <a href="{{url('cms/ecotrails/landscape')}}" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
                                </div>
                                Landscape details
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-3"><strong>Name&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="name" type="text" class="form-control " id="name" required value="{{$data['name']}}">
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-xs-3"><strong>Seo URL&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="seo_url" type="text" class="form-control " id="name" required value="{{$data['seo_url']}}">
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-xs-3"><strong>Order No.&nbsp;</strong></div>
                                <div class="col-xs-5"> <input name="display_order_no" required type="number" min="1" class="form-control " id="orderno" value="{{$data['display_order_no']}}">
                                </div>
                            </div>
                            <br>
                            

                            <div class="row">
                                <div class="col-xs-3"><strong>Upload landscape images</strong></div>
                                <div class="col-xs-5"> 
                                    <input name="logo" id="trek[]" accept="image/x-png,image/gif,image/jpeg" type="file">
                                </div>
                            </div>
                            <br>
                            
                            <div class="row">
                                <div class="col-xs-3"><strong>Status&nbsp;</strong></div>
                                <div class="col-xs-5">
                                    <select class="form-control"  name="status" required>
                                        <option @if($data['status'] == 1) selected @endif value="1">Active</option>
                                        <option @if($data['status'] == 0) selected @endif value="0">In-Active</option>
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