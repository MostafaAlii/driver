<div class="modal fade" id="editDriver{{$driver->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Driver</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('drivers.update', $driver->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{$driver->name}}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" class="form-control" value="{{ $driver->email }}">
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input id="phone" type="phone" name="phone" class="form-control" value="{{ $driver->phone }}">
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control p-1">
                            <option value="active" {{ $driver->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $driver->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="country_id">Country</label>
                        <select name="country_id" id="country_id" class="form-control p-1">
                            @foreach (\DB::table('countries')->get(['id', 'name']) as $country)
                                <option value="{{ $country->id }}" {{ $driver->country_id == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-control p-1">
                            <option value="male" {{ $driver->gender == 'male' ? 'selected' : '' }}>male</option>
                            <option value="female" {{ $driver->gender == 'female' ? 'selected' : '' }}>female</option>
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