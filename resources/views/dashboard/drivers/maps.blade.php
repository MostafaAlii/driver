@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@section('title')
{{$title}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0"> {{$title . ' '}} <span class="badge badge-success">{{ Driver::whereOnline(true)->count() }}</span></h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}" class="default-color">Dasboard</a></li>
                <li class="breadcrumb-item active">{{$title}}</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
@include('layouts.common.partials.messages')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <!-- Start Map -->
                <!--<div id="map" style="height: 500px;"></div>-->
                
                  <div id="map" style='height:800px'></div>
                <!-- End Map -->
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection

@section('js')
 <script>
    function initializeMap() {
        const locations = {!! $data !!};
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 13,
            center: { lat: locations[locations.length - 1].lat, lng: locations[locations.length - 1].lan },
        });
        const infowindow = new google.maps.InfoWindow();
        const bounds = new google.maps.LatLngBounds();
        for (const location of locations) {
            const marker = new google.maps.Marker({
                position: new google.maps.LatLng(location.lat, location.lan),
                map: map,
                icon: {
                    url: location.image,
                    scaledSize: new google.maps.Size(32, 32)
                }
            });
            bounds.extend(marker.position);
            google.maps.event.addListener(marker, 'click', (function (marker, location) {
                return function () {
                    const content = location.name + "<br>" + location.phone;
                    infowindow.setContent(content);
                    infowindow.open(map, marker);
                };
            })(marker, location));
        }
        map.fitBounds(bounds);
    }
    document.addEventListener('DOMContentLoaded', function () {
        initializeMap();
    });
</script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initializeMap"></script>
@endsection