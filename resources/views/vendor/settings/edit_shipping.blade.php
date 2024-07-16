@extends('vendor.layouts.master')
@section('title')
    @lang('translation.edit_certificate_request')
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
            {{route('vendor.shipping.edit')}}
        @endslot
        @slot('title')
            @lang('translation.edit_shipping_type')
        @endslot
    @endcomponent


    <form action="{{ route('vendor.shipping.update')  }}" method="POST">
        @csrf
        <input type="hidden" name="_method" value="PATCH" />
        <div class="card">
            <div class="col-md-6 mb-3">
                <label class="form-label">@lang('admin.shipping_type')</label>
                <select name="shipping_type[]" multiple class="form-control" data-choices data-choices-removeItem>
                    @foreach($shipping_types ?? [] as $shipping_type)
                        <option value="{{ $shipping_type->id }}" @selected(in_array($shipping_type->id, (old("shipping_type") ?? [])))>
                            {{ $shipping_type->title }}
                        </option>
                    @endforeach
                </select>
                @error('shipping_type')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

        </div>

        <div class="text-end mb-3">
            <button type="submit" class="btn btn-success w-sm">@lang('translation.submit')</button>
        </div>
    </form>
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
