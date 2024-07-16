
<div class="row">
    <div class="col-lg-6 offset-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('translation.role_data')</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="choices-publish-status-input" class="form-label">@lang('translation.role_name')<span class="required" >*</span></label>
                    {{ Form::text('name[ar]',(isset($row))?$row->name:null,['class'=>'form-control','id'=>'name-input','placeholder'=> __('translation.name_placeholder'),'required']) }}
                    @error('name[ar]')
                        <span class="invalid-feedback" style="display:inline;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="invalid-feedback">
                        @lang('translation.please_enter_name')
                    </div>
                </div>
                <div class="mb-3">
                    <label for="choices-publish-status-input" class="form-label">@lang('translation.permissions')<span class="required" >*</span></label>
                    {{ Form::select('permissions[]',$permissions,null,['class'=>'form-select','required','dir'=>'rtl','data-choices', 'data-choices-removeItem','multiple']) }}
                    @error('permissions')
                        <span class="invalid-feedback" style="display:inline;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="invalid-feedback">
                        @lang('translation.please_enter_permissions')
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
