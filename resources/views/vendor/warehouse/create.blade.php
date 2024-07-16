@extends('vendor.layouts.master')
@section('title')
    @lang('admin.warehouses.create')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')

    @section('content')
        @component('components.breadcrumb')
            @slot('li_1')
                @lang('translation.app_name')
            @endslot
            @slot('link')
                {{route('vendor.warehouses.index')}}
            @endslot
            @slot('link_name')
                @lang('translation.warehouses')
            @endslot
            @slot('title')
                @lang('translation.create_warehouse')
            @endslot
        @endcomponent

    @include('sweetalert::alert')
    @include("components.session-alert")

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            @lang('admin.warehouses.create')
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('vendor.warehouses.store') }}" method="post" class="form-steps" autocomplete="on">
                                @csrf
                                @method('post')
                                <div class="text-center pt-3 pb-4 mb-1">
                                    <img src="assets/images/logo-dark.png" alt="" height="17">
                                </div>
                                <div class="tab-content">
                                    <!-- Start Of Arabic Info tab pane -->
                                    <div class="tab-pane fade active show" id="areas-arabic-info" role="tabpanel" aria-labelledby="areas-arabic-info-tab">
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">@lang('admin.warehouse_type')</label>
                                                        <span class="text-danger">*</span>
                                                        <select name="shipping_type[]" multiple class="form-control" data-choices data-choices-removeItem>
                                                            @foreach($shipping_types ?? [] as $shipping_type)
                                                                <option value="{{ $shipping_type->id }}" @selected(in_array($shipping_type->id, (old("shipping_type") ?? [])))>
                                                                    {{ $shipping_type->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('shipping_type')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @foreach(config('app.locales') AS $locale)
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="warehouse-name-inputs">@lang('admin.warehouse_name')<span class="required" style="color: red!important">*</span> (@lang('language.'.$locale))</label>
                                                        <input type="text" class="form-control @error('name.'.$locale) is-invalid @enderror" name="name[{{ $locale }}]"
                                                               value="{{isset($row) ? $row->getTranslation('name',$locale) : old('name.'.$locale)}}"
                                                               placeholder="{{__('admin.warehouse_name_plcaholder')}}"
                                                               id="warehouse-name-inputs">

                                                        @error('name.'.$locale)
                                                        <span class="error text-danger" role="alert"> {{ $message }} </span>
                                                        @enderror

                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="row">
{{--                                                <div class="col-lg-6">--}}
{{--                                                    <div class="mb-3">--}}
{{--                                                        <label class="form-label" for="torod_warehouse_name">@lang('admin.warehouses.torod_warehouse_name')</label>--}}
{{--                                                        <input type="text" name="torod_warehouse_name" class="form-control"--}}
{{--                                                               value="{{ old("torod_warehouse_name") }}"--}}
{{--                                                               id="torod_warehouse_name"--}}
{{--                                                               placeholder="{{ trans('admin.warehouses.torod_warehouse_name') }}">--}}
{{--                                                        @error('torod_warehouse_name')--}}
{{--                                                        <span class="text-danger">{{ $message }}</span>--}}
{{--                                                        @enderror--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">@lang('admin.warehouses.cities')</label>
                                                        <span class="text-danger">*</span>
                                                        <select name="cities[]" class="form-select" dir="rtl" data-choices data-choices-removeItem>
                                                            @foreach($cities ?? [] as $city)
                                                                <option value="{{ $city->id }}" @selected(in_array($city->id, (old("cities") ?? [])))>
                                                                    {{ $city->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('cities')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">@lang('admin.warehouses.days')</label>
                                                        <select name="days[]" class="form-select" dir="rtl" data-choices data-choices-removeItem multiple>
                                                            @foreach(\App\Enums\WarehouseDays::getDays() as $key => $day)
                                                                <option value="{{$key}}" >
                                                                    {{ $day }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="time_work">@lang('admin.from') </label>
                                                        <input type="text" name="time_work_from" class="form-control"
                                                               value="{{ old("time_work_from") ?? "06:30" }}"
                                                               placeholder="06:30">
                                                    </div>
                                                </div>

                                                <div class="col-lg-1">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="time_work">@lang('admin.to') </label>
                                                        <input type="text" name="time_work_to" class="form-control"
                                                               value="{{ old("time_work_to") ?? "16:30" }}"

                                                               placeholder="14:40">
                                                    </div>
                                                </div>
                                            </div>
                                            {{--
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="package_price">@lang('admin.warehouses.package_price') @lang('translation.sar')</label>
                                                        <input type="text" name="package_price" class="form-control"
                                                               value="{{ old("package_price") ?? 0 }}"
                                                               id="package_price"
                                                               placeholder="{{ trans('admin.warehouses.package_price') }}">
                                                        @error('package_price')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="package_covered_quantity">@lang('admin.warehouses.package_covered_quantity')</label>
                                                        <input type="text" name="package_covered_quantity" class="form-control"
                                                               value="{{ old("package_covered_quantity") }}"
                                                               id="package_covered_quantity"
                                                               placeholder="{{ trans('admin.warehouses.package_covered_quantity') }}">
                                                        @error('package_covered_quantity')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="additional_unit_price">@lang('admin.warehouses.additional_unit_price') @lang('translation.sar')</label>
                                                        <input type="text" name="additional_unit_price" class="form-control"
                                                               value="{{ old("additional_unit_price") ?? 0 }}"
                                                               id="additional_unit_price"
                                                               placeholder="{{ trans('admin.warehouses.additional_unit_price') }}">
                                                        @error('additional_unit_price')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            --}}
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="administrator_name">@lang('admin.warehouses.administrator_name')</label>
                                                        <span class="text-danger">*</span>
                                                        <input type="text" name="administrator_name" class="form-control"
                                                               value="{{ old("administrator_name") }}"
                                                               id="administrator_name"
                                                               placeholder="{{ trans('admin.warehouses.administrator_name') }}">
                                                        @error('administrator_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="administrator_phone">@lang('admin.warehouses.administrator_phone')</label>
                                                        <span class="text-danger">*</span>
                                                        <input type="text" name="administrator_phone" class="form-control"
                                                               value="{{ old("administrator_phone") }}"
                                                               id="phone"
                                                               placeholder="{{ trans('admin.warehouses.administrator_phone') }}">
                                                        @error('administrator_phone')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="administrator_email">@lang('admin.warehouses.administrator_email')</label>
                                                        <span class="text-danger">*</span>
                                                        <input type="text" name="administrator_email" class="form-control"
                                                               value="{{ old("administrator_email") }}"
                                                               id="administrator_email"
                                                               placeholder="{{ trans('admin.warehouses.administrator_email') }}">
                                                        @error('administrator_email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="spl_id">@lang('admin.postcode')</label>
                                                        <span class="text-danger">*</span>
                                                        <input type="number" name="postcode" class="form-control"
                                                               value="{{ old("postcode") }}"
                                                               id="postcode"
                                                               placeholder="{{ trans('admin.postcode') }}">
                                                        @error('postcode')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">@lang('admin.spl_branch_id')</label> <small>(في حال نوع المستودع توصيل)</small>
                                                        <input type="number" name="spl_branch_id" class="form-control"  value="{{ old("spl_branch_id") }}" >
                                                        @error('spl_branch_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="address" class="form-label">   العنوان المختصر باللغة الإنجليزية <small>(مثال: Riyadh 13512, Saudi Arabia)</small>

                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control @error('address.en') is-invalid @enderror" name="address[en]"
                                                           value="{{ old('address.en')}}"
                                                           id="address_en">
                                                    @error('address.en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>
                                                            {{$message}}
                                                        </strong>
                                                    </span>
                                                    @enderror

                                                </div>
                                            </div>

                                            {{-- START  NEW MAP --}}
                                            <div class="form-group">
                                                <label for="address_address">@lang('admin.warehouses.map')</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" id="address-input" name="address[ar]" class="form-control map-input" value="{{ old('address.ar')  }}" placeholder="ابحث عن الموقع">
                                                <input type="hidden" name="latitude" id="address-latitude" value="{{ old('latitude' , 0)  }}" readonly="yes"/>
                                                <input type="hidden" name="longitude" id="address-longitude" value="{{ old('longitude' , 0)  }}" readonly="yes" />
                                            </div>
                                            @error('address.ar')
                                                <span class="text-danger">
                                                    @lang("admin.warehouses.validations.latitude_required")
                                                </span>
                                            @endif
                                            @if($errors->has('latitude') && $errors->has('longitude'))
                                                <span class="text-danger">
                                                    @lang("admin.warehouses.validations.latitude_required")
                                                </span>
                                            @endif

                                            <div id="address-map-container" style="width:100%;height:400px; ">
                                                <div style="width: 100%; height: 100%" id="address-map"></div>
                                            </div>


                                            {{-- END  NEW MAP --}}

                                        </div>
                                    </div>
                                    <!-- End Of Arabic Info tab pane -->
                                </div>
                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <button type="submit"
                                            class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                        <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                        @lang('admin.create')
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('assets/js/pages/ecommerce-order.init.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ config("app.google-map-api-key") }}&libraries=places&callback=initialize" async defer></script>
    <script>

    function initialize() {

    $('form').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
    e.preventDefault();
    return false;
    }
    });
    const locationInputs = document.getElementsByClassName("map-input");

    const autocompletes = [];
    const geocoder = new google.maps.Geocoder;
    for (let i = 0; i < locationInputs.length; i++) {

    const input = locationInputs[i];
    const fieldKey = input.id.replace("-input", "");
    const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';
        // 24.7251918, 46.8225288
    const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || 24.7251918;
    const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 46.8225288;

    const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
    center: {lat: latitude, lng: longitude},
    zoom: 13
    });
    const marker = new google.maps.Marker({
    map: map,
    position: {lat: latitude, lng: longitude},
        //draggable: true //make it draggable
    });




    marker.setVisible(isEdit);

    const autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.key = fieldKey;
    autocompletes.push({input: input, map: map, marker: marker, autocomplete: autocomplete});
    }

    for (let i = 0; i < autocompletes.length; i++) {
    const input = autocompletes[i].input;
    const autocomplete = autocompletes[i].autocomplete;
    const map = autocompletes[i].map;
    const marker = autocompletes[i].marker;

    google.maps.event.addListener(autocomplete, 'place_changed', function () {
    marker.setVisible(false);
    const place = autocomplete.getPlace();
    geocoder.geocode({'placeId': place.place_id}, function (results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
    const lat = results[0].geometry.location.lat();
    const lng = results[0].geometry.location.lng();
    setLocationCoordinates(autocomplete.key, lat, lng);
    }
    });

    if (!place.geometry) {
    window.alert("No details available for input: '" + place.name + "'");
    input.value = "";
    return;
    }

    if (place.geometry.viewport) {
    map.fitBounds(place.geometry.viewport);
    } else {
    map.setCenter(place.geometry.location);
    map.setZoom(17);
    }
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);

    });

        //Listen for any clicks on the map.
        google.maps.event.addListener(map, 'click', function(event) {
            var clickedLocation = event.latLng;
            marker.setPosition(clickedLocation);
            var currentLocation = marker.getPosition();
            marker.setVisible(true);
            setLocationCoordinates('address', currentLocation.lat() , currentLocation.lng() );
            markerLocation(currentLocation)
        });


    }
    }

    function markerLocation(currentLocation){
        $.ajax({
            type: 'get',
            url: 'https://maps.googleapis.com/maps/api/geocode/json?language=en_AU&latlng=' + currentLocation.lat() + ',' + currentLocation.lng() + '&key=AIzaSyAj4DOc31MZvYIUQeMADEfb_TpPAVWyH1A',
            success: function(res){
                var address = res.results[0].formatted_address;
                document.getElementById('address-input').value = address;
            }, error: function(err){
                console.log(err);
            }
        });
    }


    function setLocationCoordinates(key, lat, lng) {
        const latitudeField = document.getElementById(key + "-" + "latitude");
        const longitudeField = document.getElementById(key + "-" + "longitude");
        latitudeField.value = lat;
        longitudeField.value = lng;
    }

    const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
        center: {lat: latitude, lng: longitude},
        zoom: 13
    });
    const marker = new google.maps.Marker({
        map: map,
        position: {lat: latitude, lng: longitude},
    });

    const autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.key = fieldKey;
    autocompletes.push({input: input, map: map, marker: marker, autocomplete: autocomplete});

    geocoder.geocode({'placeId': place.place_id}, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {

            const lat = results[0].geometry.location.lat();
            const lng = results[0].geometry.location.lng();

            setLocationCoordinates(autocomplete.key, lat, lng);
        }
    });

</script>
@endsection
