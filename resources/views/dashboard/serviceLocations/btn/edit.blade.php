<div class="modal fade" id="editNewServiceLocation{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit serviceLocation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('serviceLocation.update','test')}}" method="POST" enctype="multipart/form-data">
                   @method('PUT')
                    @csrf
                    <input type="hidden" name="id" value="{{$row->id}}">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" required name="name" id="name" value="{{$row->name}}">
                    </div>

                    <div class="form-group">
                        <label for="name">currency Name</label>
                        <input type="text" class="form-control" required name="currency_name" id="currency_name"
                               value="{{$row->currency_name}}">
                    </div>

                    <div class="form-group">
                        <label for="name">currency code</label>
                        <input type="text" class="form-control" required name="currency_code" id="currency_code"
                               value="{{$row->currency_code}}">
                    </div>

                    <div class="form-group">
                        <label for="name">timezone</label>
                        <input type="text" class="form-control" required name="timezone" id="timezone" value="{{$row->timezone}}">
                    </div>

                    <div class="form-group p-2">
                        <label for="name">countries</label>
                        <select class="form-control p-2" name="country_id" required>
                            @foreach($countries as $country)
                                <option value="{{$country->id}}" {{$country->id == $row->country_id ? 'selected' : null}}>{{$country->name}}</option>
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
