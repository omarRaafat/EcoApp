@extends('admin.layouts.master')
@section('title')
    @lang('admin.delivery.domestic-zones.title')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('admin.delivery.domestic-zones.create-title')</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.domestic-zones.store') }}">
                        @csrf
                        <div class="row gy-4">
                            @include("admin.domestic-zones.form")
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        $("#shipping_type").change(function() {
            if($(this).val() == "national") {
                $("#countries_list").hide()
                $("#cities_list").show()
                $(".national-extra-fields").show()
            } else if($(this).val() == "international") {
                $("#cities_list").hide()
                $(".national-extra-fields").hide()
                $("#countries_list").show()
            }
        });
    </script>
@endsection
