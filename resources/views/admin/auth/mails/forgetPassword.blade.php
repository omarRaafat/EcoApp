<h1>@lang('admin.forgot_password_email')</h1>
@lang('admin.forgot_password_email_notes')
<a href="{{ route('admin.password_reset_get', $token) }}">@lang('admin.password_reset')</a>