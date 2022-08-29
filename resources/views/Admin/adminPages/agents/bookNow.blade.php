
@extends('layouts.Admin.app')

@section('title', '')

@section('navBar')
    @include('layouts.Admin.agent.topNav')

    @include('layouts.Admin.agent.sideNav')
@endsection

@section('content')

<div id="page-wrapper">
   <div class="row">
      <div class="col-lg-12">
         <h1 class="page-header">Offline Bookings</h1>
      </div>
      <!-- /.col-lg-12 -->
   </div>
   

   @if(Session::has('message'))
   <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
   @endif
   <div class="row">
      <div class="col-lg-12">
         <form action="saveOfflineTrail" method="POST">
         <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">No Of tickets</label>
            <div class="col-sm-5">
               <select class="form-control" required name="number_of_trekkers" id="number_of_trekkers" required>
                  <option>Select No of tickets</option>
                  @for($i=1; $i <= $maxTrekkers ; $i++)
                     <option value="{{$i}}">{{$i}}</option>
                  @endfor
               </select>
            </div>
         </div>

         <!-- Trekkers details -->
         <div id="travelDetails"></div>

         </form>
      </div>
      <!-- /.col-lg-12 -->

      <br>
   </div>
   <!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
   $(function(){
      $('#number_of_trekkers').change(function(e) {
         $( "#travelDetails" ).load( "passengerDetails/"+$('#number_of_trekkers').val());
      });
   });
</script>
@endsection

