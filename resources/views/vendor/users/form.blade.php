<div class="row">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body p-4">
                <div class="text-center">
                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                        <img src="@if (isset($row) && $row->image != '') {{ URL::asset($row->image) }}@else{{ URL::asset('images/avatar.jpg') }} @endif"
                            class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image"
                            id="profile-image">
                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                            <input id="profile-img-file-input" type="file" name="image"
                                class="profile-img-file-input">
                            <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                <span class="avatar-title rounded-circle bg-light text-body">
                                    <i class="ri-camera-fill"></i>
                                </span>
                            </label>
                        </div>
                    </div>
                    @if (isset($row))
                        <h5 class="fs-16 mb-1">{{ $row->name }}</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('translation.user_data')</h5>
            </div>
            <div class="card-body">
                <div class="form-check form-switch form-switch-lg form-switch-danger mb-3" dir="rtl">
                    <!-- <input type="checkbox" name="is_banned" class="form-check-input" id="customSwitchsizelg" > -->
                    {{ Form::checkbox('is_banned', 1, null, ['class' => ' form-check-input', 'id' => 'customSwitchsizelg']) }}
                    <label class="form-check-label" for="customSwitchsizelg">@lang('translation.is_banned')</label>
                </div>
                <div class="mb-3">
                    <label for="choices-publish-status-input" class="form-label">@lang('translation.user_name')<span
                            class="required">*</span></label>
                    {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name-input', 'placeholder' => __('translation.name_placeholder'), 'required','minlength' => 3]) }}
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
                    <label for="choices-publish-status-input" class="form-label">@lang('translation.email')<span
                            class="required">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">@</span>
                        {{ Form::email('email', null, ['class' => 'form-control', 'id' => 'email-input', 'placeholder' => __('translation.email_placeholder'), 'required', 'dir' => 'rtl']) }}
                    </div>
                    @error('email')
                        <span class="invalid-feedback" style="display:inline;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="invalid-feedback">
                        @lang('translation.please_enter_email')
                    </div>

                </div>
                <div class="mb-3">
                    <label for="choices-publish-status-input" class="form-label">@lang('translation.phone')<span
                            class="required">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class=" ri-phone-fill"></i></span>
                        {{ Form::number('phone', isset($row) ? Illuminate\Support\Str::replace('+966', '', $row->phone) : null, ['class' => 'form-control', 'id' => 'phone-input', 'placeholder' => __('translation.phone_placeholder'), 'required']) }}
                    </div>
                    @error('phone')
                        <span class="invalid-feedback" style="display:inline;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="invalid-feedback">
                        @lang('translation.please_enter_email')
                    </div>
                </div>

                <div class="mb-3">
                    <label for="choices-publish-status-input" class="form-label">@lang('translation.roles')<span
                            class="required">*</span></label>
                    {{ Form::select('role_id', $roles, null, ['class' => 'form-select', 'required', 'dir' => 'rtl', 'data-choices', 'data-choices-removeItem']) }}
                    @error('roles')
                        <span class="invalid-feedback" style="display:inline;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="invalid-feedback">
                        @lang('translation.please_enter_permissions')
                    </div>
                </div>
                <div class="mb-3">
                    <label for="choices-publish-status-input-type-employee-id"
                        class="form-label">@lang('translation.type_of_employees')<span class="required">*</span></label>
                    <select id="choices-publish-status-input-type-employee-id" class="form-control"name="type_of_employee_id">
                        @foreach ($typeOfEmployees as $data)
                            <option value="{{ $data->id }}" {{ isset($row) ? $data->id == $row->type_of_employee_id ? 'selected' : ''  : ''}}>{{ isset($data ) ? $data->name . ' مستوى ' . $data->level : '' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <div class="card">
            <div class="card-body row">
                <div class="col-md-6 mb-3">
                    <label for="choices-publish-status-input" class="form-label">@lang('translation.password')<span
                            class="required">
                            @if (!isset($row))
                                *
                            @endif
                        </span></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class=" ri-lock-fill"></i></span>
                        {{ Form::input('password', 'password', null, ['class' => 'form-control', 'id' => 'password-input', 'placeholder' => __('translation.password_placeholder'), 'required' => !isset($row) ? 'required' : false, 'dir' => 'rtl']) }}
                        @error('password')
                            <span class="invalid-feedback" style="display:inline;" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="invalid-feedback">
                            @lang('translation.please_enter_password')
                        </div>
                    </div>

                </div>
                <div class="col-md-6 mb-3">
                    <label for="choices-publish-status-input" class="form-label">@lang('translation.confirm_password')<span
                            class="required">
                            @if (!isset($row))
                                *
                            @endif
                        </span></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class=" ri-lock-fill"></i></span>
                        {{ Form::input('password', 'password_confirmation', null, ['class' => 'form-control', 'id' => 'password_confirmation-input', 'placeholder' => __('translation.confirm_password_placeholder'), 'required' => !isset($row) ? 'required' : false, 'dir' => 'rtl']) }}
                        @error('password_confirmation')
                            <span class="invalid-feedback" style="display:inline;" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="invalid-feedback">
                            @lang('translation.please_enter_password')
                        </div>
                    </div>

                </div>
                {{-- <div class="col-md-12 mb-3">
                    <div class="mb-3">
                        <label class="form-label" for="user-name-input">@lang('translation.user_name')<span class="required" >*</span></label>
                        <input type="hidden" class="form-control" id="formAction" name="formAction" value="add">
                        <input type="text" class="form-control d-none" id="user-id-input">
                        {{ Form::text('name',null,['class'=>'form-control','id'=>'user-name-input','placeholder'=> __('translation.user_name_placeholder'),'required']) }}
                        <div class="invalid-feedback">@lang('translation.user_name_placeholder')</div>
                    </div>
                </div> --}}
            </div>
        </div>
        <!-- end card -->
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
    <script>
        function getSubCategories(ele, level) {
            $.get('/vendor/get-category-by-parent-id?parent_id=' + ele.val() + '&level=' + level, (response) => {
                data = Object.entries(response)
                options = '';
                select_optins = '';
                data.forEach((value, index) => {
                    select_optins += `<option value="${value[0]}"> ${value[1]} </option>`
                })
                if (level === 2) {
                    $('#sub-choices-publish-status-input').html(select_optins)
                    $('#sub-choices-publish-status-input').select2();
                }
                if (level === 3) {

                    $('#final-choices-publish-status-input').html(select_optins)
                    $('#final-choices-publish-status-input').select2();
                }
            })
        }
    </script>
@endsection
