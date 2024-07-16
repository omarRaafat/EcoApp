@extends('admin.layouts.master')
@section('title')
    @lang('admin.products.update')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            @lang('admin.products.update')
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            {{ Form::model($row,['route' => ['admin.products.update',$row->id],'id'=>'createproduct-form','autocomplete'=>'off','class'=>'needs-validation','method'=>'PATCH','enctype'=>'multipart/form-data']) }}

                            @include('admin.products.form')

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

    <script src="{{ URL::asset('assets/js/pages/admin-product-create.init.js') }}"></script>

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
@endpush
