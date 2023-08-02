<div class="tab-pane fade" id="document-04" role="tabpanel" aria-labelledby="document-04-tab">
    <form action="{{-- route('drivers.updateProfile',['id'=>$data['driver']->id]) --}}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @honeypot
   
        @forelse ($data['driver']->profile->profileMedia as $media)
            <td>
                @if ($media->car_front_side)
                    <img src="{{ asset('dashboard/images/driver_document/' . $data['driver']->email . $data['driver']->phone . '_' . $data['driver']->profile->uuid . '/' . $media->car_front_side) }}" alt="Car Front Side" width="100">
                    <span>{{ \Str::ucfirst(str_replace('_', ' ', pathinfo($media->car_front_side, PATHINFO_FILENAME))) }}</span>
                @endif
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


      <!-- Start Submit button -->
      <div class="form-row center">
        <div class="col-md-12 center">
            <button type="submit" class="btn btn-success">Update Media Status</button>
        </div>
    </div>
    <!-- End Submit button -->
    </form>
</div>