<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ URL::asset('images/logo.png') }}" alt="" height="80" style="background-color:white;">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ URL::asset('images/logo.png') }}" alt="" height="80" style="background-color:white;">
                        </span>
                    </a>

                    <a href="index" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ URL::asset('images/logo.png') }}" alt="" height="80" style="background-color:white;">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ URL::asset('images/logo.png') }}" alt="" height="80" style="background-color:white;">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
               <livewire:admin.global-search />
            </div>

            <div class="d-flex align-items-center">

                <div class="dropdown ms-1 topbar-head-dropdown header-item">
{{--                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                        @switch(Session::get('lang'))--}}
{{--                        @case('ru')--}}
{{--                        <img src="{{ URL::asset('/assets/images/flags/russia.svg') }}" class="me-2 rounded" alt="Header Language" height="20">--}}
{{--                        @break--}}
{{--                        @case('it')--}}
{{--                        <img src="{{ URL::asset('/assets/images/flags/italy.svg') }}" class="me-2 rounded" alt="Header Language" height="20">--}}
{{--                        @break--}}
{{--                        @case('sp')--}}
{{--                        <img src="{{ URL::asset('/assets/images/flags/spain.svg') }}" class="me-2 rounded" alt="Header Language" height="20">--}}
{{--                        @break--}}
{{--                        @case('ch')--}}
{{--                        <img src="{{ URL::asset('/assets/images/flags/china.svg') }}" class="me-2 rounded" alt="Header Language" height="20">--}}
{{--                        @break--}}
{{--                        @case('fr')--}}
{{--                        <img src="{{ URL::asset('/assets/images/flags/french.svg') }}" class="me-2 rounded" alt="Header Language" height="20">--}}
{{--                        @break--}}
{{--                        @case('gr')--}}
{{--                        <img src="{{ URL::asset('/assets/images/flags/germany.svg') }}" class="me-2 rounded" alt="Header Language" height="20">--}}
{{--                        @break--}}
{{--                        @case('ae')--}}
{{--                        <img src="{{ URL::asset('/assets/images/flags/ae.svg') }}" class="me-2 rounded" alt="Header Language" height="20">--}}
{{--                        @break--}}
{{--                        @default--}}
{{--                        <img src="{{ URL::asset('/assets/images/flags/us.svg') }}" class="me-2 rounded" alt="Header Language" height="20">--}}
{{--                        @endswitch--}}
{{--                    </button>--}}
                    <div class="dropdown-menu dropdown-menu-end">

                        <!-- item-->
                        <a href="{{ route('set.locale', ['locale' => 'ar']) }}" class="dropdown-item notify-item language" data-lang="ae" title="Arabic">
                            <img src="{{URL::asset('assets/images/flags/ae.svg')}}" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">Arabic</span>
                        </a>


                        <!-- item-->
                        {{-- <a href="{{ url('index/sp') }}" class="dropdown-item notify-item language" data-lang="sp" title="Spanish">
                            <img src="{{ URL::asset('assets/images/flags/spain.svg') }}" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">Española</span>
                        </a> --}}

                        <!-- item-->
                        <a href="{{ route('set.locale', ['locale' => 'gr']) }}" class="dropdown-item notify-item language" data-lang="gr" title="German">
                            <img src="{{ URL::asset('assets/images/flags/germany.svg') }}" alt="user-image" class="me-2 rounded" height="20"> <span class="align-middle">Deutsche</span>
                        </a>

                        <!-- item-->
                        {{-- <a href="{{ url('index/it') }}" class="dropdown-item notify-item language" data-lang="it" title="Italian">
                            <img src="{{ URL::asset('assets/images/flags/italy.svg') }}" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">Italiana</span>
                        </a> --}}

                        <!-- item-->
                        {{-- <a href="{{ url('index/ru') }}" class="dropdown-item notify-item language" data-lang="ru" title="Russian">
                            <img src="{{ URL::asset('assets/images/flags/russia.svg') }}" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">русский</span>
                        </a> --}}

                        <!-- item-->
                        {{-- <a href="{{ url('index/ch') }}" class="dropdown-item notify-item language" data-lang="ch" title="Chinese">
                            <img src="{{ URL::asset('assets/images/flags/china.svg') }}" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">中国人</span>
                        </a> --}}

                        <!-- item-->
                        <a href="{{ route('set.locale', ['locale' => 'fr']) }}" class="dropdown-item notify-item language" data-lang="fr" title="French">
                            <img src="{{ URL::asset('assets/images/flags/french.svg') }}" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">français</span>
                        </a>

                        <!-- item-->
                        <a href="{{ route('set.locale', ['locale' => 'en']) }}" class="dropdown-item notify-item language py-2" data-lang="en" title="English">
                            <img src="{{ URL::asset('assets/images/flags/us.svg') }}" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">English</span>
                        </a>


                         <!-- item-->
                         <a href="{{ route('set.locale', ['locale' => 'id']) }}"     class="dropdown-item notify-item language py-2" data-lang="id" title="indonesian">
                            <img src="{{ URL::asset('assets/images/flags/id.svg') }}" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">Indonesian</span>
                        </a>

                    </div>
                </div>



                <div class="dropdown d-md-none topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-search fs-22"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>
                <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-bell fs-22'></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span id="notification-counter" class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">{{ auth()->user()->unreadNotifications->count() }}<span class="visually-hidden">@lang('notifications.unread')</span></span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white">@lang('notifications.notifications')</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content position-relative" id="notificationItemsTabContent">
                            <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                <div data-simplebar style="max-height: 300px;" class="pe-2">
                                    @foreach(auth()->user()->notifications->take(25) AS $notification)
                                        <div class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <div class="avatar-xs me-3">
                                                    <span class="avatar-title bg-soft-info text-info rounded-circle fs-16">
                                                        <i class="bx bx-badge-check"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-1">
                                                    <a href="{{ isset($notification->data['url'])?$notification->data['url']:'#' }}">
                                                        <h6 class="mt-0 mb-2 lh-base">{{ $notification->data['title'] }}</h6>
                                                    </a>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        {{ $notification->data['message'] }}
                                                        <span><i class="mdi mdi-clock-outline"></i>{{ \Carbon\Carbon::parse($notification->created_at)->toDayDateTimeString() }}</span>
                                                    </p>
                                                </div>
                                                @if($notification->read_at == null)
                                                    <div class="px-2 fs-15">
                                                        <a href="javascript:void();" onclick="markAsRead('{{ $notification->id }}',this)"><i class="ri-check-fill mark-as-read"></i></a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(Auth::user()->email))) }}" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }} </span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">@lang('admin.welcome') : {{ Auth::user()->name }}!</h6>
                        {{--<a class="dropdown-item" href="pages-profile"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                        <a class="dropdown-item" href="apps-chat"><i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Messages</span></a>
                        <a class="dropdown-item" href="apps-tasks-kanban"><i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Taskboard</span></a>
                        <a class="dropdown-item" href="pages-faqs"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Help</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="pages-profile"><i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance : <b>$5971.67</b></span></a>
                        <a class="dropdown-item" href="pages-profile-settings"><span class="badge bg-soft-success text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Settings</span></a>
                        <a class="dropdown-item" href="auth-lockscreen-basic"><i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock screen</span></a>--}}
                        <a class="dropdown-item " href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-16 align-middle me-1"></i> <span key="t-logout">@lang('translation.logout')</span></a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- removeNotificationModal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@section('script-bottom')
    <script>
        function markAsRead(id,item)
        {
            let notification_counter = $('#notification-counter');
            $.post("{{ route('admin.notifications.mark-as-read') }}", {
                id: id,
                "_token": "{{ csrf_token() }}"
            }, function (data) {
                let current_counter = parseInt(notification_counter.text());
                if(current_counter == 1)
                {
                    notification_counter.remove();
                }
                else
                {
                    notification_counter.text(current_counter-1)
                }
                $(item).remove();
            }, "json");
        }
    </script>
@endsection
