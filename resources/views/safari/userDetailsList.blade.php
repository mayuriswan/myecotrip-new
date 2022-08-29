    @for ($i = 1; $i <= $userDetailsList['transportationSeats']; $i++)
    <div class="row" id="{{$userDetailsList['vehicleId']}}">
        <div class="col-md-4">
            <div class="form-group">
                <label>First & Last Name</label>
                <input class="form-control" name="detail[{{$userDetailsList['vehicleId']}}][{{$i}}][name]" type="text" required />
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Age</label>
                <input class="form-control" name="detail[{{$userDetailsList['vehicleId']}}][{{$i}}][age]" type="number" min="1" required />
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Sex</label>
                <select class="form-control" name="detail[{{$userDetailsList['vehicleId']}}][{{$i}}][sex]" required >
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                    <option value="O">Other</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Foreigner</label><input type="checkbox" name="detail[{{$userDetailsList['vehicleId']}}][{{$i}}][visitorType]" id="visitorType{{$i}}" value="1">
            </div>
        </div>
    </div>
@endfor