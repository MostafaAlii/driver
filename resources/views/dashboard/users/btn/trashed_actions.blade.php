<button type="button" class="modal-effect btn btn-sm btn-primary" style="text-align: center !important" data-toggle="modal" data-target="#restoreUser{{$user->id}}" data-effect="effect-scale">
    <span class="icon text-white-50">
        <i class="fa fa-refresh"></i>
    </span>
</button>

<button type="button" class="modal-effect btn btn-sm btn-danger" style="text-align: center !important" data-toggle="modal" data-target="#forceDeleteUser-{{$user->id}}" data-effect="effect-scale">
    <span class="icon text-white-50">
        <i class="fa fa-trash"></i>
    </span>
</button>

@include('dashboard.users.btn.restore')
@include('dashboard.users.btn.forceDelete')