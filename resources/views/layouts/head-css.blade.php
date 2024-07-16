@yield('css')
<!-- Layout config Js -->
<script src="{{ URL::asset('assets/js/layout.js') }}"></script>
<!-- Bootstrap Css -->
<!-- Icons Css -->
@if(app()->getLocale() == 'en')
<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}"  rel="stylesheet" type="text/css" />
@endif
@if(app()->getLocale() == 'ar')
<link href="{{ URL::asset('assets/css/bootstrap.rtl.css') }}"  rel="stylesheet" type="text/css" />
@endif
<link href="{{ URL::asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
@if(app()->getLocale() == 'en')
<link href="{{ URL::asset('assets/css/app.min.css') }}"  rel="stylesheet" type="text/css" />
@endif
@if(app()->getLocale() == 'ar')
<link href="{{ URL::asset('assets/css/app.rtl.css') }}"  rel="stylesheet" type="text/css" />
@endif
<!-- custom Css-->
<link href="{{ URL::asset('assets/css/custom.min.css') }}"  rel="stylesheet" type="text/css" />
{{-- @yield('css') --}}
