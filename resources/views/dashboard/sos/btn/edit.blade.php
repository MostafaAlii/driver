<div class="modal fade" id="editSos{{$sos->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Sos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('sos.update', $sos->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{$sos->name}}">
                    </div>
                    <div class="form-group">
                        <label for="number">Number</label>
                        <input id="number" type="text" name="number" class="form-control" value="{{ $sos->number }}">
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control p-1">
                            <option value="active" {{ $sos->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $sos->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="service_location_id">Service Location</label>
                        <select class="form-control p-2" name="service_location_id" required>
                            @foreach($servicesLocations as $location)
                                <option value="{{$location->id}}" {{$location->id == $sos->service_location_id ? 'selected' : null}}>{{$location->name}}</option>
                            @endforeach

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