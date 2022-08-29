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
                    <h1 class="page-header">Boat Type Price
                        <a href="{{ url('admin/addBoatTypePrice') }}/{{$birdSanctuaryId}}" title="Add Bird Sanctuary Price">
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
                            Boat Type Price List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Pricing name</th>
                                    <th>Boat Type</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Price</th>
                                    <th>Version</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(count($boatTypePrice) > 0)
                                    @foreach($boatTypePrice as $index => $boatTypePriceData)
                                        <tr class="odd gradeX">
                                            <td>{{$boatTypePriceData['unit']}}</td>
                                            <td>{{$boatTypePriceData['name']}}</td>
                                            <td>{{$boatTypePriceData['from_date']}}</td>
                                            <td>{{$boatTypePriceData['to_date']}}</td>
                                            <td>{{$boatTypePriceData['price']}}</td>
                                            <td>{{$boatTypePriceData['version']}}</td>
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
        $(".boatTypePriceDataDelete").on("click", function(){
            var decision = confirm("Do you want to delete this item?");

            if (decision) {
                var boatTypePriceId = $(this).attr('value');
                window.location.href = "{{URL::to('admin/deleteBoatTypePrice?id=')}}" + boatTypePriceId
            }
        });
    </script>



@endsection
