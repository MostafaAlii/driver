<div class="modal fade" id="editzone{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit zone</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('zone.update','test')}}" method="POST" enctype="multipart/form-data">
                   @method('PUT')
                    @csrf
                    <input type="hidden" name="id" value="{{$row->id}}">

                    <div class="form-group p-1">
                        <label for="name">Status</label>
                        <select class="form-control p-2" name="status" required>
                            <option value="" disabled selected>-- Choose in status --</option>
                            <option value="1" {{$row->status == true ? 'selected' : null}}>Active</option>
                            <option value="0" {{$row->status == false ? 'selected' : null}}>No Active</option>
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
