@foreach($parkingFeeDetails as $parkingFee)
	<div class="col-xs-6" >
        <div class="form-group">
        	<input type="hidden" name="vehicleType[]" value="VehicleTypeID-{{$parkingFee['parkingVehicleTypeId']}}-{{$parkingFee['price']}}-{{$parkingFee['parkingVehicleTypeName']}}"/>
			<input type="checkbox" class="vehicleType" id="vehicleType" value="{{$parkingFee['parkingVehicleTypeName']}}-({{$parkingFee['price']}} Rs)" > &nbsp;&nbsp;&nbsp;{{$parkingFee['parkingVehicleTypeName']}} &nbsp;({{$parkingFee['price']}} Rs)
        </div>
    </div>
	<div class="col-xs-5" >
        <div class="form-group">
			<input type="number"  min="1" class="form-control" style="text-align: center;" name="noOfvehicles[]" id="noOfvehicles" placeholder="No. of Vehicles" value=""> 
		</div>
	</div>
	<br><br>
@endforeach
