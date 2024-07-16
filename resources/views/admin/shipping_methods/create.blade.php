@extends('admin.layouts.master')
@section('title')
    @lang('admin.shippingMethods.create')
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex mb-3">
                    <h4 class="card-title mb-0 flex-grow-1">
                        @lang('admin.shippingMethods.create')
                    </h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.shipping-methods.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row gy-4">
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
    </div>
@endsection
@section('script')
@endsection
