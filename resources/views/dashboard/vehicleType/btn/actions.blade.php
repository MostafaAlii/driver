<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#editvehicleType{{$row->id}}" data-effect="effect-scale"><i class="fa fa-edit"></i></button>
<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleted{{$row->id}}" data-effect="effect-scale"><i class="fa fa-trash"></i></button>

@include('dashboard.vehicleType.btn.edit')
@include('dashboard.vehicleType.btn.deleted')
