
@extends('layouts.Admin.app')

@section('title', '')

@section('navBar')
    @include('layouts.Admin.trails.topNav')

    @include('layouts.Admin.trails.sideNav')
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

   <p class="alert alert-danger" id="errorDiv" style="display: none;">Invalid input</p>

   <div class="row">
      <div class="col-lg-12">
         <form action="getTrekkersDetails" id="myForm" method="POST">
            <div class="row">
               <div class="col-md-3">
                 <div class="form-group">
                     <label>Number of Adults</label>
                     <input type="number" min="0" class="form-control" name="number_of_trekkers" value="0" required />
                 </div>
               </div>
               <div class="col-md-3">
                 <div class="form-group">
                     <label>Number of Children</label>
                     <input type="number" min="0" class="form-control" name="number_of_children" value="0" required />
                 </div>
               </div>
               <div class="col-md-3">
                 <div class="form-group">
                     <label>Number of Students</label>
                     <input type="number" min="0" class="form-control" name="number_of_students" value="0" required />
                 </div>
               </div>

               <div class='col-md-3'> 
                  <div class="form-group" style="margin-top: 22px;">
                     <label></label>
                     <button type="button" onclick="checkInput()" id="btnModify" class="btn btn-success"><i class="fa fa-save"></i> Enter Details</button>
                 </div>
               </div>

            </div>
         </form>
      </div>
      <!-- /.col-lg-12 -->
   </div>
   <!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">

   function checkInput() {
      var isValid = false;
      $("input").each(function() {
         var element = $(this);
         if (element.val() != 0) {
             isValid = true;
         }
      });

      if(!isValid){
         $('#errorDiv').attr('style', 'display: block');
      }else{
         $('#errorDiv').attr('style', 'display: none');
         document.getElementById("myForm").submit();


      }
   }
</script>
@endsection

