@extends('admin.layouts.master')
@section('title')
    @lang('admin.settings.main')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-6">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            @lang('admin.settings.main')
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.settings.update', ['setting' => $setting]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <label class="form-label"> {{ $setting->desc }} </label>
                                    @switch($setting->input_type)
                                        @case('text')
                                            <textarea class="form-control" name="value">{{$setting->value}}</textarea>
                                            @break
                                        @case('date')
                                                <input type="date" class="form-control" value="{{$setting->value}}" name="value">
                                            @break
                                        @case('image')
                                            <input type="file" class="form-control"  name="value">
                                            @break
                                        @case('pdf')
                                            <input type="file" class="form-control" name="value">
                                            @break
                                        @case('email')
                                            <input type="email" class="form-control" value="{{$setting->value}}" name="value">
                                            @break
                                        @case('phone')
                                            <input type="phone" class="form-control" value="{{$setting->value}}" name="value">
                                            @break
                                        @default
                                            <input type="text" class="form-control" value="{{$setting->value}}" name="value">
                                    @endswitch
                                    @error('value')
                                        <span class="error text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        @lang('admin.settings.edit')
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
