@extends('layouts.master')
@section('css')
    @section('title')
        {{$title}}
    @stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0"> {{$title}}</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                    <li class="breadcrumb-item"><a href="{{route('admins.index')}}" class="default-color">Admins</a>
                    </li>
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
                    <!-- Start Add New Admins Form -->
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <!-- Start Form -->
                            <form action="{{route('admins.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @honeypot
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control" name="image" id="image">
                                        @error('image')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Start First Row -->
                                <div class="form-row">
                                    <!-- Start Name -->
                                    <div class="form-group col-md-6">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                               placeholder="Name">
                                        @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- End Name -->
                                    <!-- Start Email -->
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                               placeholder="Email">
                                        @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- End Email -->
                                </div>
                                <!-- End First Row -->

                                <!-- Start Second Row -->
                                <div class="form-row">
                                    <!-- Start Password -->
                                    <div class="form-group col-md-6">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" name="password" id="password"
                                               placeholder="Password">
                                        @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- End Password -->
                                    <!-- Start Phone Number -->
                                    <div class="form-group col-md-6">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" class="form-control" name="phone" id="phone"
                                               placeholder="Phone Number">
                                        @error('phone')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- End Phone Number -->
                                </div>
                                <!-- End Second Row -->

                                <!-- Start Type Selected and Status Selected -->
                                <div class="form-row">
                                    <!-- Start Type Selected -->
                                    <div class="form-group col-md-6">
                                        <label for="type">Type</label>
                                        <select name="type" class="form-control p-1">
                                            <option selected disabled>Select Admin Type...</option>
                                            @foreach (getTypeAdmin() as $case)

                                                <option
                                                    value="{{ $case }}" {{ old('type') == $case ? 'selected' : '' }}>
                                                    {{ $case }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('type')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- End Type Selected -->
                                    <!-- Start Status Status -->
                                    <div class="form-group col-md-6">
                                        <label for="status">Status</label>
                                        <select name="status" class="form-control p-1">
                                            <option selected disabled>Select Admin Status...</option>
                                            @foreach (AdminStatus::cases() as $case)
                                                <option
                                                    value="{{ $case }}" {{ old('status') == $case ? 'selected' : '' }}>
                                                    {{ $case }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Start Country Status -->
                                    <div class="form-group col-md-6">
                                        <label for="status">Countries</label>
                                        <select name="country_id" required class="form-control p-1">
                                            <option selected disabled>Select Countries Status...</option>
                                            @foreach ($countries as $country)
                                                <option value="{{$country->id}}">
                                                    {{$country->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- End Status Selected -->
                                </div>
                                <!-- End Type Selected and Status Selected -->
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </form>
                            <!-- End Form -->
                        </div>
                    </div>
                    <!-- End Add New Admins Form -->
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
            integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
