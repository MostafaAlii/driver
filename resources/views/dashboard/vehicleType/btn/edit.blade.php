<div class="modal fade" id="editvehicleType{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit vehicleType</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('vehicleType.update','test')}}" method="POST" enctype="multipart/form-data">
                   @method('PUT')
                    @csrf
                    <input type="hidden" name="id" value="{{$row->id}}">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" required name="name" id="name" value="{{$row->name}}">
                    </div>

                    <div class="form-group">
                        <label for="name">icon</label>
                        <input type="text" class="form-control" required name="icon" id="icon" value="{{$row->icon}}">
                    </div>

                    <div class="form-group">
                        <label for="name">capacity</label>
                        <input type="text" class="form-control" required name="capacity" id="capacity" value="{{$row->capacity}}">
                    </div>


                    <div class="form-group p-1">
                        <label for="name">service Location</label>
                        <select class="form-control p-2" name="service_location_id" required>
                            <option value="" disabled selected>-- Choose in service Location --</option>
                            @foreach($serviceLocations as $serviceLocation)
                                <option value="{{$serviceLocation->id}}" {{$serviceLocation->id == $row->service_location_id ? 'selected' : null}}>{{$serviceLocation->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group p-1">
                        <label for="name">Status</label>
                        <select class="form-control p-2" name="status" required>
                            <option value="" disabled selected>-- Choose in status --</option>
                            <option value="1" {{$row->status == 1 ? 'selected' : null}}>Active</option>
                            <option value="0" {{$row->status == 0 ? 'selected' : null}}>No Active</option>
                        </select>
                    </div>

                    <div class="form-group p-1">
                        <label for="name">isAccept_share_ride</label>
                        <select class="form-control p-2" name="is_accept_share_ride" required>
                            <option value="" disabled selected>-- Choose in isAccept_share_ride --</option>
                            <option value="1" {{$row->is_accept_share_ride == 1 ? 'selected' : null}}>Yes</option>
                            <option value="0" {{$row->is_accept_share_ride == 0 ? 'selected' : null}}>No</option>
                        </select>
                    </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
