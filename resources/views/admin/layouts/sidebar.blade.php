<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('admin.home') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('images/logo.png') }}" alt="" height="80">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('images/logo.png') }}" alt="" height="80">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('admin.home') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('images/logo.png') }}" alt="" height="80">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('images/logo.png') }}" alt="" height="80">
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
                @if (auth()->user()?->isAdminPermittedTo('admin.customers.index'))
                    <li class="menu-title"><span>@lang('admin.menu')</span></li>
                    <li class="nav-item">
                        <a href="{{ route('admin.customers.index') }}" class="nav-link">
                            <i data-feather="home" class="icon-dual"></i>
                            <span>@lang('admin.customers_list')</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()?->isAdminPermittedToGroup('transactions'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#orders" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="orders">
                            <i data-feather="home" class="icon-dual"></i> <span>@lang('admin.product_transactions')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="orders">
                            <ul class="nav nav-sm flex-column">
                                @if (auth()->user()?->isAdminPermittedTo('admin.transactions.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.transactions.index') }}"
                                           class="nav-link">@lang('admin.transactions_list')</a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.transactions.sub_orders'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.transactions.sub_orders') }}"
                                           class="nav-link">@lang('admin.sub_orders')</a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.transactions.canceled_orders'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.transactions.canceled_orders') }}"
                                           class="nav-link">@lang('admin.canceled_orders')</a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.transactions.shipping_failed_orders'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.transactions.shipping_failed_orders') }}"
                                           class="nav-link">@lang('admin.shipping_failed')</a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.carts.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.carts.index') }}"
                                           class="nav-link">@lang('admin.carts_list')</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#service_orders" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="service_orders">
                            <i data-feather="home" class="icon-dual"></i> <span>@lang('admin.service_transactions')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="service_orders">
                            <ul class="nav nav-sm flex-column">
                                @if (auth()->user()?->isAdminPermittedTo('admin.service_transactions.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.service_transactions.index') }}"
                                           class="nav-link">@lang('admin.transactions_list')</a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.service_transactions.sub_orders'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.service_transactions.sub_orders') }}"
                                           class="nav-link">@lang('admin.sub_orders')</a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.service_transactions.canceled_orders'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.service_transactions.canceled_orders') }}"
                                           class="nav-link">@lang('admin.canceled_orders')</a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.service_carts.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.service_carts.index') }}"
                                           class="nav-link">@lang('admin.carts_list')</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif


                @if (auth()->user()?->isAdminPermittedTo('admin.products.index'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sideproducts" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="categories">
                            <i data-feather="home" class="icon-dual"></i> <span>@lang('admin.products.title')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sideproducts">
                            <ul class="nav nav-sm flex-column">
                                @if (auth()->user()?->isAdminPermittedTo('admin.products.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.products.index') }}"
                                           class="nav-link">@lang('admin.products.title')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.products.index',['temp'=>1]) }}"
                                           class="nav-link">@lang('admin.products.updated_products')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.products.index',['status'=>"pending"]) }}"
                                           class="nav-link">@lang('admin.products.pending_products')</a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.products.almostOutOfStock'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.products.almostOutOfStock') }}" class="nav-link"> شارفت
                                            على الإنتهاء </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.products.outOfStock'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.products.outOfStock') }}" class="nav-link"> نفذت من
                                            المخزون </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.products.deleted'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.products.deleted') }}" class="nav-link"> منتجات
                                            محذوفة </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if (auth()->user()?->isAdminPermittedTo('admin.services.index'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sideservices" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="categories">
                            <i data-feather="home" class="icon-dual"></i> <span>@lang('admin.services.title')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sideservices">
                            <ul class="nav nav-sm flex-column">
                                @if (auth()->user()?->isAdminPermittedTo('admin.services.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.services.index') }}"
                                           class="nav-link">@lang('admin.services.title')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.services.index',['temp'=>1]) }}"
                                           class="nav-link">@lang('admin.services.updated_services')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.services.index',['status'=>"pending"]) }}"
                                           class="nav-link">@lang('admin.services.pending_services')</a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.services.deleted'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.services.deleted') }}" class="nav-link"> خدمات
                                            محذوفة </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                {{-- @if (auth()->user()?->isAdminPermittedToGroup("Report"))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#reports" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="reports">
                        <i class="bx bx-doughnut-chart"></i> <span>@lang('reports.title')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="reports">
                        <ul class="nav nav-sm flex-column">
                            @if (auth()->user()?->isAdminPermittedTo('admin.reports.vendors-orders'))
                            <li class="nav-item">
                                <a href="{{ route('admin.reports.vendors-orders') }}" class="nav-link">@lang('reports.vendors-orders.title')</a>
                            </li>
                            @endif
                            @if (auth()->user()?->isAdminPermittedTo('admin.reports.total-vendors-orders'))
                            <li class="nav-item">
                                <a href="{{ route('admin.reports.total-vendors-orders') }}" class="nav-link">@lang('reports.total-vendors-orders.title')</a>
                            </li>
                            @endif


                            @if (auth()->user()?->isAdminPermittedTo('admin.reports.products_quantity'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.reports.products_quantity') }}">
                                    <i class="bx bxs-cog"></i> @lang('admin.reports.product_quantity')
                                </a>
                            </li>
                            @endif


                        </ul>
                    </div>
                </li>
                @endif --}}

                @if (auth()->user()?->isAdminPermittedToGroup("vendors"))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#vendors" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="vendors">
                            <i data-feather="home" class="icon-dual"></i> <span>@lang('admin.vendors')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="vendors">
                            <ul class="nav nav-sm flex-column">
                                @if (auth()->user()?->isAdminPermittedTo('admin.vendors.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.vendors.index') }}"
                                           class="nav-link">@lang('admin.vendors_list')</a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.roles.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.roles.index') }}"
                                           class="nav-link">@lang('admin.permission_vendor_roles')</a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.vendor-users.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.vendor-users.index') }}"
                                           class="nav-link">@lang('admin.permission_vendor_users')</a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.vendors-agreements.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.vendors-agreements.index') }}"
                                           class="nav-link">@lang('admin.vendors-agreements')</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if (auth()->user()?->isAdminPermittedToList(['admin.warehouses.index','admin.wareHouseRequests.index']))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#warehouses" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="warehouses">
                            <i class="bx bx-building-house"></i> <span>@lang('admin.warehouses.title')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="warehouses">
                            <ul class="nav nav-sm flex-column">
                                @if (auth()->user()?->isAdminPermittedTo('admin.warehouses.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.warehouses.index') }}">
                                            <i class="bx bx-building-house"></i> @lang('admin.warehouses.title')
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.warehouses.updated'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.warehouses.updated') }}">
                                            <i class="bx bx-building-house"></i> تم تحديثها
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.warehouses.pending'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.warehouses.pending') }}">
                                            <i class="bx bx-building-house"></i> في إنتظار الموافقة
                                        </a>
                                    </li>
                                @endif

                                {{--
                                @if (auth()->user()?->isAdminPermittedTo('admin.wareHouseRequests.index'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.wareHouseRequests.index') }}" >
                                        <i class="bx bx-git-pull-request"></i> @lang('admin.wareHouseRequests.title')
                                    </a>
                                </li>
                                @endif
                                --}}
                            </ul>
                        </div>
                    </li>
                @endif

                @if (auth()->user()?->isAdminPermittedTo('admin.certificates.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.certificates.index') }}" class="nav-link">
                            <i data-feather="home" class="icon-dual"></i>
                            <span>@lang('admin.certificates')</span>
                        </a>
                    </li>
                @endif
                {{-- @if (auth()->user()?->isAdminPermittedTo('admin.coupons.index'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.coupons.index') }}">
                        <i data-feather="home"></i>
                        <span>@lang('admin.coupons_title')</span>
                    </a>
                </li>
                @endif --}}

                @if (auth()->user()?->isAdminPermittedToGroup('client-messages'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#client-messages" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="orders">
                            <i class="bx bx-message"></i> <span>@lang('client-messages.messages')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="client-messages">
                            <ul class="nav nav-sm flex-column">
                                @if (auth()->user()?->isAdminPermittedTo('admin.client-messages.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.client-messages.index') }}"
                                           class="nav-link">@lang('client-messages.title')</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('admin.client-sms.index') }}"
                                           class="nav-link">@lang('client-messages.sms_title')</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                {{--  @if (auth()->user()?->isAdminPermittedToGroup('client-messages'))  --}}
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#post-harvest-services" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="orders">
                            <i class="bx bx-message"></i> <span>@lang('postHarvestServices.post-harvest-services')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="post-harvest-services">
                            <ul class="nav nav-sm flex-column">
                                {{--  @if (auth()->user()?->isAdminPermittedTo('admin.post-harvest-services.index'))  --}}
                                    <li class="nav-item">
                                        <a href="{{ route('admin.post-harvest-services-departments.index') }}"
                                        class="nav-link">@lang('postHarvestServices.post-harvest-services')</a>
                                    </li>

                                    {{--  <li class="nav-item">
                                        <a href="{{ route('admin.client-sms.index') }}"
                                           class="nav-link">@lang('client-messages.sms_title')</a>
                                    </li>  --}}
                                {{--  @endif  --}}
                            </ul>
                        </div>
                    </li>
                {{--  @endif  --}}

                {{--                @if (auth()->user()?->isAdminPermittedToList(['admin.wallets.index','admin.customer-cash-withdraw.index']))--}}
                {{--                <li class="nav-item">--}}
                {{--                    <a class="nav-link menu-link" href="#customer_finances" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="customer_finances">--}}
                {{--                        <i class="bx bx-dollar-circle"></i> <span>@lang('admin.customer_finances.title')</span>--}}
                {{--                    </a>--}}
                {{--                    <div class="collapse menu-dropdown" id="customer_finances">--}}
                {{--                        <ul class="nav nav-sm flex-column">--}}
                {{--                            @if (auth()->user()?->isAdminPermittedTo('admin.wallets.index'))--}}
                {{--                            <li class="nav-item">--}}
                {{--                                <a class="nav-link" href="{{ route('admin.wallets.index') }}">--}}
                {{--                                    <i class="bx bx-wallet"></i> @lang('admin.customer_finances.wallets.title')--}}
                {{--                                </a>--}}
                {{--                            </li>--}}
                {{--                            @endif--}}
                {{--                            @if (auth()->user()?->isAdminPermittedTo('admin.customer-cash-withdraw.index'))--}}
                {{--                            <li class="nav-item">--}}
                {{--                                <a class="nav-link" href="{{ route('admin.customer-cash-withdraw.index') }}">--}}
                {{--                                    <i class="bx bx-wallet"></i> @lang('admin.customer_finances.customer-cash-withdraw.page-title')--}}
                {{--                                </a>--}}
                {{--                            </li>--}}
                {{--                            @endif--}}
                {{--                        </ul>--}}
                {{--                    </div>--}}
                {{--                </li>--}}
                {{--                @endif--}}

                @if (auth()->user()?->isAdminPermittedToList(['admin.categories.index','admin.productClasses.index','admin.product-quantities.index']))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#categories" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="categories">
                            <i class="bx bx-purchase-tag-alt"></i> <span>@lang('admin.categories.product_title_main')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="categories">
                            <ul class="nav nav-sm flex-column">
                                @if (auth()->user()?->isAdminPermittedTo('admin.categories.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.categories.index') }}">
                                            <i class="bx bx-category-alt"></i> @lang('admin.categories.title')
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.productClasses.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.productClasses.index') }}">
                                            <i class="bx bx-shape-triangle"></i> @lang('admin.productClasses.title')
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.product-quantities.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.product-quantities.index') }}">
                                            <i class="bx bx-shape-circle"></i> @lang('admin.productQuantities.title')
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                {{-- @if (auth()->user()?->isAdminPermittedToList(['admin.preharvest-categories.index']))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#preharvest-categories" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="preharvest-categories">
                            <i class="bx bx-purchase-tag-alt"></i> <span>@lang('admin.preharvest-categories.title_main')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="preharvest-categories">
                            <ul class="nav nav-sm flex-column">
                                @if (auth()->user()?->isAdminPermittedTo('admin.preharvest-categories.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.preharvest-categories.index') }}">
                                            <i class="bx bx-category-alt"></i> @lang('admin.preharvest-categories.title')
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.palm-lengths.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.palm-lengths.index') }}">
                                            <i class="bx bx-category-alt"></i> @lang('admin.preharvest.palm-lengths')
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.stages.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.stages.index') }}">
                                            <i class="bx bx-category-alt"></i> @lang('admin.preharvest.stage')
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif --}}

                @if (auth()->user()?->isAdminPermittedToList(['admin.areas.index','admin.cities.index']))
                    {{-- {{dd('qq')}} --}}
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#countries" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="countries">
                            <i class="bx bx-target-lock"></i> <span>@lang('admin.countries_and_cities_title')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="countries">
                            <ul class="nav nav-sm flex-column">
                                {{--                            @if (auth()->user()?->isAdminPermittedTo('admin.countries.index'))--}}
                                {{--                            <li class="nav-item">--}}
                                {{--                                <a class="nav-link" href="{{ route('admin.countries.index') }}">--}}
                                {{--                                    <i class="ri-flight-takeoff-line"></i> @lang('admin.countries.title')--}}
                                {{--                                </a>--}}
                                {{--                            </li>--}}
                                {{--                            @endif--}}
                                @if (auth()->user()?->isAdminPermittedTo('admin.areas.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.areas.index') }}">
                                            <i class="bx bx-map-alt"></i> @lang('admin.areas.title')
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.cities.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.cities.index') }}">
                                            <i class="bx bx-directions"></i> @lang('admin.cities.title')
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if (auth()->user()?->isAdminPermittedToGroup("static-content"))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#static-content" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="categories">
                            <i data-feather="home" class="icon-dual"></i>
                            <span>@lang('admin.static-content.title')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="static-content">
                            <ul class="nav nav-sm flex-column">
                                @if (auth()->user()?->isAdminPermittedTo('admin.about-us.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.about-us.index') }}"
                                           class="nav-link">@lang('admin.static-content.about-us.page-title')</a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.privacy-policy.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.privacy-policy.index') }}" class="nav-link">
                                            @lang('admin.static-content.privacy-policy.page-title')
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.usage-agreement.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.usage-agreement.index') }}" class="nav-link">
                                            @lang('admin.static-content.usage-agreement.page-title')
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.qna.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.qna.index') }}" class="nav-link">
                                            @lang('admin.qnas.manage_qnas')
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.recipe.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.recipe.index') }}" class="nav-link">
                                            @lang('admin.recipes.manage_recipes')
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.blog.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.blog.index') }}" class="nav-link">
                                            @lang('admin.blogPosts.manage_blogPosts')
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.slider.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.slider.index') }}" class="nav-link">
                                            @lang('admin.sliders.manage_sliders')
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.page-seo.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.page-seo.index') }}" class="nav-link">
                                            @lang('page-seo.title')
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                @if (auth()->user()?->isAdminPermittedToList(['admin.productRates.index','admin.vendorRates.index','admin.transactionProcessRate.index','admin.orderProcessRate.index']))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#productRates" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="productRates">
                            <i class="bx bx-line-chart"></i> <span>@lang('admin.rates_title')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="productRates">
                            <ul class="nav nav-sm flex-column">
                                @if (auth()->user()?->isAdminPermittedTo('admin.productRates.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.productRates.index') }}">
                                            <i class="bx bx-chart"></i> @lang('admin.productRates.title')
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.productRates.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.serviceRates.index') }}">
                                            <i class="bx bx-chart"></i> @lang('admin.serviceRates.title')
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.vendorRates.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.vendorRates.index') }}">
                                            <i class="bx bx-chart"></i> @lang('admin.vendorRates.title')
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.transactionProcessRate.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.transactionProcessRate.index') }}">
                                            <i class="bx bx-chart"></i> @lang('admin.transactionProcessRate.title')
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.orderProcessRate.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.orderProcessRate.index') }}">
                                            <i class="bx bx-chart"></i> @lang('admin.orderProcessRate.title')
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </li>
                @endif



                @if (auth()->user()?->isAdminPermittedToList([
                    'admin.settings.aramex.index' ,
                    'admin.line_shipping_price.index' ,
                    'admin.domestic-zones.index' ,
                    // 'admin.torodCompanies.index' ,
                    'admin.shipping-methods.index' ,
                    'admin.line_shipping_price.index'
                    ]))

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#delivery" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="delivery">
                            <i data-feather="truck" class="icon-dual"></i> <span>@lang('admin.delivery.title')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="delivery">
                            <ul class="nav nav-sm flex-column">

                                {{-- @if (auth()->user()?->isAdminPermittedTo('admin.settings.aramex.index'))--}}
                                {{--     <li class="nav-item">--}}
                                {{--         <a href="{{ route('admin.settings.aramex.index') }}" class="nav-link">--}}
                                {{--             <i class="bx bxs-cog"></i>--}}
                                {{--             <span>@lang('admin.shippingMethods.aramex_setting')</span>--}}
                                {{--         </a>--}}
                                {{--     </li>--}}
                                {{-- @endif--}}

                                @if (auth()->user()?->isAdminPermittedTo('admin.line_shipping_price.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.line_shipping_price.index') }}">
                                            <i class="bx bxs-cog"></i> @lang('admin.line_shipping_price')
                                        </a>
                                    </li>
                                @endif

                                @if (auth()->user()?->isAdminPermittedTo('admin.domestic-zones.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.domestic-zones.index') }}" class="nav-link">
                                            <i class="bx bx-map"></i> @lang('admin.delivery.domestic-zones.title')
                                        </a>
                                    </li>
                                @endif
                                {{-- @if (auth()->user()?->isAdminPermittedTo('admin.torodCompanies.index'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.torodCompanies.index') }}" >
                                        <i class="bx bx-git-pull-request"></i> @lang('admin.torodCompanies.title')
                                    </a>
                                </li>
                                @endif --}}
                                @if (auth()->user()?->isAdminPermittedTo('admin.shipping-methods.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('admin.shipping-methods.index') }}" class="nav-link">
                                            <i class="bx bxs-cog"></i>
                                            <span>@lang('admin.shippingMethods.manage_shippingMethods')</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </li>
                @endif

                @if (auth()->user()?->isAdminPermittedToList(['admin.subAdmins.index','admin.rules.index']))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#subAdmins" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="subAdmins">
                            <i class="bx bx-user-check"></i> <span>@lang('admin.team_title')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="subAdmins">
                            <ul class="nav nav-sm flex-column">
                                @if (auth()->user()?->isAdminPermittedTo('admin.subAdmins.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.subAdmins.index') }}">
                                            <i class="bx bx-user-pin"></i> @lang('admin.subAdmins.title')
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.rules.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.rules.index') }}">
                                            <i class="bx bx-user-x"></i> @lang('admin.rules.title')
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                @if (auth()->user()?->isAdminPermittedToList(['admin.vendorWallets.index' , 'admin.dispensingOrder.index' , 'admin.initialDispensingOrder.index' , 'admin.finalDispensingOrder.index']))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#vendors_finances" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="vendors_finances">
                            <i class="bx bx-user-check"></i> <span>@lang('admin.vendorWallets.vendors_finances')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="vendors_finances">
                            <ul class="nav nav-sm flex-column">
                                @if (auth()->user()?->isAdminPermittedTo('admin.vendorWallets.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.vendorWallets.index') }}">
                                            <i class="bx bx-user-x"></i> @lang('admin.vendorWallets.manage')
                                        </a>
                                    </li>
                                @endif

                                @if (auth()->user()?->isAdminPermittedTo('admin.dispensingOrder.index'))

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.dispensingOrder.index') }}">
                                            <i class="bx bx-user-x"></i> @lang('admin.dispensingOrder.manage')
                                        </a>
                                    </li>
                                @endif


                                @if (auth()->user()?->isAdminPermittedTo('admin.initialDispensingOrder.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.initialDispensingOrder.index') }}">
                                            <i class="bx bx-user-x"></i> @lang('admin.dispensingOrder.initialDispensingOrder')
                                        </a>
                                    </li>
                                @endif
                                {{-- {{dd(auth()->user()?->isAdminPermittedTo('admin.finalDispensingOrder.index'))}} --}}
                                @if (auth()->user()?->isAdminPermittedTo('admin.finalDispensingOrder.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.finalDispensingOrder.index') }}">
                                            <i class="bx bx-user-x"></i> @lang('admin.dispensingOrder.finalDispensingOrder')
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </li>
                @endif

                @if (auth()->user()?->isAdminPermittedToList(["admin.reports.products_quantity", "admin.reports.mostSellingProducts", "admin.reports.PaymentMethods", "admin.reports.SatisfactionClientsWallet","admin.reports.OrdersShipping","admin.reports.ShippingCharges","admin.reports.ShippingChargesCompleted", "admin.reports.ShippingChargesWait"]))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#reports" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="reports">
                            <i class="bx bx-cog"></i> <span>@lang('admin.reports.reports')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="reports">
                            <ul class="nav nav-sm flex-column">

                                @if (auth()->user()?->isAdminPermittedTo('admin.reports.products_quantity'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.reports.products_quantity') }}">
                                            <i class="bx bxs-cog"></i> @lang('admin.reports.product_quantity')
                                        </a>
                                    </li>
                                @endif

                                @if (auth()->user()?->isAdminPermittedTo('admin.reports.mostSellingProducts'))

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.reports.mostSellingProducts') }}">
                                            <i class="bx bxs-cog"></i> @lang('admin.reports.mostSellingProducts')
                                        </a>
                                    </li>
                                @endif

                                @if (auth()->user()?->isAdminPermittedTo('admin.reports.PaymentMethods'))

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.reports.PaymentMethods') }}">
                                            <i class="bx bxs-cog"></i> @lang('admin.reports.PaymentMethods')
                                        </a>
                                    </li>
                                @endif

                                {{-- @if (auth()->user()?->isAdminPermittedTo('admin.reports.SatisfactionClientsWallet'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.reports.SatisfactionClientsWallet') }}">
                                        <i class="bx bxs-cog"></i> @lang('admin.reports.SatisfactionClientsWallet')
                                    </a>
                                </li>
                                @endif --}}

                                @if (auth()->user()?->isAdminPermittedTo('admin.reports.OrdersShipping'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.reports.OrdersShipping') }}">
                                            <i class="bx bxs-cog"></i> @lang('admin.reports.OrdersShipping')
                                        </a>
                                    </li>
                                @endif


                                {{-- @if (auth()->user()?->isAdminPermittedTo('admin.reports.ShippingCharges'))
                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('admin.reports.ShippingCharges') }}">
                                         <i class="bx bxs-cog"></i> @lang('admin.reports.ShippingCharges')
                                     </a>
                                 </li>
                                 @endif--}}

                                @if (auth()->user()?->isAdminPermittedTo('admin.reports.ShippingChargesCompleted'))

                                    <li class="nav-item">
                                        <a class="nav-link"
                                           href="{{ route('admin.reports.ShippingChargesCompleted') }}">
                                            <i class="bx bxs-cog"></i> @lang('admin.reports.ShippingChargesCompleted')
                                        </a>
                                    </li>
                                @endif

                                @if (auth()->user()?->isAdminPermittedTo('admin.reports.ShippingChargesWait'))

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.reports.ShippingChargesWait') }}">
                                            <i class="bx bxs-cog"></i> @lang('admin.reports.ShippingChargesWait')
                                        </a>
                                    </li>
                                @endif


                                @if (auth()->user()?->isAdminPermittedTo('admin.reports.SalesAllVendors'))

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.reports.SalesAllVendors') }}">
                                            <i class="bx bxs-cog"></i> @lang('admin.reports.SalesAllVendors')
                                        </a>
                                    </li>
                                @endif


                                @if (auth()->user()?->isAdminPermittedTo('admin.reports.vendors_sales'))

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.reports.vendors_sales') }}">
                                            <i class="bx bxs-cog"></i> @lang('admin.reports.vendors_sales')
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.reports.vendors_earnings'))

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.reports.vendors_earnings') }}">
                                            <i class="bx bxs-cog"></i> @lang('admin.reports.vendors_earnings')
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()?->isAdminPermittedTo('admin.reports.vendors_earnings'))

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.invoices.index') }}">
                                            <i class="bx bxs-cog"></i> @lang('Invoice.label')
                                        </a>
                                    </li>
                                @endif


                            </ul>
                        </div>
                    </li>
                @endif

                @if (auth()->user()?->isAdminPermittedToList(['admin.settings.index','admin.banks.index']))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#general-settings" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="general-settings">
                            <i class="bx bx-cog"></i> <span>@lang('admin.general_settings')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="general-settings">
                            <ul class="nav nav-sm flex-column">
                                @if (auth()->user()?->isAdminPermittedTo('admin.settings.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.settings.index') }}">
                                            <i class="bx bxs-cog"></i> @lang('admin.settings.main')
                                        </a>
                                    </li>
                                @endif

                                @if (auth()->user()?->isAdminPermittedTo('admin.banks.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.banks.index') }}">
                                            <i class="bx bxs-bank"></i> @lang('admin.banks.manage_banks')
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
