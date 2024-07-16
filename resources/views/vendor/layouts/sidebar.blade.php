<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('vendor.index') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('images/logo.png') }}" alt="" height="80">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('images/logo.png') }}" alt="" height="80">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('vendor.index') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ url('images/logo.png') }}" alt="" height="80">
            </span>
            <span class="logo-lg">
                <img src="{{ url('images/logo.png') }}" alt="" height="80">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('vendor.index') }}">
                        <i data-feather="home" class="icon-dual"></i> <span>@lang('translation.dashboard')</span>
                    </a>
                </li> <!-- end Dashboard Menu -->

                @if (auth()->user()->type === 'vendor')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('vendor.agreements.index') }}">
                            <i class="ri-file-paper-2-fill"></i> <span>@lang('vendors.my-agreements')</span>
                        </a>
                    </li>
                @endif
                @if (auth()->user()?->isVendorPermittedTo('order'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarOrders" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarOrders">
                            <i class="ri-shopping-cart-fill"></i> <span>@lang('translation.product_orders')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarOrders">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('vendor.orders.index') }}" class="nav-link">@lang('translation.all_orders_list')</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
                @if (auth()->user()?->isVendorPermittedTo('order_services'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarServiceOrders" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarServiceOrders">
                            <i class="ri-shopping-cart-fill"></i> <span>@lang('translation.service_orders')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarServiceOrders">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('vendor.service-orders.index') }}" class="nav-link">@lang('translation.all_orders_list')</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
                @if (auth()->user()?->isVendorPermittedTo('product'))
                    {{--  @if (in_array('selling_products', auth()->user()?->vendor?->services))  --}}
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarApps">
                            <i data-feather="grid" class="icon-dual"></i> <span>@lang('translation.products')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarApps">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('vendor.products.index') }}"
                                        class="nav-link">@lang('translation.products_list')</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('vendor.products.create') }}"
                                        class="nav-link">@lang('translation.create_product')</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    {{--  @endif  --}}
                @endif

                @if (auth()->user()?->isVendorPermittedTo('services'))
                    {{--  @if (in_array('agricultural_services', auth()->user()?->vendor?->services))  --}}
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarServices" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarServices">
                            <i data-feather="grid" class="icon-dual"></i> <span>@lang('translation.services')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarServices">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('vendor.services.index') }}"
                                        class="nav-link">@lang('translation.services_list')</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('vendor.services.create') }}"
                                        class="nav-link">@lang('translation.create_service')</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    {{--  @endif  --}}
                @endif

                @if (auth()->user()?->isVendorPermittedTo('warehouse'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarWarehouse" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarWarehouse">
                            <i data-feather="grid" class="icon-dual"></i> <span>@lang('translation.warehouses')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarWarehouse">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('vendor.warehouses.index') }}"
                                        class="nav-link">@lang('translation.warehouses_list')</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('vendor.warehouses.create') }}"
                                        class="nav-link">@lang('translation.create_warehouse')</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if (auth()->user()?->isVendorPermittedTo('reports'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarReports" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarReports">
                            <i data-feather="pie-chart" class="icon-dual"></i> <span>@lang('reports.title')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarReports">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('vendor.reports.orders-report.index') }}"
                                        class="nav-link">@lang('reports.orders-report')</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif


                @if (auth()->user()->type === 'vendor')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('vendor.wallet') }}">
                            <i class="  ri-wallet-fill"></i> <span>@lang('translation.wallet')</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()?->isVendorPermittedTo('review'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('vendor.product-reviews') }}">
                            <i class=" ri-star-half-line"></i> <span>@lang('translation.product_reviews')</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('vendor.service-reviews') }}">
                            <i class=" ri-star-half-line"></i> <span>@lang('translation.service_reviews')</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()?->isVendorPermittedTo('user'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('vendor.users.index') }}">
                            <i class="ri-group-fill"></i> <span>@lang('translation.users')</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()?->isVendorPermittedTo('role'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('vendor.roles.index') }}">
                            <i class="ri-admin-fill"></i> <span>@lang('translation.roles')</span>
                        </a>
                    </li>
                @endif
                @if (auth()->user()?->isVendorPermittedTo('type_of_employees'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('vendor.type-of-employees.index') }}">
                            <i class="ri-admin-fill"></i> <span>@lang('translation.type_of_employees')</span>
                        </a>
                    </li>
                @endif
                @if (auth()->user()?->isVendorPermittedTo('certificate'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('vendor.certificates.index') }}">
                            <i class=" ri-file-paper-2-fill"></i> <span>@lang('translation.certificates')</span>
                        </a>
                    </li>
                @endif
                {{--
                @if (auth()->user()?->isVendorPermittedTo('warehouse'))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('vendor.warhouse_request.index')}}">
                        <i class="bx bx-git-pull-request"></i> <span>@lang('translation.warehouse-requests')</span>
                    </a>
                </li>
                @endif
                --}}

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
