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
                        <!-- <a href="{{ url('admin/addBoatTypePrice') }}" title="Add Bird Sanctuary Price">
                            <button type="button" class="btn btn-primary addNewButton">Add new</button>
                        </a> -->
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
                                    <th>Sl No</th>
                                    <th>Bird Sanctuary</th>
                                    <th>Select Bird Sanctuary</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(count($birdSanctuarylist) > 0)
                                    @foreach($birdSanctuarylist as $index => $birdSanctuary)
                                        <tr class="odd gradeX">
                                            <td>{{++$index}}</td>
                                            <td>{{$birdSanctuary['name']}}</td>

                                            @if ($requestFrom == "entryFee")
                                                <td style="text-align: center;">
                                                    <a href="{{ url('admin/birdSanctuaryPrice') }}/{{$birdSanctuary['id']}}"  title="Edit"><i class="fa fa-eye fa-fw"></i></a>
                                                    &nbsp;
                                                </td>
                                            @elseif($requestFrom == "parkingFee")
                                                <td style="text-align: center;">
                                                    <a href="{{ url('admin/parkingFee') }}/{{$birdSanctuary['id']}}"  title="Edit"><i class="fa fa-eye fa-fw"></i></a>
                                                    &nbsp;
                                                </td>
                                                
                                            @elseif($requestFrom == "cameraFee")
                                                <td style="text-align: center;">
                                                    <a href="{{ url('admin/cameraFee') }}/{{$birdSanctuary['id']}}"  title="Edit"><i class="fa fa-eye fa-fw"></i></a>
                                                    &nbsp;
                                                </td>
                                            @else
                                                <td style="text-align: center;">
                                                    <a href="{{ url('admin/boatTypePrice') }}/{{$birdSanctuary['id']}}"  title="Edit"><i class="fa fa-eye fa-fw"></i></a>
                                                    &nbsp;
                                                </td>
                                            @endif
                                            
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
