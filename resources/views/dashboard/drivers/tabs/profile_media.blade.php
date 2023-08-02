<div class="tab-pane fade" id="document-03" role="tabpanel" aria-labelledby="document-03-tab">
    <table>
        <tbody>
            @php
                $driver = \App\Models\DriverProfile::where('driver_id', $data['driver']->id)->first();
                $driverProfileMedia = \App\Models\DriverProfileMedia::where('driver_profile_id', $data['driver']->id)->first();
                $response = [];

                if (!$driverProfileMedia) {
                    $noMediaFound = true;
                } else {
                    $noMediaFound = false;
                    $columns = array_diff($driverProfileMedia->getFillable(), ['driver_profile_id']);
                    foreach ($columns as $column) {
                        if (!$driverProfileMedia->{$column}) {
                            continue;
                        }

                        $mediaFileStatus = \App\Models\MediaFilesStatus::where('driver_profiles_media_id', $driverProfileMedia->id)
                            ->where('type', $column)
                            ->where('status', 'accept')
                            ->first();

                        if ($mediaFileStatus) {
                            $response[] = [
                                'type' => $column,
                                'status' => $mediaFileStatus->status,
                                'image' => asset('dashboard/images/driver_document/' . $data['driver']->email . $data['driver']->phone . '_' . $data['driver']->profile->uuid . '/' . $driverProfileMedia->{$column}),
                            ];
                        }
                    }
                }
            @endphp

            @if ($noMediaFound)
                <tr>
                    <td colspan="2">
                        <div class="alert alert-warning" role="alert">
                            <strong>Warning!</strong> No media found.
                        </div>
                    </td>
                </tr>
            @else
                @forelse ($response as $media)
                        <td>
                            <img src="{{ $media['image'] }}" alt="{{ \Str::ucfirst(str_replace('_', ' ', pathinfo($media['image'], PATHINFO_FILENAME))) }}" width="100">
                            <span>{{ \Str::ucfirst(str_replace('_', ' ', pathinfo($media['type'], PATHINFO_FILENAME))) }}</span>
                        </td>
                @empty
                    <tr>
                        <td colspan="2">
                            <div class="alert alert-warning" role="alert">
                                <strong>Warning!</strong> No media found.
                            </div>
                        </td>
                    </tr>
                @endforelse
            @endif
            
        </tbody>
    </table>
</div>
