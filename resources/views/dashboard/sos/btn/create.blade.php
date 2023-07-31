<div class="modal fade" id="createNewSos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create {{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('sos.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" required name="name" id="name" value="">
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Number</label>
                        <input type="text" class="form-control" required name="number" id="number" value="">
                        @error('number')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group p-1">
                        <label for="name">Service Location</label>
                        <select class="form-control p-2" name="service_location_id" required>
                            <option value="" disabled selected>-- Choose in Service Location --</option>
                            @foreach($servicesLocations as $servicesLocation)
                                <option value="{{$servicesLocation->id}}">{{$servicesLocation->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Start Status Status -->
                    <div class="form-group p-1">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option selected disabled>Select Sos Status...</option>
                            @foreach (SosStatus::cases() as $case)
                                <option value="{{ $case }}" {{ old('status') == $case ? 'selected' : '' }}>
                                    {{ $case }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- End Status Selected -->


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
