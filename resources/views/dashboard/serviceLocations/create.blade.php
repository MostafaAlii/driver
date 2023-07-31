<div class="modal fade" id="createNewServiceLocation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create serviceLocation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('serviceLocation.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" required name="name" id="name" value="">
                    </div>

                    <div class="form-group">
                        <label for="name">currency Name</label>
                        <input type="text" class="form-control" required name="currency_name" id="currency_name"
                               value="">
                    </div>

                    <div class="form-group">
                        <label for="name">currency code</label>
                        <input type="text" class="form-control" required name="currency_code" id="currency_code"
                               value="">
                    </div>

                    <div class="form-group">
                        <label for="name">timezone</label>
                        <input type="text" class="form-control" required name="timezone" id="timezone" value="">
                    </div>

                    <div class="form-group p-1">
                        <label for="name">countries</label>
                        <select class="form-control p-2" name="country_id" required>
                            <option value="" disabled selected>-- Choose in countries --</option>
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
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
