@extends('admin.layouts.master')
@section('title')
    @lang('admin.services.create')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" type="text/css" />
    <style>
        #form-loader {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: black;
            z-index: 9999;
            opacity: .5;
            display: flex;
            justify-content: center;
            align-items: center
        }

        select.select2-dropdown {
            left: auto !important;
        }

        .select2-container .select2-selection--multiple .select2-selection__choice {
            padding-left: 20px !important;
        }
    </style>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div id="form-loader">
                <div class="spinner-border text-light" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            @lang('admin.services.create')
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            {{ Form::open(['route' => 'admin.services.store','id'=>'createservice-form','autocomplete'=>'on','class'=>'needs-validation','method'=>'POST','enctype'=>'multipart/form-data']) }}

                            @include('admin.services.form')

                            {!! Form::close() !!}
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>

    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script src="{{ URL::asset('assets/js/pages/admin-service-create.init.js') }}"></script>
@endpush
