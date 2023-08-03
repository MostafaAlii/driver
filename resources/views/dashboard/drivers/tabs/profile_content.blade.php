<div class="tab-pane fade active show" id="profile-03" role="tabpanel" aria-labelledby="profile-03-tab">
    <!-- Start Bio -->
    <form action="{{ route('drivers.updateProfile', ['id' => $data['driver']->id]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @honeypot
        <div class="form-row">
            <div class="form-group col-md-12">
                <textarea id="summernote" name="bio">
                                                        {{ $data['driver']->profile->bio }}
                                                    </textarea>
            </div>
        </div>

        <!--End Bio -->
        <!-- Start vehicle_types select -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="type">Vehicle Types</label>
                <select name="vehicle_type_id" class="form-control p-1">
                    <option selected disabled>Select Vehicle Type Type...</option>
                    @foreach ($data['vehicle_types'] as $vehicle_type)
                    <option value="{{ $vehicle_type->id }}" @if ($vehicle_type->id ==
                        $data['driver']->profile->vehicle_type_id)
                        selected
                        @endif>
                        {{ $vehicle_type->name }}
                    </option>
                    @endforeach
                </select>
                @error('vehicle_type_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <!-- End vehicle_types select -->
        <!-- Start Car Make && Cars Model Select -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="type">Cars Make</label>
                <select name="car_make_id" class="form-control p-1">
                    <option selected disabled>Select Car Make Type...</option>
                    @foreach ($data['car_makes'] as $car_make)
                    <option value="{{ $car_make->id }}" @if ($car_make->id ==
                        $data['driver']->profile->car_make_id)
                        selected
                        @endif>
                        {{ $car_make->name }}
                    </option>
                    @endforeach
                </select>
                @error('car_make_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="type">Cars Model</label>
                <select name="car_model_id" class="form-control p-1">
                    <option selected disabled>Select Car Model Type...</option>
                    @foreach ($data['car_models'] as $car_model)
                    <option value="{{ $car_model->id }}" @if ($car_model->id ==
                        $data['driver']->profile->car_model_id)
                        selected
                        @endif>
                        {{ $car_model->name }}
                    </option>
                    @endforeach
                </select>
                @error('car_model_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <!-- End Car Make && Cars Model Select -->
        <!-- Start Car Number && Car Color -->
        <div class="form-row">
            <!-- Start Car Number -->
            <div class="form-group col-md-6">
                <label for="type">Car Number</label>
                <input type="text" name="car_number" class="form-control p-1"
                    value="{{ $data['driver']->profile->car_number }}">
                @error('car_number')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- End Car Number -->
            <!-- Start Car Color -->
            <div class="form-group col-md-6">
                <label for="type">Car Color</label>
                <input type="color" name="car_color" class="form-control p-1"
                    value="{{ $data['driver']->profile->car_color }}">
                @error('car_color')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div id="colorPreview" class="img-fluid"
                    style="width: 50px; height: 50px; border-radius: 50%; background-color: {{ $data['driver']->profile->car_color }}; @if($data['driver']->profile->car_color) display: block; @else display: none; @endif">
                </div>
            </div>
            <!-- End Car Color -->
        </div>
        <!-- End Car Number && Car Color -->
        <!-- Start Total today_trip_count && total_accept && total_reject count -->
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="today_trip_count">Total Today Trip</label>
                <input type="number" class="form-control p-1" value="{{ $data['driver']->profile->today_trip_count }}"
                    readonly>
                @error('today_trip_count')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="total_accept">Total Accept</label>
                <input type="number" class="form-control p-1" value="{{ $data['driver']->profile->total_accept }}"
                    readonly>
                @error('total_accept')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="acceptance_ratio">Acceptance Ratio %</label>
                <input type="number" class="form-control p-1" value="{{ $data['driver']->profile->acceptance_ratio }}"
                    readonly>
                @error('acceptance_ratio')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <!-- End Total today_trip_count && total_accept && total_reject count -->
        <!-- Start last_trip_date -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="last_trip_date">Last Trip Date</label>
                <div class="input-group date display-years" data-date-format="dd-mm-yyyy"
                    data-date="{{ $data['driver']->profile->last_trip_date }}">
                    <input class="form-control" readonly name="last_trip_date" type="text"
                        value="{{ $data['driver']->profile->last_trip_date }}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="nationality_id" class="col-md-6">Nationality</label>
                <input type="number" class="form-control" name="nationality_id"
                    value="{{ $data['driver']->profile?->nationality_id}}" required>
            </div>
        </div>

        <!-- Start Submit button -->
        <div class="form-row center">
            <div class="col-md-12 center">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
        <!-- End Submit button -->
    </form>
    <!-- End last_trip_date -->
</div>