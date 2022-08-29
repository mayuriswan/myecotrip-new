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
                    <h1 class="page-header">Parking Fee
                        <a href="{{ url('admin/addParkingFee') }}/{{$birdSanctuaryId}}" title="Add Parking Fee">
                            <button type="button" class="btn btn-primary addNewButton">Add new</button>
                        </a>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Parking Fee List</b>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Vehicle type</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Price</th>
                                    <th>isActive</th>
                                    <th>Version</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(count($parkingFeeList) > 0)
                                    @foreach($parkingFeeList as $index => $parkingFee)
                                        <tr class="odd gradeX">
                                            <td>{{$index + 1}}</td>
                                            <td>{{$parkingFee['type']}}</td>
                                            <td>{{$parkingFee['from_date']}}</td>
                                            <td>{{$parkingFee['to_date']}}</td>
                                            <td>{{$parkingFee['price']}}</td>
                                            <td>{{$parkingFee['isActive']}}</td>
                                            <td>{{$parkingFee['version']}}</td>
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
                                <p>DataTables is a very flexible, advanced tables plugin for jQuery. In SB Admin, we are using a specialized version of DataTables built for Bootstrap 3. We have also customized the table headings to use Font Awesome icons in place of images. For complete documentation on DataTables, visit their website.</p>

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
        $(".parkingFeeDelete").on("click", function(){
            var decision = confirm("Do you want to delete this item?");

            if (decision) {
                var parkingFeeId = $(this).attr('value');
                window.location.href = "{{URL::to('admin/deleteParkingFee?id=')}}" + parkingFeeId
            }
        });
    </script>



@endsection
