<button type="button" class="modal-effect btn btn-sm btn-primary" style="text-align: center !important" data-toggle="modal" data-target="#editSos{{$sos->id}}" data-effect="effect-scale">
    <span class="icon text-white-50">
        <i class="fa fa-edit"></i>
    </span>
</button>

<button type="button" class="modal-effect btn btn-sm btn-danger" style="text-align: center !important" data-toggle="modal" data-target="#deleteSos-{{$sos->id}}" data-effect="effect-scale">
    <span class="icon text-white-50">
        <i class="fa fa-trash"></i>
    </span>
</button>

@include('dashboard.sos.btn.edit')
@include('dashboard.sos.btn.delete')

