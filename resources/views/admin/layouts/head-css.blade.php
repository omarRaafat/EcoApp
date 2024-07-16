@yield('css')
<!-- Layout config Js -->
<script src="{{ URL::asset('assets/js/layout.js') }}"></script>
<!-- Bootstrap Css -->
<link href="{{ URL::asset('assets/css/bootstrap.rtl.css') }}"  rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ URL::asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ URL::asset('assets/css/app.rtl.css') }}"  rel="stylesheet" type="text/css" />
<!-- custom Css-->
<link href="{{ URL::asset('assets/css/custom.min.css') }}"  rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ URL::asset('assets/css/global-search.css') }}"  rel="stylesheet" type="text/css" />
{{-- @yield('css') --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
{{-- <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300&family=Tahoma:wght@200&display=swap" rel="stylesheet"> --}}
<style>
    @font-face {
        font-family: 'Dubai', sans-serif;
    }
    * {
        /* font-family: "Tahoma", sans-serif;
        font-weight: bolder; */
        font-family: 'Dubai', sans-serif !important;

    }
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Dubai', sans-serif;

    }
    .menu-link {
        font-weight: bolder!important;
    }
    .mb-4 {
        font-family: 'Dubai', sans-serif;
        font-weight: bold!important;
    }
    .nav-link{
        font-family: 'Dubai', sans-serif;
        font-weight: bolder!important;
    }
    #order-table_filter{
        display: none !important;
    }

</style>

