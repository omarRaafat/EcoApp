@extends('admin.layouts.master')
@section('title')
    @lang("admin.warehouses.show")
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="card-header  border-0">
            <div class="d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">
                    @lang("admin.warehouses.show"): {{ $warehouse->name }}
                </h5>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xxl-5">
            <div class="card">
                <div class="row g-0">
                    <div class="col-lg-12">
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.id")</b> {{ $warehouse->id }}
                        </div>

                        <div class="row">
                            @foreach(config('app.locales') AS $locale)
                            <div class="card-body border-end">
                                <b>@lang("admin.warehouses.name")-@lang('language.'.$locale)</b> {{ $warehouse->getTranslation('name', $locale)}}
                            </div>
                            @endforeach
                        </div>
                        {{-- <div class="card-body border-end">
                            <b>@lang("admin.warehouses.name_ar")</b> {{ $warehouse->getTranslation('name', 'ar') }}
                        </div>--}}
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouse_type")</b>
                            @foreach($warehouse->shippingTypes as $type)
                                <span class="badge badge-danger" style="background-color: green;"> {{ $type->title }} </span>
                            @endforeach
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.torod_warehouse_name")</b> {{ !empty($warehouse->torod_warehouse_name) ? $warehouse->torod_warehouse_name : trans("admin.warehouses.not_found") }}
                        </div>
                        {{--
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.package_covered_quantity")</b> {{ $warehouse->package_covered_quantity }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.package_price")</b> {{ $warehouse->package_price }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.additional_unit_price")</b> {{ $warehouse->additional_unit_price }}
                        </div>
                        --}}
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.administrator_name")</b> {{ $warehouse->administrator_name }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.administrator_phone")</b> {{ $warehouse->administrator_phone }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.administrator_email")</b> {{ $warehouse->administrator_email }}
                        </div>

                        <div class="card-body border-end">
                            @php
                                $days = json_decode($warehouse->days);
                            @endphp
                            <b>@lang("admin.warehouses.days")</b> :
                            @if(isset($days))
                            @foreach($days as $key => $day)
                                {{\App\Enums\WarehouseDays::getDay($day)}} -
                            @endforeach
                            @endif
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.time_work")</b> :  {{$warehouse->time_work_from}} - {{$warehouse->time_work_to}}

                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.warehouses.map")</b>
                            <br><br>
                            <div id="map" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-xxl-6">
            @if (auth()->user()?->isAdminPermittedTo('admin.warehouses.pending') && $warehouse->isPending())
            <div class="card">
                <div class="card-header">
                    الموافقة
                </div>
                <div class="card-body">
                    <form action="{{  route('admin.warehouses.accepting',$warehouse->id) }}" method="post" >
                        @csrf
                        <button class="btn btn-success d-block w-100" onclick="return confirmAccept(event)" type="button" >  
                                الموافقة 
                        </button>
                    </form>
                </div>
            </div>
            <br><br><br>
            <div class="card">
                <div class="card-header">
                    الرفض
                </div>
                <div class="card-body">
                    <form action="{{  route('admin.warehouses.reject',$warehouse->id) }}" method="post" >
                        @csrf
                        <textarea name="reason" class="form-control" rows="5" placeholder="أكتب سبب الرفض"></textarea>
                        <button class="btn btn-danger d-block w-100" onclick="return confirmReject(event)" type="button" >  
                                رفض 
                        </button>
                    </form>
                </div>
            </div>
            @endif
            @if (auth()->user()?->isAdminPermittedTo('admin.warehouses.updated') && $warehouse->isWaitUpdated())
            <div class="card">
                <div class="card-header">
                     التعديلات
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <th>الحقل</th>
                            <th>القيمة الحالية</th>
                            <th>القيمة المحدثة</th>
                        </thead>
                        <tbody>
                            @foreach ($warehouse->getLastStatus->data as $item)
                                <tr>
                                    <td>{{ __('admin.warehouses.'.$item['key']) }}</td>
                                    <td>
                                        @php
                                        if(isset($item['old']) && !is_array($item['old']))
                                            if($item['key'] == 'is_active')
                                                echo $item['old'] == 1 ?  __('admin.warehouse_active') : __('admin.warehouse_inactive');
                                            
                                        if(isset($item['oldLabel'])) echo is_array($item['oldLabel']) ? implode(',', $item['oldLabel']) : $item['oldLabel'];
                                        
                                     @endphp
                                    </td>
                                    <td>
                                        @php
                                        if(!is_array($item['new']))
                                        if($item['key'] == 'is_active')
                                                echo $item['new'] == 1 ? __('admin.warehouse_active') : __('admin.warehouse_inactive');
                                        if(isset($item['newLabel'])) echo is_array($item['newLabel']) ? implode(',', $item['newLabel']) : $item['newLabel'];
                                        @endphp
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    الموافقة على التعديلات
                </div>
                <div class="card-body">
                    <form action="{{  route('admin.warehouses.acceptUpdate',$warehouse->id) }}" method="post" >
                        @csrf
                        <button class="btn btn-success d-block w-100" onclick="return confirmAccept(event)" type="button" >  
                            الموافقة على التعديلات 
                        </button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    الرفض
                </div>
                <div class="card-body">
                    <form action="{{  route('admin.warehouses.refuseUpdate',$warehouse->id) }}" method="post" >
                        @csrf
                        <textarea name="reason" class="form-control" rows="5" placeholder="أكتب سبب الرفض"></textarea>
                        <button class="btn btn-danger d-block w-100" onclick="return confirmReject(event)" type="button" >  
                                رفض 
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('assets/js/pages/ecommerce-order.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script type="text/javascript">
        function initMap() {
            var lat = {{ !empty($warehouse->latitude) ? $warehouse->latitude : 24.7251918 }}
            var lng = {{ !empty($warehouse->longitude) ? $warehouse->longitude : 46.8225288 }}
          const myLatLng = { lat, lng };
          const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 12,
            center: myLatLng,
          });

          new google.maps.Marker({
            position: myLatLng,
            map,
            title: "Saudi Dates Warehouses Map!",
          });
        }

        window.initMap = initMap;
    </script>

    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ config("app.google-map-api-key") }}&callback=initMap" ></script>
@endsection
