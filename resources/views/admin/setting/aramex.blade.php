@extends('admin.layouts.master')
@section('title')
    @lang('admin.shippingMethods.aramex_setting')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
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
                            <form action="{{ route('admin.settings.aramex.update')  }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @foreach($settings as $setting)
                                    <div class="form-group mb-2">
                                        <label class="form-label"> {{ $setting->desc }} </label>
                                        <input type="text" class="form-control" value="{{$setting->value}}" name="{{$setting->key}}">
                                        @error($setting->key)
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                @endforeach
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
