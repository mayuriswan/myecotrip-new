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
                    <h1 class="page-header">Add Pricing</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <form action="saveEventPricing" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default ">
                                    <div class="panel-heading">
                                        <h3>
                                            <div class='pull-right'>
                                                <button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
                                                <a href="birdsFest" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Close</a>
                                            </div>
                                            Enter Pricing details of event
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                            <div id="myTabContent" class="tab-content" style="margin-top: 3%;    margin-bottom: 3%;">
                                                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                                    @if(Session::has('message'))
                                                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                                                    @endif

                                                    <div class="row">
                                                        <div class="col-xs-3"><strong>Event type<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
                                                        <div class="col-xs-9">
                                                            <select class="form-control" name="event_id" id="event_id" required>
                                                                <option value="">Select Event</option>
                                                                @foreach($eventList as $event)
                                                                    <option value="{{$event['id']}}">{{$event['name']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-xs-3"><strong>Name&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
                                                        <div class="col-xs-9"> <input name="name" type="text" class="form-control validate[required] text-input" id="name" required>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-xs-3"><strong>Price per head<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
                                                        <div class="col-xs-9"> <input name="per_head_price" required type="text" class="form-control validate[required] text-input">
                                                        </div>
                                                    </div>
                                                    <br>

                                                    <div class="row">
                                                        <div class="col-xs-3"><strong>Number of slots<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
                                                        <div class="col-xs-9"> <input name="no_of_slots" required type="text" class="form-control validate[required] text-input">
                                                        </div>
                                                    </div>
                                                    <br>

                                                </div>
                                                </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->




@endsection