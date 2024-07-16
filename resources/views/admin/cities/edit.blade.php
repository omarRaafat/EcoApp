@extends('admin.layouts.master')
@section('title')
    @lang('admin.cities.update')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            @lang('admin.edit')
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.cities.update', $city->id) }}" method="post" class="form-steps" autocomplete="on">
                                @csrf
                                @method('PUT')
                                <div class="text-center pt-3 pb-4 mb-1">
                                    <img src="assets/images/logo-dark.png" alt="" height="17">
                                </div>
                                <div class="tab-content">
                                    <!-- Start Of Arabic Info tab pane -->
                                    <div class="tab-pane fade active show" id="cities-arabic-info" role="tabpanel"
                                        aria-labelledby="cities-arabic-info-tab">
                                        <div>
                                            <div class="row">
                                                @foreach(config('app.locales') AS $locale)
                                                <div class="col-md-6 mb-3">
                                                    <label for="username" class="form-label">@lang('admin.cities.name') -@lang('language.'.$locale)
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control @error('name.'.$locale) is-invalid @enderror" name="name[{{ $locale }}]"
                                                    value="{{ old('name.'.$locale) ?? $city->getTranslation('name',$locale)}}"
                                                    id="city_name">
                                                    @error('name.' . $locale)
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>
                                                            {{$message}}
                                                        </strong>
                                                    </span>
                                                    @enderror

                                                </div>
                                                @endforeach
                                            </div>

                                            <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="username" class="form-label">@lang('admin.cities.name') -@lang('language.en')
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control @error('name.en') is-invalid @enderror" name="name[en]"
                                                               value="{{ old('name.en') ?? $city->getTranslation('name','en')}}"
                                                               id="city_name">
                                                        @error('name.en')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>
                                                            {{$message}}
                                                        </strong>
                                                    </span>
                                                        @enderror

                                                    </div>
                                            </div>

                                               <div class="row">
                                                 <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="area_id">@lang('admin.cities.area_id')</label>
                                                        <select class="select2 form-control" name="area_id" id="select2_area_id">
                                                            <option selected value="">
                                                                @lang("admin.cities.choose_area")
                                                            </option>
                                                            @foreach ($areas as $area)
                                                                @if ($city->area->id == $area->id)
                                                                    <option selected value="{{ $area->id }}">
                                                                        {{ $area->getTranslation('name', 'ar') }}
                                                                    </option>
                                                                @endif
                                                                <option value="{{ $area->id }}">
                                                                    {{ $area->getTranslation('name', 'ar') }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('area_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="is_active">@lang('admin.cities.is_active')</label>
                                                        <select class="select2 form-control" name="is_active" id="select2_is_active">
                                                            <option value="">
                                                                @lang("admin.cities.choose_state")
                                                            </option>
                                                            @foreach ($stateOfCity as $state)
                                                                @if($city->is_active == $state["value"])
                                                                    <option selected value="{{ $state["value"] }}">
                                                                        {{ $state["name"] }}
                                                                    </option>
                                                                @else
                                                                    <option value="{{ $state["value"] }}">
                                                                        {{ $state["name"] }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        @error('is_active')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="torod_city_id">@lang('admin.cities.torod_city_id')</label>
                                                        <input type="text" name="torod_city_id" class="form-control"
                                                            id="torod_city_id"
                                                            value="{{ $city->torod_city_id }}"
                                                            placeholder="{{ trans('admin.cities.torod_city_id') }}">
                                                        @error('torod_city_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="spl_id">@lang('admin.countries.spl_id')</label>
                                                        <input type="text" name="spl_id" class="form-control"
                                                            value="{{ $city->spl_id ? $city->spl_id : "" }}"

                                                            id="spl_id"
                                                            placeholder="{{ trans('admin.countries.spl_id') }}">
                                                        @error('spl_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <input type="hidden" name="city_id" value="{{ $city->id }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="spl_id">@lang('admin.postcode')</label>
                                                        <input type="number" name="postcode" class="form-control"
                                                               value="{{ old("postcode" , $city->postcode) }}"
                                                               id="postcode"
                                                               placeholder="{{ trans('admin.postcode') }}">
                                                        @error('postcode')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <input type="hidden" name="address" class="form-control"
                                                               value="{{ $city->address ? $city->address : old("address") }}"
                                                               id="address"
                                                               placeholder="{{ trans('admin.warehouses.city_address') }}">
                                                        @error('address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="map">@lang('admin.city_map')</label>
                                                        <input type="hidden" name="latitude" value="{{ $city->latitude }}" id="lat" readonly="yes"><br>
                                                        <input type="hidden" name="longitude" value="{{$city->longitude}}" id="lng" readonly="yes">
                                                        @if($errors->has('latitude') && $errors->has('longitude'))
                                                            <span class="text-danger">
                                                                @lang("admin.warehouses.validations.latitude_required")
                                                            </span>
                                                        @endif
                                                        <br>
                                                        <div id="map" style="height: 400px"></div>
                                                    </div>
                                                </div>
                                            </div>
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
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2_city_id').select2({
                placeholder: "Select",
                allowClear: true
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select2_is_active').select2({
                placeholder: "Select",
                allowClear: true
            });

        });
    </script>

    <script type="text/javascript">
        //Set up some of our variables.
        var map; //Will contain map object.
        var marker = false; ////Has the user plotted their location marker?
        var warehouseLat = {{!empty($city->latitude) ? $city->latitude : 24.7251918}}
            var warehouseLong = {{!empty($city->longitude) ? $city->longitude : 46.8225288 }}
        //Function called to initialize / create the map.
        //This is called when the page has loaded.

        function changeMarker() {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(warehouseLat, warehouseLong),
                map: map,
                draggable: true //make it draggable
            });
        }
        function initMap() {
            //The center location of our map.
            var centerOfMap = new google.maps.LatLng(warehouseLat, warehouseLong);

            //Map options.
            var options = {
                center: centerOfMap, //Set center.
                zoom: 12 //The zoom value.
            };

            //Create the map object.
            map = new google.maps.Map(document.getElementById('map'), options);

            //Listen for any clicks on the map.
            google.maps.event.addListener(map, 'click', function(event) {
                //Get the location that the user clicked.
                var clickedLocation = event.latLng;
                console.log("1", clickedLocation, "2", centerOfMap)
                //If the marker hasn't been added.
                if(marker === false){
                    //Create the marker.
                    marker = new google.maps.Marker({
                        position: clickedLocation,
                        map: map,
                        draggable: true //make it draggable
                    });
                    //Listen for drag events!
                    google.maps.event.addListener(marker, 'dragend', function(event){
                        markerLocation();
                    });
                } else{
                    //Marker has already been added, so just change its location.
                    marker.setPosition(clickedLocation);
                }
                //Get the marker's location.
                markerLocation();
            });

            changeMarker()
        }

        //This function will get the marker's current location and then add the lat/long
        //values to our textfields so that we can save the location.
        function markerLocation(){
            //Get location.
            var currentLocation = marker.getPosition();
            //Add lat and lng values to a field that we can save.
            document.getElementById('lat').value = currentLocation.lat(); //latitude
            document.getElementById('lng').value = currentLocation.lng(); //longitude
            $.ajax({
                type: 'get',
                url: 'https://maps.googleapis.com/maps/api/geocode/json?language=en_AU&latlng=' + currentLocation.lat() + ',' + currentLocation.lng() + '&key=AIzaSyAj4DOc31MZvYIUQeMADEfb_TpPAVWyH1A',
                success: function(res){
                    var address = res.results[0].formatted_address;
                    document.getElementById('address').value = address;
                }, error: function(err){
                    console.log(err);
                }
            });
        }

        //Load the map when the page has finished loading.
        google.maps.event.addDomListener(window, 'load', initMap);
    </script>

    <script type="text/javascript" src="https://maps.google.com/maps/api/js?language=en_AU&key={{ config("app.google-map-api-key") }}&callback=initMap" ></script>
@endsection
