<button type="button" class="modal-effect btn btn-sm btn-primary" style="text-align: center !important" data-toggle="modal" data-target="#restoreDriver{{$driver->id}}" data-effect="effect-scale">
    <span class="icon text-white-50">
        <i class="fa fa-refresh"></i>
    </span>
</button>

<button type="button" class="modal-effect btn btn-sm btn-danger" style="text-align: center !important" data-toggle="modal" data-target="#forceDeleteDriver-{{$driver->id}}" data-effect="effect-scale">
    <span class="icon text-white-50">
        <i class="fa fa-trash"></i>
    </span>
</button>

@include('dashboard.drivers.btn.restore')
@include('dashboard.drivers.btn.forceDelete')