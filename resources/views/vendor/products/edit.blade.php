@extends('vendor.layouts.master')
@section('title')
    @lang('admin.products.update')
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
    </style>
@endsection
@section('content')
    @include('sweetalert::alert')
    @component('components.breadcrumb')
        @slot('li_1')
            Ecommerce
        @endslot
        @slot('title')
            @lang('translation.edit_product')
        @endslot
    @endcomponent
    {{ Form::model($row,['route' => ['vendor.products.update',$row->id],'id'=>'createproduct-form','autocomplete'=>'off','class'=>'needs-validation','method'=>'PATCH','enctype'=>'multipart/form-data']) }}

        @include('vendor.products.form')

    {!! Form::close() !!}

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>

    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script src="{{ URL::asset('assets/js/pages/vendor-product-create.init.js') }}"></script>

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
