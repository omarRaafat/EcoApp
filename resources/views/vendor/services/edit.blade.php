@extends('vendor.layouts.master')
@section('title')
    @lang('admin.services.update')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
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
            color: #000;
        }
    </style>
@endsection
@section('content')
@if($errors->any())
    <div class="alert alert-danger text-right mt-1">
        @foreach ($errors->all() as $error)
            <p style="margin:0">{{ $error }}</p>
        @endforeach
    </div>
@endif
<div id="form-loader">
    <div class="spinner-border text-light" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
    @include('sweetalert::alert')
    @component('components.breadcrumb')
        @slot('li_1')
            Ecommerce
        @endslot
        @slot('title')
            @lang('translation.edit_service')
        @endslot
    @endcomponent
    {{ Form::model($row,['route' => ['vendor.services.update',$row->id],'id'=>'createservice-form','autocomplete'=>'off','class'=>'needs-validation','method'=>'PATCH','enctype'=>'multipart/form-data']) }}

        @include('vendor.services.form')

    {!! Form::close() !!}

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>

    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script src="{{ URL::asset('assets/js/pages/vendor-service-create.init.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        //dropzone is defined before at assets/js/pages/ecommerce-product-create.init.js
        let mockFile = null;
        @foreach($row->images as $image)
        productImages_ids.push('{{$image->id}}')
        $('#images-hidden').val(productImages_ids.toString())

        mockFile = { name: "Image{{$image->id}}", size: 12345, id: {{$image->id}} };
        dropzone.displayExistingFile(mockFile, "{{ $image->square_image }}", null, null, false);
        @endforeach
    </script>
@endsection
