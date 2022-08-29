<br>
<h4>Primary trekker details</h4>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>First & Last Name</label>
            <input class="form-control" name="detail[0][name]" type="text" required />
        </div>
    </div>
	<div class="col-md-2">
        <div class="form-group">
            <label>Age</label>
            <input class="form-control" name="detail[0][age]" type="number" min="1" required />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Sex</label>
            <select class="form-control" name="detail[0][sex]" required >
            	<option value="M">Male</option>
            	<option value="F">Female</option>
            	<option value="O">Other</option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Email</label>
            <input class="form-control" name="email" type="text" required />
        </div>
    </div>
	<div class="col-md-4">
        <div class="form-group">
            <label>Phone_no</label>
            <input class="form-control" name="contat_no" type="number" min="1" required />
        </div>
    </div>
</div>
<hr>

@if ($numberOfPassenger != 1)
<h4>Other trekkers details</h4>
@endif

@for ($i = 1; $i <= $numberOfPassenger - 1; $i++)
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>First & Last Name</label>
            <input class="form-control" name="detail[{{$i}}][name]" type="text" required />
        </div>
    </div>
	<div class="col-md-2">
        <div class="form-group">
            <label>Age</label>
            <input class="form-control" name="detail[{{$i}}][age]" type="number" min="1" required />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Sex</label>
            <select class="form-control" name="detail[{{$i}}][sex]" required >
            	<option value="M">Male</option>
            	<option value="F">Female</option>
            	<option value="O">Other</option>
            </select>
        </div>
    </div>
</div>
@endfor

<h4>Payment details</h4>
<div class="row">
	<div class="col-md-2">
	    <div class="form-group">
	        <label>Amount</label>
	        <input class="form-control" name="amount" type="number" min="1" required />
	    </div>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="form-group">
		   <label>Payment mode</label>
		   <select class="form-control" name="paymentMode" id="paymentMode" required >
		      <option>Select payment mode</option>
		      <option value="cash">Cash</option>
		      <option value="card">Card</option>
		   </select>
		</div>
	</div>
	<div class="col-md-3" id="receipt" style="display: none">
		<div class="form-group">
		   <label>Receipt</label>
		   <input class="form-control" id="receiptName" name="receipt" type="text" required />
		</div>
	</div>
</div>
<div class="row">
	<div class='pull-right'> 
	     <button type="submit" id="btnModify" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Book</button>
	     <a href="offlineTrailBookNowq" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Cancel</a>
  	</div>
</div>

<script type="text/javascript">
   $(function(){
      $('#paymentMode').change(function(e) {
           var value = $('#paymentMode').val();
           if (value == 'card'){
              $('#receipt').attr('style', 'display: block');
           }else{
              $('#receipt').attr('style', 'display: none');
              document.getElementById("receiptName").required = false;
           }
       });

   });
</script>