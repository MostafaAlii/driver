<button type="button" class="modal-effect btn btn-sm btn-primary" style="text-align: center !important" data-toggle="modal" data-target="#editAdmin{{$admin->id}}" data-effect="effect-scale">
    <span class="icon text-white-50">
        <i class="fa fa-edit"></i>
    </span>
</button>

<button type="button" class="modal-effect btn btn-sm btn-danger" style="text-align: center !important" data-toggle="modal" data-target="#deleteAdmin-{{$admin->id}}" data-effect="effect-scale">
    <span class="icon text-white-50">
        <i class="fa fa-trash"></i>
    </span>
</button>

@include('dashboard.admins.btn.edit')
@include('dashboard.admins.btn.delete')

