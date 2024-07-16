
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('translation.certificate_data')</h5>
            </div>
            <div class="card-body row">
                <div class="col-lg-6 col-sm-6">
                    <div class="mb-3" >
                        <label for="choices-publish-status-input" class="form-label">@lang('translation.certificate')<span class="required" >*</span></label>
                        {{ Form::select('certificate_id',$certificates,null,['class'=>'form-select','required','dir'=>'rtl','data-choices', 'data-choices-removeItem']) }}
                        @error('certificate_id')
                            <span class="invalid-feedback" style="display:inline;" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="invalid-feedback">
                            @lang('translation.please_enter_certificates')
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <div class="mb-3" >
                        <label for="choices-publish-status-input" class="form-label">@lang('translation.expire_date')<span class="required" >*</span></label>

                        <!-- <input type="date" class="form-control flatpickr-input active" name="expire_date" data-provider="flatpickr" data-date-format="Y-m-d"> -->
                        {{ Form::date('expire_date',null,['class'=>'form-control flatpickr-input active','required','dir'=>'rtl','data-provider'=>'flatpickr','data-date-format'=>'Y-m-d']) }}
                        @error('expire_date')
                            <span class="invalid-feedback" style="display:inline;" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="invalid-feedback">
                            @lang('translation.please_enter_certificates')
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <div class="mb-3" >
                        <label for="username" class="form-label">@lang('translation.certificate_file') @lang('translation.certificate_types') @if(!isset($row))<span class="text-danger">*</span>@endif</label>
                        <input type="file" class="form-control @error('certificate_file') is-invalid @enderror"
                            name="certificate_file" value="{{ old('certificate_file') }}" id="certificate_file"
                            placeholder="@lang('translation.certificate_file_placeholder')" @if(!isset($row)) required @endif>
                        @error('certificate_file')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

            </div>
            <!-- end card body -->
        </div>
        <div class="text-end mb-3">
            <button type="submit" class="btn btn-success w-sm">@lang('translation.submit')</button>
        </div>
    </div>
</div>
<!-- end row -->

@section('script-bottom')
<!--select2 cdn-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

<script src="{{ URL::asset('assets/js/pages/select2.init.js') }}"></script>
@endsection
