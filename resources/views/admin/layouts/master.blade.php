<!doctype html >
<html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico')}}">
    @include('admin.layouts.head-css')
</head>

@section('body')
    @include('admin.layouts.body')
@show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('admin.layouts.topbar')
        @include('admin.layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @if(Route::currentRouteName() != 'admin.home')
                        @component('components.breadcrumb')
                            @if(isset($breadcrumbParent))
                                @slot('breadcrumbParent')
                                    {{ $breadcrumbParent }}
                                @endslot
                                @if(isset($breadcrumbParentUrl))
                                    @slot('breadcrumbParentUrl')
                                        {{ $breadcrumbParentUrl }}
                                    @endslot
                                @endif
                            @endif
                            @slot('li_1')
                                @slot('link')
                                    {{ route('admin.home') }}
                                @endslot
                                @slot('link_name')
                                    @lang('translation.dashboard')
                                @endslot
                            @endslot
                            @slot('title')
                                @yield('title')
                            @endslot
                        @endcomponent
                    @endif
                    @include('components.session-alert')
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('admin.layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    @include('admin.layouts.vendor-scripts')
</body>

</html>
