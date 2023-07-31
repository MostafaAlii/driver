@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/css/plugins/toastr.css') }}" rel="stylesheet">
@section('title')
{{$title}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{$company?->name . ' ' . $title}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('company.index')}}" class="default-color">Companies</a></li>
                <li class="breadcrumb-item active">{{$title . ' ' . $company?->name}}</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
@include('layouts.common.partials.messages')
<!-- start content-wrapper profile-page -->
<div class="profile-page">
    <!-- Start User Info -->
    <div class="row">
        <div class="col-lg-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <div class="user-bg" style="background: url({{asset('assets/images/user-bg.jpg') }});">
                        <div class="user-info">
                            <div class="row">
                                <div class="col-lg-6 align-self-center">
                                    <div class="user-dp"><img src="{{$company?->getFirstMediaUrl(Company::COLLECTION_NAME);}}" alt="{{$company?->name}}"></div>
                                    <div class="user-detail">
                                        <h2 class="name text-dark">{{$company?->name}}</h2>
                                        <p class="designation mb-0">{{ucfirst($company?->email)}}</p>
                                        <p class="designation mb-0">From {{ucfirst($company?->country->name . ' / ' . $company?->state)}}</p>
                                        <p class="designation mb-0">Phone : {{ucfirst($company?->mobile)}}</p>
                                        <p class="designation mb-0">Landline : {{ucfirst($company?->landline)}}</p>
                                        <p class="designation mb-0">By {{ucfirst($company?->admin->name)}}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 text-right align-self-center">
                        
                                    <form id="toggleForm{{ $company->id }}" method="POST" action="{{ route('company.updateStatus',$company->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <select class="form-control p-2" name="status" style="outline-style:none;" onchange="this.form.submit();">
                                            <option value="1" {{$company->status == true ? 'selected' : ''}}>Active</option>
                                            <option value="0" {{$company->status == false ? 'selected' : ''}}>Inactive</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End User Info -->
</div>
<!-- end content-wrapper profile-page -->
@endsection
@section('js')
<script>
        function toggleStatus(adminId) {
            const form = document.getElementById('toggleForm' + adminId);
            form.submit();
        }
</script>
@endsection