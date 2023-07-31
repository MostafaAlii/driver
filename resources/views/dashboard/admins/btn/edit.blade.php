<div class="modal fade" id="editAdmin{{$admin->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admins.update', $admin->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <img class="center"
                             src="{{ $admin->getFirstMediaUrl(Admin::COLLECTION_NAME) ? $admin->getFirstMediaUrl(Admin::COLLECTION_NAME) : asset('dashboard/default/default_admin.jpg') }}"
                             alt="" style="width: 100px; height: 100px; border-radius: 50%;">
                        <label for="image">Avatar</label>
                        <input id="image" type="file" name="image" class="form-control">
                        <small class="form-text text-muted">Maximum file size is 10 MB</small>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{$admin->name}}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" class="form-control" value="{{ $admin->email }}">
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input id="phone" type="phone" name="phone" class="form-control" value="{{ $admin->phone }}">
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control p-1">
                            <option value="active" {{ $admin->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $admin->status == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="type">Type</label>

                        <select name="type" id="type" class="form-control p-1">
                            <option value="admin" {{ $admin->type == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="supervisor" {{ $admin->type == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                            @if(get_user_data()->type == "general")
                                <option value="general" {{ $admin->type == 'general' ? 'selected' : '' }}>General</option>
                            @endif
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
