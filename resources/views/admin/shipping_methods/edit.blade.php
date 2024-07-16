@extends('admin.layouts.master')
@section('title')
    @lang('admin.shippingMethods.edit')
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex mb-3">
                <h4 class="card-title mb-0 flex-grow-1">
                    @lang('admin.shippingMethods.create')
                </h4>
            </div><!-- end card header -->
            <div class="card-body">
                <form method="POST" action="{{ route('admin.shipping-methods.update',$shippingMethod->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row gy-4">
                        <div class="col-lg-12 mb-3">
                            <img src="{{$shippingMethod->logo}}" style="height: 130px;width: 130px;margin-top: 7px;border-radius: 5px;" alt="">
                        </div>
                        @include("admin.shipping_methods.form")
                        <div class="col-md-12 mb-3">
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary"> @lang('admin.save') </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
