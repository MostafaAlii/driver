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
                <!-- Start Content -->
                <table class="table display nowrap table-striped table-bordered scroll-horizontal">
                    <thead class="">
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Native Name</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        @forelse ($languages as $key => $language)
                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td>
                                <a href="#" class="language-link" data-toggle="modal" data-target="#langModal{{ $key }}">{{ $key }}</a>
                            </td>
                            <td>{{ $language['name'] }}</td>
                            <td>{{ $language['native'] }}</td>
                            <td>
                                {!! $language['status'] ? ' <i class="fa fa-check-circle text-success"></i> ' : ' <i class="fa fa-times-circle text-danger"></i> ' !!}
                            </td>
                            @if(request()->segment(1) !== $key)
                                <td>
                                    <form action="{{ route('languages.update',$key) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="checkbox" name="status" value="1" {{ $language['status'] ? 'checked' : '' }} onchange="this.form.submit()">
                                    </form>
                                </td>
                            @endif
                        </tr>
                          @include('dashboard.settings.languages.btn.langModal')
                        @empty
                        <tr>
                            <td colspan="3">Sorry No Language Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- End Content -->
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')
@endsection
