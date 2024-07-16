<form action="{{route('vendor.change-password')}}" method="POST">
    @csrf
    <div class="row g-2">
        <div class="col-lg-4">
            <div>
                <label for="old_password" class="form-label">@lang('translation.old_password')*</label>
                <input type="password" class="form-control" name="old_password" id="oldpasswordInput"
                    placeholder="@lang('translation.old_password_placeholder')" required>
                @error('old_password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror  
            </div>
        </div>
        <!--end col-->
        <div class="col-lg-4">
            <div>
                <label for="password" class="form-label">@lang('translation.new_password')*</label>
                <input type="password" class="form-control" name="password" id="newpasswordInput"
                    placeholder="@lang('translation.new_password_placeholder')" required>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror  
            </div>
        </div>
        <!--end col-->
        <div class="col-lg-4">
            <div>
                <label for="password_confirmation" class="form-label">@lang('translation.confirm_password')*</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                    placeholder="@lang('translation.confirm_password_placeholder')" required>
                @error('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                @enderror 
            </div>
        </div>
        <!--end col-->
        <div class="col-lg-12">
            <div class="mb-3">
                <a href="{{route('vendor.password.request')}}"
                    class="link-primary text-decoration-underline">@lang('translation.forgot_password')</a>
            </div>
        </div>
        <!--end col-->
        <div class="col-lg-12">
            <div class="text-end">
                <button type="submit" class="btn btn-primary">@lang('translation.change_password')</button>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
</form>