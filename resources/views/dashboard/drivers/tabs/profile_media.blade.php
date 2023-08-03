<div class="tab-pane fade" id="document-03" role="tabpanel" aria-labelledby="document-03-tab">
    @php
        $driver = \App\Models\DriverProfile::where('driver_id', $data['driver']->id)->first();
        $driverProfileMedia = \App\Models\DriverProfileMedia::where('driver_profile_id', $data['driver']->id)->first();
        $response = [];
        $imagesByStatus = [
            'accept' => [],
            'reject' => [],
            'not_active' => [],
        ];

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
                    ->first();

                if ($mediaFileStatus) {
                    $response[$column] = [
                        'type' => $column,
                        'status' => $mediaFileStatus->status,
                        'image' => asset('dashboard/images/driver_document/' . $data['driver']->email . $data['driver']->phone . '_' . $data['driver']->profile->uuid . '/' . $driverProfileMedia->{$column}),
                    ];
                    $imagesByStatus[$mediaFileStatus->status][] = $column;
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
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="accordion plus-icon shadow">
                    {{-- Accept Images --}}
                    <div class="acd-group">
                        <a href="#" class="acd-heading">Accept Images</a>
                        <div class="acd-des images-grid">
                            @foreach ($imagesByStatus['accept'] as $column)
                                <div class="image-container">
                                    <img class="rounded" src="{{ $response[$column]['image'] }}" alt="{{ \Str::ucfirst(str_replace('_', ' ', pathinfo($response[$column]['image'], PATHINFO_FILENAME))) }}" width="100">
                                    <span>{{ \Str::ucfirst(str_replace('_', ' ', pathinfo($response[$column]['type'], PATHINFO_FILENAME))) }}</span>
                                </div>
                            @endforeach
                            @if (empty($imagesByStatus['accept']))
                                <div class="alert alert-warning" role="alert">
                                    <strong>Warning!</strong> No accepted images found.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Reject Images --}}
                    <div class="acd-group">
                        <a href="#" class="acd-heading">Reject Images</a>
                        <div class="acd-des images-grid">
                            @foreach ($imagesByStatus['reject'] as $column)
                                <div class="image-container">
                                    <img class="rounded" src="{{ $response[$column]['image'] }}" alt="{{ \Str::ucfirst(str_replace('_', ' ', pathinfo($response[$column]['image'], PATHINFO_FILENAME))) }}" width="100">
                                    <span>{{ \Str::ucfirst(str_replace('_', ' ', pathinfo($response[$column]['type'], PATHINFO_FILENAME))) }}</span>
                                </div>
                            @endforeach
                            @if (empty($imagesByStatus['reject']))
                                <div class="alert alert-warning" role="alert">
                                    <strong>Warning!</strong> No rejected images found.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Not Active Images --}}
                    <div class="acd-group">
                        <a href="#" class="acd-heading">Not Active Images (Waiting)</a>
                        <div class="acd-des images-grid">
                            @foreach ($imagesByStatus['not_active'] as $column)
                                <div class="image-container">
                                    <img class="rounded" src="{{ $response[$column]['image'] }}" alt="{{ \Str::ucfirst(str_replace('_', ' ', pathinfo($response[$column]['image'], PATHINFO_FILENAME))) }}" width="100">
                                    <span>{{ \Str::ucfirst(str_replace('_', ' ', pathinfo($response[$column]['type'], PATHINFO_FILENAME))) }}</span>
                                </div>
                            @endforeach
                            @if (empty($imagesByStatus['not_active']))
                                <div class="alert alert-warning" role="alert">
                                    <strong>Warning!</strong> No not active images found.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
