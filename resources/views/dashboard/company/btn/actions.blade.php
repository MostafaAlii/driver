<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#editCompany{{$company->id}}" data-effect="effect-scale"><i class="fa fa-edit"></i></button>
<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deletedCompany{{$company->id}}" data-effect="effect-scale"><i class="fa fa-trash"></i></button>

@include('dashboard.company.btn.edit')
@include('dashboard.company.btn.deleted')
