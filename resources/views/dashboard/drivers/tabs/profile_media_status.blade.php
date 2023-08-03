<div class="tab-pane fade" id="document-04" role="tabpanel" aria-labelledby="document-03-tab">
    @php
        // Get the driver profile for the current driver
        $driver = \App\Models\DriverProfile::where('driver_id', $data['driver']->id)->first();

        // Get all the media files for the driver's profile
        $driverProfileMedia = \App\Models\DriverProfileMedia::where('driver_profile_id', $driver->id)->get();

        // Define an array to hold image data for each field
        $fieldImages = [
            'license_front' => [],
            'license_back' => [],
            'car_license_front' => [],
            'car_license_back' => [],
            'personal_identification_front' => [],
            'personal_identification_back' => [],
            'criminal_record' => [],
            'car_front_side' => [],
            'car_back_side' => [],
            'car_right_side' => [],
            'car_left_side' => [],
            'car_inside' => [],
            'car_plate' => [],
        ];

        // Iterate over all images and store images in their corresponding fields
        foreach ($driverProfileMedia as $media) {
            foreach ($fieldImages as $field => $images) {
                if ($media->$field) {
                    $fieldImages[$field][] = $media->$field;
                }
            }
        }
    @endphp

    <!-- Start Images Table -->
    <div class="table-responsive-sm">
        <table id="datatable" class="table table-striped table-bordered p-0">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Image Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fieldImages as $field => $images)
                    @if (!empty($images))
                        <tr>
                            <td>
                                @foreach ($images as $img)
                                    <img class="rounded" src="{{ asset('dashboard/images/driver_document/' . $data['driver']->email . $data['driver']->phone . '_' . $data['driver']->profile->uuid . '/' . $img) }}" alt="{{ \Str::ucfirst(str_replace('_', ' ', pathinfo($img, PATHINFO_FILENAME))) }}" width="100">
                                @endforeach
                            </td>
                            <td>{{ \Str::ucfirst(str_replace('_', ' ', pathinfo($field, PATHINFO_FILENAME))) }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="{{ $field }}-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Not Active
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="{{ $field }}-dropdown">
                                        <a class="dropdown-item" href="#" onclick="changeImageStatus('{{ $field }}', 'accept')">Accept</a>
                                        <a class="dropdown-item" href="#" onclick="changeImageStatus('{{ $field }}', 'reject')">Reject</a>
                                        <a class="dropdown-item" href="#" onclick="changeImageStatus('{{ $field }}', 'not_active')">Not Active</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- End Images Table -->
</div>


