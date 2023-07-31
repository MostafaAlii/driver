<div class="modal fade" id="restoreUser{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Restore User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.restore',$user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <h3>
                        Are You Sure To Restore   
                        <span class="text-primary">{{ $user->name }}</span>
                    </h3>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Restore</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>