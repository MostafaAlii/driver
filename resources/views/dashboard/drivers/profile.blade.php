@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/css/plugins/toastr.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
.images-grid {display: grid;grid-template-columns: repeat(3, 1fr);gap: 10px;}
.image-container {display: flex;flex-direction: column;align-items: center;}
.image-container img {max-width: 100%;}
.image-container span {margin-top: 5px;}
</style>
@section('title')
{{$title}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{$data['driver']->name . ' ' . $title}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('drivers.index')}}" class="default-color">Drivers</a></li>
                <li class="breadcrumb-item active">{{$title . ' ' . $data['driver']->name}}</li>
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
                                <div class="col-lg-4 align-self-center">
                                    <div class="user-dp"><img
                                            src="{{ $data['driver']->profile?->avatar ? asset('dashboard/images/driver_document/' . $data['driver']->email . $data['driver']->phone . '_' . $data['driver']->profile->uuid  . '/' . $data['driver']->profile->avatar) : asset('dashboard/default/default_admin.jpg') }}"
                                            alt="{{$data['driver']?->name}}"></div>
                                    <div class="user-detail">
                                        <h4 class="nametext-light">
                                            <span style="font-size: 12px;" class="fa fa-circle text-{{ $data['driver']?->online == 1 ? 'success' : 'danger' }}"></span>
                                            {{ $data['driver']->name }}
                                        </h4>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 text-left align-self-center">
                                    <form id="toggleForm{{ $data['driver']->id }}" method="POST"
                                        action="{{ route('drivers.updateStatus', $data['driver']?->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <label>Status</label>
                                        <select class="form-control p-2" name="status" style="outline-style:none;"
                                            onchange="this.form.submit();">
                                            <option value="{{ DriverStatus::ACTIVE }}" {{$data['driver']->status ==
                                                'active' ? 'selected' : ''}}>Active</option>
                                            <option value="{{ DriverStatus::INACTIVE }}" {{$data['driver']?->status ==
                                                'inactive' ? 'selected' : ''}}>Inactive</option>
                                        </select>
                                    </form>
                                </div>
                                
                                {{-- Check Data Success --}}
                                <div class="col-lg-4 text-left align-self-center">
                                    <form id="toggleForm{{ $data['driver']->id }}" method="POST"
                                        action="{{ route('drivers.updateApprovalTripStatus',$data['driver']->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <label>Start Approval Trip</label>
                                        <select class="form-control p-2" name="status" style="outline-style:none;"
                                            onchange="this.form.submit();">
                                            <option value="1" {{$data['driver']->profile?->status ==
                                                1 ? 'selected' : ''}}>Approve</option>
                                            <option value="0" {{$data['driver']->profile?->status ==
                                                0 ? 'selected' : ''}}>Not Approve</option>
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

    <!-- Start Content -->
    <div class="row">
        <!-- Start About Me -->
        <div class="col-xl-4 mb-30">
            <div class="card mb-30 about-me">
                <div class="card-body">
                    <h5 class="card-title"> About Me</h5>
                    <p>{{ $data['driver']->profile?->bio }}</p>
                    <ul class="list-unstyled ">
                        <li class="list-item"><span class="text-info ti-mobile"></span>{{ $data['driver']?->phone }}
                        </li>
                        <li class="list-item"><span class="text-warning ti-email"></span>
                            {{ $data['driver']?->email }}
                        </li>
                        <li class="list-item"><span class="text-success ti-facebook"></span>{{ $data['driver']?->email
                            }}</li>
                        <li class="list-item"><span class="text-danger ti-twitter"></span>{{ $data['driver']?->email }}
                        </li>
                        <li class="list-item"><span class="text-dark ti-direction-alt"></span>
                            {{ $data['driver']->profile?->address }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card card-statistics">
                <div class="card-body">
                    <h5 class="card-title">Map</h5>
                    <div id="map" style="width:100%;height:400px;"></div>
                </div>
            </div>
        </div>
        <!-- End About Me -->

        <!-- Start Dropdown menus -->
        <div class="col-xl-8 mb-30">
            <div class="card mb-30">
                <div class="card-body">
                    <div class="comment-block">
                        <div class="form-group mb-0">
                           
                                <div class="tab nav-bt">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active show" id="profile-03-tab" data-toggle="tab" href="#profile-03" role="tab" aria-controls="profile-03" aria-selected="true">Profile</a>
                                        </li>

                                       

                                        <li class="nav-item">
                                            <a class="nav-link" id="document-03-tab" data-toggle="tab" href="#document-03" role="tab" aria-controls="document-03" aria-selected="false">Media</a>
                                        </li>


                                        <li class="nav-item">
                                            <a class="nav-link" id="document-04-tab" data-toggle="tab" href="#document-04" role="tab" aria-controls="document-04" aria-selected="false">Media Status</a>
                                        </li>
                                       
                                    </ul>
                                    
                                    <div class="tab-content">
                                        <!-- Start Profile Contents -->
                                    
                                        @include('dashboard.drivers.tabs.profile_content')
                                        <!-- End Profile Contents -->


                                        @include('dashboard.drivers.tabs.profile_media')


                                        @include('dashboard.drivers.tabs.profile_media_status')


                                     
                                        <!-- Start Documents Contents -->
                                       
                                        <!-- End Documents Contents -->
                                    </div>
                                </div>
                              
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Dropdown menus -->
    </div>
    <!-- End Content -->
</div>
<!-- end content-wrapper profile-page -->
@endsection
@section('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    var map = L.map('map').setView([{{ $data['driver']->driverDetails->longitude }}, {{ $data['driver']->driverDetails->latitude }}], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    var marker = L.marker([{{ $data['driver']->driverDetails->longitude }}, {{ $data['driver']->driverDetails->latitude }}]).addTo(map);
    
    const colorInput = document.querySelector('input[name="car_color"]');
    const colorPreview = document.getElementById('colorPreview');
    colorInput.addEventListener('change', function() {
        const selectedColor = colorInput.value;
        colorPreview.style.backgroundColor = selectedColor;
        colorPreview.style.display = 'block';
    });
</script>
@endsection