@extends('vendor.layouts.master')
@section('title')
    @lang('translation.create-product')
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
    </style>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.app_name')
        @endslot
        @slot('link')
            {{route('vendor.products.index')}}
        @endslot
        @slot('link_name')
            @lang('translation.products')
        @endslot
        @slot('title')
            @lang('translation.create_product')
        @endslot
    @endcomponent
    {{ Form::open(['route' => 'vendor.products.store','id'=>'createproduct-form','autocomplete'=>'off','class'=>'needs-validation','method'=>'POST','enctype'=>'multipart/form-data']) }}

        @include('vendor.products.form')

    {!! Form::close() !!}

@endsection
@section('script')

<script type="text/javascript">
    $(document).ready(function() {
       $('.ckeditor').ckeditor();
    });
</script>
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>

    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script src="{{ URL::asset('assets/js/pages/vendor-product-create.init.js') }}"></script>


    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
