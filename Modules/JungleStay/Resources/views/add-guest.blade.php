@for($i = $index; $i < $index + $count; $i++)
<div class="row" id="guest{{$roomId}}{{$i}}">
    <div class="col-md-4">
        <div class="form-group">
            <label>First & Last Name</label>
            <input class="form-control" name="detail[{{$roomId}}][{{$i}}][name]" type="text" required />
        </div>
    </div>
    <input type="hidden" name="detail[{{$roomId}}][{{$i}}][type]" value="adult">
    <div class="col-md-2">
        <div class="form-group">
            <label>Age</label>
            <input class="form-control" name="detail[{{$roomId}}][{{$i}}][age]" type="number" min="1" step="1" required />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Sex</label>
            <select class="form-control" name="detail[{{$roomId}}][{{$i}}][sex]" required >
                <option value="M">Male</option>
                <option value="F">Female</option>
                <option value="O">Transgender</option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <label>Delete</label>

        <i class="fa fa-trash-o showPointer" onclick="deleteDiv('guest{{$roomId}}{{$i}}', '{{$roomId}}')" style="font-size:26px;color:red"></i>
    </div>
</div>
@endfor
