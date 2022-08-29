<?php if($vehicleList != 'No Vehicle Found'){?>
@foreach($vehicleList as $vehicle)
    <input type="checkbox" name="vehicle_id[]" id="vehicle_id" value="{{$vehicle['id']}}">&nbsp;&nbsp;{{$vehicle['vehicle_no']}}&nbsp;&nbsp;
@endforeach
<?php } else echo $vehicleList; ?>