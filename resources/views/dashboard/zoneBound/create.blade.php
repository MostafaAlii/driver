<div class="modal fade" id="createtimeZones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create {{$title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('timeZones.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" required name="name" id="name" value="">
                    </div>


                    <div class="form-group">
                        <label for="name">timezone</label>
                        <input type="text" class="form-control" required name="timezone" id="timezone" value="">
                    </div>

                    <div class="form-group p-1">
                        <label for="name">Status</label>
                        <select class="form-control p-2" name="active" required>
                            <option value="" disabled selected>-- Choose in status --</option>
                            <option value="1">Active</option>
                            <option value="0">No Active</option>
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
