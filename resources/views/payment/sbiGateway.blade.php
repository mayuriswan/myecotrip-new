<html>
<head>
<title> Custom Form Kit </title>
</head>
<body>
<center>
	<form method="post" name="ecom_form" id="ecom" action="{{\Config::get('payment.actionUrl')}}"> 

	<input type="hidden" name="EncryptTrans" value="{{$data}}">
	<input type="hidden" name="merchIdVal" value="{{\Config::get('payment.sbiMerchantId')}}">
	
	<!-- <div class="col-12 eachBlock">
		<input type="submit" name="submit" value="Pay Now" class="btn btn-m-width modalSubmit submitBtn form-submit">
	</div> -->
</form>
</center>
<script language='javascript'>document.ecom_form.submit();</script>
</body>
</html>