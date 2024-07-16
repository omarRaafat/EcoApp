@extends('vendor.layouts.master')
@section('title')
    @lang('translation.type_of_employee.edit')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.app_name')
        @endslot
        @slot('link')
            {{route('vendor.type-of-employees.index')}}
        @endslot
        @slot('link_name')
            @lang('translation.type_of_employees')
        @endslot
        @slot('title')
            @lang('translation.type_of_employee.edit')
        @endslot
    @endcomponent
    {{ Form::model($data,['route' => ['vendor.type-of-employees.update',$data->id],'id'=>'editrole-form','autocomplete'=>'off','class'=>'needs-validation','method'=>'PATCH','files' => true]) }}

        @include('vendor.type_of_employees.form')

    {!! Form::close() !!}

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>

    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="{{ URL::asset('assets/js/pages/product_custom/profile_image.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        showImage('profile-img-file-input','profile-image');
    </script>

@endsection
