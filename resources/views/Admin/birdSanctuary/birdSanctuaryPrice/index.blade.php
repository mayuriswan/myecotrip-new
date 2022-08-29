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
                    <h1 class="page-header">Bird Sanctuary Price
                        <a href="{{ url('admin/addBirdSanctuaryPrice')}}/{{$birdSanctuaryId}}" title="Add Bird Sanctuary Price">
                            <button type="button" class="btn btn-primary addNewButton">Add new</button>
                        </a>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                
                <!-- Modal -->
                <div class="modal fade" id="addNew" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add Bird Sanctuary Price</h4>
                            </div>
                            {{ Form::open(array('url' => 'admin/addBirdSanctuaryPrice')) }}
                            <div class="modal-body">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" placeholder="Bird Sanctuary Price" name="name"  required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Add</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                            {{ Form::close() }}
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.row -->

            <div class="flash-message">
              @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }}" >{{ Session::get('alert-' . $msg) }}</p>
                @endif
              @endforeach
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Bird Sanctuary Price List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Price</th>
                                    <th>Version</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                                </thead>

                                <tbody>
                                @if(count($birdSanctuaryPrice) > 0)
                                    @foreach($birdSanctuaryPrice as $index => $birdSanctuaryPriceData)
                                        <tr class="odd gradeX">
                                            <td>{{$birdSanctuaryPriceData['name']}}</td>
                                            <td>{{$birdSanctuaryPriceData['from_date']}}</td>
                                            <td>{{$birdSanctuaryPriceData['to_date']}}</td>
                                            <td>{{$birdSanctuaryPriceData['price']}}</td>
                                            <td>{{$birdSanctuaryPriceData['version']}}</td>
                                            
                                            <!-- <td>
                                                <a value="{{$birdSanctuaryPriceData['id']}}" class="BirdSanctuaryPriceDataDelete" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                            </td> -->
                                        </tr>
                                    @endforeach
                                @else
                                    <div class="alert alert-warning">
                                        <strong>Sorry!</strong> No Product Found.
                                    </div>
                                @endif

                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            <br>
                            <div class="well">
                                <h4>Information to be know :</h4>
                                <p>There is no concept of Edit. If price changes a new version of Data will be inserted. </p>

                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->


        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

    <script>
        $(".BirdSanctuaryPriceDataDelete").on("click", function(){
            var decision = confirm("Do you want to delete this item?");

            if (decision) {
                var BirdSanctuaryPriceId = $(this).attr('value');
                window.location.href = "{{URL::to('admin/deleteBirdSanctuaryPrice?id=')}}" + BirdSanctuaryPriceId
            }
        });
    </script>



@endsection
