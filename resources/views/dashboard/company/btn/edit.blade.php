<div class="modal fade" id="editCompany{{$company->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit {{ $company->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('company.update',$company->id)}}" method="POST" enctype="multipart/form-data">
                   @method('PUT')
                    @csrf
                    @honeypot
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" required name="name" id="name" value="{{$company->name}}">
                    </div>

                    <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" class="form-control" required name="state" id="state" value="{{$company->state}}">
                    </div>

                    <div class="form-group">
                        <label for="email">email</label>
                        <input type="text" class="form-control" required name="email" id="email" value="{{$company->email}}">
                    </div>


                    <div class="form-group p-1">
                        <label for="name">Country</label>
                        <select class="form-control p-2" name="country_id" required>
                            <option value="" disabled selected>-- Choose in country --</option>
                            @foreach($countries as $country)
                                <option value="{{$country->id}}" {{$country->id == $company->country_id ? 'selected' : null}}>{{$country->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group p-1">
                        <label for="name">Status</label>
                        <select class="form-control p-2" name="status" required>
                            <option value="" disabled selected>-- Choose in status --</option>
                            <option value="1" {{$company->status == 1 ? 'selected' : null}}>Active</option>
                            <option value="0" {{$company->status == 0 ? 'selected' : null}}>No Active</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="mobile">Mobile</label>
                        <input id="mobile" type="phone" name="mobile" class="form-control" value="{{ $company->mobile }}">
                    </div>

                    <div class="form-group">
                        <label for="landline">Landline</label>
                        <input id="landline" type="phone" name="landline" class="form-control" value="{{ $company->landline }}">
                    </div>

                    <div class="form-group">
                        <label for="postal_code">Postal-Code</label>
                        <input id="postal_code" type="phone" name="postal_code" class="form-control" value="{{ $company->postal_code }}">
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" name="address" id="address" placeholder="Address">{{ $company->address }}</textarea>
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
