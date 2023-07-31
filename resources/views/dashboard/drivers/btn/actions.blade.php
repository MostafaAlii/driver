<button type="button" class="modal-effect btn btn-sm btn-primary" style="text-align: center !important" data-toggle="modal" data-target="#editDriver{{$driver->id}}" data-effect="effect-scale">
    <span class="icon text-white-50">
        <i class="fa fa-edit"></i>
    </span>
</button>

<button type="button" class="modal-effect btn btn-sm btn-danger" style="text-align: center !important" data-toggle="modal" data-target="#deleteDriver-{{$driver->id}}" data-effect="effect-scale">
    <span class="icon text-white-50">
        <i class="fa fa-trash"></i>
    </span>
</button>

@include('dashboard.drivers.btn.edit')
@include('dashboard.drivers.btn.delete')

