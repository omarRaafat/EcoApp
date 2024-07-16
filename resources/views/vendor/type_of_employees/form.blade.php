<div class="row">
    <div class="col-lg-6 offset-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('translation.type_of_employee.type_of_employees')</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="choices-publish-status-input" class="form-label">@lang('translation.role_name')<span
                            class="required">*</span></label>
                    <input type="text" name="name" class="form-control" id="choices-publish-status-input"
                        value="{{ old('name', isset($data) ? $data->name : '') }}"
                        placeholder ="{{ __('translation.type_of_employee.name_placeholder') }}" required>
                    @error('name')
                        <span class="invalid-feedback" style="display:inline;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="invalid-feedback">
                        @lang('translation.please_enter_name')
                    </div>
                </div>
                <div class="mb-3">
                    <select class="form-control" name="level">
                        <option value="1" {{ isset($data) ? ($data->level == 1 ? 'selected' : '') : '' }}>
                            1 {{ trans('translation.type_of_employee.level_1_text') }}</option>
                        <option value="2" {{ isset($data) ? ($data->level == 2 ? 'selected' : '') : '' }}>2
                            {{ trans('translation.type_of_employee.level_2_text') }}
                        </option>
                        <option value="3" {{ isset($data) ? ($data->level == 3 ? 'selected' : '') : '' }}>3
                            {{ trans('translation.type_of_employee.level_3_text') }}
                        </option>
                        <option value="4" {{ isset($data) ? ($data->level == 4 ? 'selected' : '') : '' }}>4
                            {{ trans('translation.type_of_employee.level_4_text') }}
                        </option>
                    </select>
                    @error('level')
                        <span class="invalid-feedback" style="display:inline;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="invalid-feedback">
                        @lang('translation.please_enter_name')
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
