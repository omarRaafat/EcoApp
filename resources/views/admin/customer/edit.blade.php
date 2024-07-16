@extends('admin.layouts.master')
@section('title')
    @lang('admin.customer_edit')
@endsection
@section('content')
    <form class="needs-validation row" novalidate method="POST"
        action="{{ route('admin.customers.update', ['user' => $customer->id]) }}" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label">@lang('admin.customer_name')</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $customer->name }}" id="name">
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <div class="invalid-feedback">
                @lang('admin.please_enter_name')
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="username" class="form-label">@lang('admin.customer_phone')</label>
            <input type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $customer->phone }}" id="phone">
            @error('phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <div class="invalid-feedback">
                @lang('admin.please_enter_phone')
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="email" class="form-label">@lang('admin.customer_email')</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $customer->email }}" id="email">
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <div class="invalid-feedback">
                @lang('admin.please_enter_email')
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="text-end">
                <button type="submit" class="btn btn-primary">@lang('admin.save')</button>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
