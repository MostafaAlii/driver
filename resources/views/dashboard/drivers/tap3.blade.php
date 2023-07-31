<div class="tab-pane fade" id="document-04" role="tabpanel" aria-labelledby="document-04-tab">
    <form action="{{ route('drivers.updateProfile', ['id' => $data['driver']->id]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @honeypot
   
    tab3


      <!-- Start Submit button -->
      <div class="form-row center">
        <div class="col-md-12 center">
            <button type="submit" class="btn btn-success">Upload Photo</button>
        </div>
    </div>
    <!-- End Submit button -->
    </form>
</div>