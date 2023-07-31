<div class="modal fade" id="deleted{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete vehicleType</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('vehicleType.destroy','test')}}" method="POST" enctype="multipart/form-data">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="id" value="{{$row->id}}">

                    <div class="form-group">
                        <label for="name">Are You Sure Deleted ?</label>
                        <input type="text" class="form-control" readonly id="name" value="{{$row->name}}">
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
