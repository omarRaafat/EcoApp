@extends('admin.layouts.master')
@section('title')
    @lang('postHarvestServices.post-harvest-services')
@endsection
@section('css')
    <style>
        {{--  #dynamic-inputs {
            display: none;
        }  --}} .input-container {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }
    </style>
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
                            <form action="{{ route('admin.post-harvest-services-departments.fields.update', $data->id) }}"
                                method="post" class="form-steps" autocomplete="on" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="field_id" value="{{ $data->id }}">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="username" class="form-label">@lang('admin.categories.name')
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name', $data->name) }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="type">@lang('postHarvestServices.interior_construction_fields.type')</label>
                                    <select class="form-control" name="type" id="type" disabled>
                                        <option value="text-area" {{ $data->type == 'text-area' ? 'selected' : '' }}>
                                            {{ trans('postHarvestServices.interior_construction_fields.text-area') }}
                                        </option>
                                        <option value="checkbox" {{ $data->type == 'checkbox' ? 'selected' : '' }}>
                                            {{ trans('postHarvestServices.interior_construction_fields.checkbox') }}
                                        </option>
                                        <option value="dropdown-list"{{ $data->type == 'dropdown-list' ? 'selected' : '' }}>
                                            {{ trans('postHarvestServices.interior_construction_fields.dropdown-list') }}
                                        </option>
                                        <option value="integer" {{ $data->type == 'integer' ? 'selected' : '' }}>
                                            {{ trans('postHarvestServices.interior_construction_fields.integer') }}
                                        </option>
                                        <option value="from-to" {{ $data->type == 'from-to' ? 'selected' : '' }}>
                                            {{ trans('postHarvestServices.interior_construction_fields.from-to') }}
                                        </option>
                                    </select>
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="is_required">@lang('postHarvestServices.interior_construction_fields.is_required')</label>
                                    <select class="form-control" name="is_required" id="is_required">
                                        <option value="1"
                                            {{ $data->is_required == trans('postHarvestServices.interior_construction_fields.yes') ? 'selected' : '' }}>
                                            {{ trans('postHarvestServices.interior_construction_fields.yes') }}</option>
                                        <option value="0"
                                            {{ $data->is_required == trans('postHarvestServices.interior_construction_fields.no') ? 'selected' : '' }}>
                                            {{ trans('postHarvestServices.interior_construction_fields.no') }}</option>
                                    </select>
                                    @error('is_required')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="depends_on_price">@lang('postHarvestServices.interior_construction_fields.depends_on_price')</label>
                                    <select class="form-control" name="depends_on_price" id="depends_on_price">
                                        <option value="1"
                                            {{ $data->depends_on_price == trans('postHarvestServices.interior_construction_fields.yes') ? 'selected' : '' }}>
                                            {{ trans('postHarvestServices.interior_construction_fields.yes') }}</option>
                                        <option value="0"
                                            {{ $data->depends_on_price == trans('postHarvestServices.interior_construction_fields.no') ? 'selected' : '' }}>
                                            {{ trans('postHarvestServices.interior_construction_fields.no') }}</option>
                                    </select>
                                    @error('depends_on_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="status">@lang('admin.categories.is_active')</label>
                                    <div class="form-check form-switch form-switch-lg" dir="ltr">
                                        <input type="checkbox" name="status" class="form-check-input" id="is_active"
                                            value="active" @if ($data->status == 'active') checked @endif>
                                    </div>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if ($data->type == 'dropdown-list' || $data->type == 'checkbox')
                                    @if (isset($data->values))
                                        <div id="dynamic-inputs" class="card">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <h5>أدخل عناصر التحديد</h5>
                                                    <button class="btn btn-success" type="button"
                                                        onclick="addInput()">إضافة</button>
                                                </div>
                                                <div id="inputs-container">
                                                    @foreach ($data->values as $i => $item)
                                                        <div class="input-container"
                                                            id="input-container-{{ $i }}">
                                                            <input type="text" class="form-control me-4" name="values[]"
                                                                placeholder="أدخل الاسم" value="{{ $item }}"
                                                                required>
                                                            <button class="btn btn-success delete-button" type="button"
                                                                onclick="deleteInput(this)"
                                                                id="delete-button-{{ $i }}">حذف</button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <button type="submit" class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                        <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                        @lang('admin.save')
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
    <script>
        const handleChange = (e) => {
            const dynamicInputs = document.getElementById('dynamic-inputs')
            if (e.value == 'checkbox' || e.value == 'dropdown-list') {
                dynamicInputs.style.display = 'block'
                addInput()
            } else {
                dynamicInputs.style.display = 'none'
                const inputsContainer = document.getElementById('inputs-container')
                if (inputsContainer) inputsContainer.innerHTML = ""
            }
        }
        const addInput = () => {
            const idNumber = Math.floor(Math.random() * 1000000000000000000)
            const dynamicInputs = document.getElementById('inputs-container')
            const newDiv = document.createElement('div');
            newDiv.className = 'input-container'
            newDiv.id = `input-container-${idNumber}`

            const newInput = document.createElement('input');
            newInput.type = 'text';
            newInput.placeholder = 'أدخل الاسم';
            newInput.className = 'form-control me-4'
            newInput.name = 'values[]'
            newInput.required = 'required'

            var newButton = document.createElement('button');
            newButton.textContent = 'حذف';
            newButton.type = 'button';
            newButton.className = 'btn btn-success delete-button';
            newButton.id = `delete-button-${idNumber}`;
            {{--  newButton.onclick = deleteInput;  --}}

            newDiv.appendChild(newInput);
            newDiv.appendChild(newButton);
            dynamicInputs.appendChild(newDiv);
            handleDeleteButtons()
        }

        const deleteInput = (e) => {
            const deleteButtons = document.querySelectorAll('.delete-button');
            if (deleteButtons && deleteButtons.length > 1) {
                const id = e.id ? e.id.slice(14) : e.target.id.slice(14)
                const element = document.getElementById(`input-container-${id}`)
                if (element) element.remove();
            }
        }

        const handleDeleteButtons = () => {
            const deleteButtons = document.querySelectorAll('.delete-button');
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', deleteInput);
            });
        }
        handleDeleteButtons()
    </script>
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
        var warehouseLat = {{ !empty($city->latitude) ? $city->latitude : 24.7251918 }}
        var warehouseLong = {{ !empty($city->longitude) ? $city->longitude : 46.8225288 }}
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
                if (marker === false) {
                    //Create the marker.
                    marker = new google.maps.Marker({
                        position: clickedLocation,
                        map: map,
                        draggable: true //make it draggable
                    });
                    //Listen for drag events!
                    google.maps.event.addListener(marker, 'dragend', function(event) {
                        markerLocation();
                    });
                } else {
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
        function markerLocation() {
            //Get location.
            var currentLocation = marker.getPosition();
            //Add lat and lng values to a field that we can save.
            document.getElementById('lat').value = currentLocation.lat(); //latitude
            document.getElementById('lng').value = currentLocation.lng(); //longitude
            $.ajax({
                type: 'get',
                url: 'https://maps.googleapis.com/maps/api/geocode/json?language=en_AU&latlng=' + currentLocation
                    .lat() + ',' + currentLocation.lng() + '&key=AIzaSyAj4DOc31MZvYIUQeMADEfb_TpPAVWyH1A',
                success: function(res) {
                    var address = res.results[0].formatted_address;
                    document.getElementById('address').value = address;
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }

        //Load the map when the page has finished loading.
        google.maps.event.addDomListener(window, 'load', initMap);
    </script>

    <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?language=en_AU&key={{ config('app.google-map-api-key') }}&callback=initMap">
    </script>
@endsection
