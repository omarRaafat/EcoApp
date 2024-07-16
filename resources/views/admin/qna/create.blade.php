@extends('admin.layouts.master')
@section('title')
    @lang('qnas.admin.create')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
@include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            @lang('admin.qnas.create')
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.qna.store') }}" method="post" class="form-steps"
                            autocomplete="on" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                                <div class="text-center pt-3 pb-4 mb-1">
                                    <img src="assets/images/logo-dark.png" alt="" height="17">
                                </div>
                                <div class="tab-content">
                                    <!-- Start Of Arabic Info tab pane -->
                                    <div class="tab-pane fade active show" id="areas-arabic-info" role="tabpanel" aria-labelledby="areas-arabic-info-tab">
                                        <div>

                                            <div class="row">
                                                @foreach(config('app.locales') AS $locale)
                                                <div class="col-md-6 mb-3">
                                                    <label for="title" class="form-label">@lang('admin.qnas.question') -@lang('language.'.$locale)
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control @error('question.'.$locale) is-invalid @enderror" name="question[{{ $locale }}]"
                                                    value="{{ old('question.'.$locale)}}"
                                                    placeholder="@lang('admin.qnas.question') -@lang('language.'.$locale)"
                                                    id="question">
                                                    @error('question.'.$locale)
                                                    <span class="error text-danger" role="alert"> {{ $message }} </span>
                                                     @enderror

                                                </div>


                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="answer[{{ $locale }}]">@lang('admin.qnas.answer')-@lang('language.'.$locale)</label>
                                                        <textarea type="text" name="answer[{{ $locale }}]" class="ckeditor form-control
                                                            id="answer_{{$locale}}" rows="5"
                                                            placeholder="@lang('qnas.admin.question_ar')">{{ old('answer.'.$locale) }}</textarea>
                                                            @error('answer.'.$locale)
                                                            <span class="error text-danger" role="alert"> {{ $message }} </span>
                                                             @enderror
                                                    </div>
                                                </div>
                                                @endforeach

                                            </div>


                                        </div>
                                    </div>
                                    <!-- End Of Arabic Info tab pane -->
                                </div>
                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <button type="submit"
                                        class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                        <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                        @lang('admin.create')
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2_parent_id').select2({
                placeholder: "Select",
                allowClear: true
            });
            $('.ckeditor').ckeditor();
        });
    </script>
@endsection
