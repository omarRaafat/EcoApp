@extends('admin.layouts.master')
@section('title')
    @lang('client-messages.edit')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="productClasses">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('client-messages.edit')</h5>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.client-messages.update', ['client_message' => $clientMessage]) }}" method="POST">
                        @csrf
                        @method("PUT")
                        <div class="alert alert-warning"> @lang('client-messages.hint') </div>
                        <div class="alert alert-warning">
                            @lang('client-messages.variables'):
                            @foreach (\App\Enums\ClientMessageEnum::getMessageVariables($clientMessage->message_for) as $variable)
                                <p> {{ $variable }} </p>
                            @endforeach
                        </div>
                        @foreach (config("app.locales") as $locale)
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="page" class="form-label">@lang('client-messages.message') @lang("languages.$locale")</label>
                                    <textarea rows="5" name="message[{{ $locale }}]" class="form-control">{{ $clientMessage->getTranslation("message", $locale) }}</textarea>
                                    @error("message.$locale")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex align-items-start gap-3 mt-4">
                            <button type="submit"
                                class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                @lang('client-messages.edit')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
