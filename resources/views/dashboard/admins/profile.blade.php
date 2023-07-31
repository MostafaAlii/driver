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
            <h4 class="mb-0">{{$admin?->name . ' ' . $title}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admins.index')}}" class="default-color">Admins</a></li>
                <li class="breadcrumb-item active">{{$title . ' ' . $admin?->name}}</li>
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
                                    <div class="user-dp"><img src="{{$admin?->getFirstMediaUrl(Admin::COLLECTION_NAME);}}" alt="{{$admin?->name}}"></div>
                                    <div class="user-detail">
                                        <h2 class="name text-light">{{$admin?->name}}</h2>
                                        <p class="designation mb-0">{{ucfirst($admin?->type)}}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 text-right align-self-center">
                        
                                    <form id="toggleForm{{ $admin->id }}" method="POST" action="{{ route('admins.updateStatus', $admin->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <select class="form-control p-2" name="status" style="outline-style:none;" onchange="this.form.submit();">
                                            <option value="{{ AdminStatus::ACTIVE }}" {{$admin->status == 'active' ? 'selected' : ''}}>Active</option>
                                            <option value="{{ AdminStatus::INACTIVE }}" {{$admin?->status == 'inactive' ? 'selected' : ''}}>Inactive</option>
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