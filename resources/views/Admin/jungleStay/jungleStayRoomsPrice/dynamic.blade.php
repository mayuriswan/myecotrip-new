<select id="room" name="jungleStayRooms_id" required class="form-control">
    <option value="">Select the Room Type</option>
    @foreach($jungleStayRoomsList as $jungleStayRooms)
    <option value="{{$jungleStayRooms['id']}}">{{$jungleStayRooms['type']}}</option>
    @endforeach
</select>