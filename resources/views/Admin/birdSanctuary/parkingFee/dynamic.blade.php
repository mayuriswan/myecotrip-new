<div class="row">
	<div class="col-xs-3"><strong>Vehicle Type&nbsp;<span class="text-red dk-font-18">*</span>&nbsp;</strong></div>
	<div class="col-xs-9">
		<select class="form-control" id="vehicletype_id" name="vehicletype_id" required>
			<option value="">Select the Vehicle Type</option>
			@foreach($parkingVehicleTypeList as $parkingVehicleType)
				<option value="{{$parkingVehicleType['id']}}">{{$parkingVehicleType['type']}}</option>
			@endforeach 
		</select>
	</div>
</div>