<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12 mb-3">
                    <label for="cities" class="form-label @error('cities') is-invalid @enderror">@lang('admin.cities.all_cities') <span class="text-danger">*</span></label>
                    <select class="form-control" name="cities[]" id="cities" data-choices data-choices-removeItem multiple>
                        <option value="">@lang('admin.select')</option>
                        @foreach ($cities as $city)
                            <option @if(isset($row) && in_array($city->id,$row->cities->pluck('id')->toArray())) selected @endif value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                    @error('cities')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="choices-publish-status-input" class="form-label">@lang('translation.main_category')<span class="required"
                            style="color: red!important">*</span></label>
                    <select name="category_id" class="js-example-basic-single form-select" id="category">
                        @if (!isset($row) || (isset($row) && $row->status != 'accepted'))
                            <option value="">اختار القسم</option>
                            @foreach ($main_categories as $key => $value)
                            <option value="{{ $key }}" {{ (isset($row) && $row->category_id == $key) || old('category_id') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                            @endforeach
                        @elseif ((isset($row) && $row->status == 'accepted'))
                            <option value="{{ $row->category_id }}" selected>
                                {{ $row->category?->name }}
                            </option>
                        @endif
                    </select>
                    @error('category_id')
                        <span class="error text-danger"> {{ $message }} </span>
                    @enderror
                </div>

                @if (!isset($row) || (isset($row) && $row->status != 'accepted'))
                    <div id="fields-container"></div>
                @endif
            </div>
        </div>

        @foreach (config('app.locales') as $locale)
            <div class="card card-{{ $locale }}">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="service-name-inputs">@lang('translation.service_name')
                            <span class="required" style="color: red!important">*</span> (@lang('language.' . $locale))
                        </label>
                        <input type="text" class="form-control @error('name.' . $locale) is-invalid @enderror"
                            name="name[{{ $locale }}]"
                            value="{{ isset($row) ? $row->getTranslation('name', $locale) : old('name.' . $locale) }}"
                            placeholder="{{ __('translation.service_name_plcaholder') }}" id="service-name-inputs">
                        @error('name.' . $locale)
                            <span class="error text-danger" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="hidden" name="desc[{{ $locale }}]" id="desc-hiddens_{{ $locale }}">
                        <label>@lang('translation.service_desc')-(@lang('language.' . $locale))
                            <span class="required" style="color: red!important">*</span>
                        </label>
                        @error('desc.' . $locale)
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                        <div id="desc-ckeditor-classic_{{ $locale }}">
                            @if (isset($row))
                                {!! $row->getTranslation('desc', $locale) !!}
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="hidden" name="conditions[{{ $locale }}]"
                            id="conditions-hiddens_{{ $locale }}">
                        <label>@lang('translation.service_conditions')-(@lang('language.' . $locale))
                            <span class="required" style="color: red!important">*</span>
                        </label>
                        @error('conditions.' . $locale)
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                        <div id="conditions-ckeditor-classic_{{ $locale }}">
                            @if (isset($row))
                                {!! $row->getTranslation('conditions', $locale) !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('translation.service_gallery')</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h5 class="fs-14 mb-1">@lang('translation.service_image')<span class="required"
                            style="color: red!important">*</span></h5>
                    <p class="text-muted">@lang('translation.add_service_main_image')</p>
                    @error('image')
                        <span class="error text-danger"> {{ $message }} </span>
                    @enderror
                    <p id="main-image-preview-error" class="mt-3 error text-danger" style="display: none"></p>
                    <div class="text-center">
                        <div class="position-relative d-inline-block">
                            <div class="position-absolute top-100 start-100 translate-middle">
                                <label for="product-image-input" class="mb-0" data-bs-toggle="tooltip"
                                    data-bs-placement="right" title="Select Image">
                                    <div class="avatar-xs">
                                        <div
                                            class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                            <i class="ri-image-fill"></i>
                                        </div>
                                    </div>
                                </label>
                                <input class="form-control d-none" value="" id="product-image-input"
                                    type="file" accept="image/png, image/gif, image/jpeg" name="image">
                            </div>
                            <div class="avatar-lg">
                                <div class="avatar-title bg-light rounded">
                                    @if(isset($row))
                                    <input type="hidden" name="image_from"value="{{$row->square_image}}">
                                     @if($row->square_image_temp && $row->square_image_temp != $row->square_image)
                                     <img src="{{ $row->square_image_temp }}" id="product-img" class="avatar-md h-auto" />
                                     @else
                                     <img src="{{ $row->square_image }}" id="product-img" class="avatar-md h-auto" />
                                     @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="images_array[]" id="images-hidden">
                <input type="hidden" name="deleted_images_array" id="deleted-images-hidden">
                <div>
                    <h5 class="fs-14 mb-1">@lang('translation.service_gallery')</h5>
                    <p class="text-muted">@lang('translation.add_service_gallery_images')</p>

                    <div class="dropzone">
                        <div class="fallback">
                            <input name="file" type="file" multiple="multiple">
                        </div>
                        <div class="dz-message needsclick">
                            <div class="mb-3">
                                <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                            </div>

                            <h5>@lang('translation.drop_files_here_or_click_to_upload')</h5>
                        </div>
                    </div>

                    <p id="dropzone-preview-error" class="mt-3 error text-danger" style="display: none"></p>
                    <ul class="list-unstyled mb-0" id="dropzone-preview">
                        <li class="mt-2" id="dropzone-preview-list">
                            <!-- This is used as the file preview template -->
                            <div class="border rounded">
                                <div class="d-flex p-2">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-sm bg-light rounded">
                                            <img data-dz-thumbnail class="img-fluid rounded d-block" src="#"
                                                alt="Service-Image" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="pt-1">
                                            <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                            <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                            <strong class="error text-danger" data-dz-errormessage></strong>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ms-3">
                                        <button data-dz-remove
                                            class="btn btn-sm btn-danger">@lang('translation.delete')</button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <!-- end dropzon-preview -->
                </div>
            </div>
        </div>
        <div class="text-end mb-3">
            <button type="submit" class="btn btn-success w-sm">@lang('translation.submit')</button>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('translation.accessable')</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="choices-publish-visibility-input" class="form-label">@lang('translation.is_active')</label>

                    {{ Form::select('is_visible', ['0' => __('translation.hidden'), '1' => __('translation.visible')], null, ['class' => 'form-select', 'id' => 'choices-publish-visibility-input', 'data-choices']) }}
                    @error('is_visible')
                        <span class="error text-danger"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
            <!-- end card body -->
        </div>

    </div>
</div>
<!-- end row -->

@section('script-bottom')
    <!--select2 cdn-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

    <script src="{{ URL::asset('assets/js/pages/select2.init.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#form-loader").hide();

            var oldFields = {!! json_encode(old('fields', [])) !!};
            var existingFields = {!! json_encode(isset($row) ? $row->fields : []) !!};

            // Function to map existing fields to the required format
            function mapExistingFields(existingFields) {
                var mappedFields = {};
                if (existingFields) {
                    existingFields.forEach(function(field) {
                        var value = field.field_value;
                        if (typeof value === 'string' && value.includes(',')) {
                            value = value.split(',');
                        }

                        if (!mappedFields[field.field_name]) {
                            mappedFields[field.field_name] = {
                                value: [], // Store values as an array
                                price: {} // Initialize price object
                            };
                        }

                        if (Array.isArray(value)) {
                            value.forEach(function(val) {
                                mappedFields[field.field_name].value.push(
                                val); // Push value to array
                                mappedFields[field.field_name].price[val] = field
                                .field_price; // Set price for value
                            });
                        } else {
                            mappedFields[field.field_name].value.push(value); // Push single value to array
                            mappedFields[field.field_name].price[value] = field
                            .field_price; // Set price for value
                        }
                    });
                }
                return mappedFields;
            }

            // Map existing fields to the required format
            existingFields = mapExistingFields(existingFields);

            // Function to populate fields with old values
            function populateFields(categoryId, oldFields, existingFields) {
                if (categoryId) {
                    $.ajax({
                        url: '/vendor/categories/' + categoryId + '/fields',
                        method: 'GET',
                        success: function(response) {
                            if (Array.isArray(response)) {
                                var fieldsHtml = '';
                                response.forEach(function(field) {
                                    var oldValue = oldFields ? oldFields[field.name] : null;
                                    var existingValue = existingFields ? existingFields[field
                                        .name] : null;
                                    fieldsHtml += generateFieldHtml(field, oldValue,
                                        existingValue);
                                });
                                $('#fields-container').html(fieldsHtml);

                                // Re-initialize Select2 on new dropdowns
                                $('.select2-dropdown').select2().on('change', function() {
                                    handleSelect2Change($(this));
                                });

                                // Handle initial selections for price inputs
                                $('.select2-dropdown').each(function() {
                                    handleSelect2Change($(this));
                                });

                                // Populate values and show prices on page load
                                initializeFields();
                            } else {
                                console.error('Unexpected response format:', response);
                                $('#fields-container').html(
                                    '<p>Error loading fields. Please try again.</p>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            $('#fields-container').html(
                                '<p>Error loading fields. Please try again.</p>');
                        }
                    });
                } else {
                    $('#fields-container').html('');
                }
            }

            // Function to generate field HTML with old value
            function generateFieldHtml(field, oldValue, existingValue) {
                var value = oldValue ? oldValue.value : (existingValue ? existingValue.value : '');
                var price = oldValue ? oldValue.price : (existingValue ? existingValue.price : '');
                value = value === null ? '' : value;
                price = price === null ? '' : price;
                // Check if the field is required
                var required = field.required ? '<span class="required" style="color: red!important">*</span>' : '';
                var html =
                    `<div class="card"><div class="card-body"><div class="mb-3"><label class="form-label">${field.name}${required}</label>`;
                switch (field.type) {
                    case 'text-area':
                        html +=
                            `<textarea class="form-control" name="fields[${field.name}][value]">${value}</textarea>`;
                        break;
                    case 'checkbox':
                        if (Array.isArray(field.values)) {
                            field.values.forEach(function(fieldValue) {
                                var checked = Array.isArray(value) && value.includes(fieldValue) ?
                                    'checked' : '';
                                html +=
                                    `<label class="form-label"><input class="form-check-input ms-3 me-2" type="checkbox" name="fields[${field.name}][value][]" value="${fieldValue}" ${checked}>${fieldValue}</label>`;
                            });
                        }
                        break;
                    case 'dropdown-list':
                        html +=
                            `<select class="form-control select2-dropdown"  name="fields[${field.name}][value][]" multiple>`;
                        if (Array.isArray(field.values)) {
                            field.values.forEach(function(fieldValue) {
                                var selected = Array.isArray(value) && value.includes(fieldValue) ?
                                    'selected' : '';
                                html += `<option  value="${fieldValue}" ${selected}>${fieldValue}</option>`;
                            });
                        }
                        html += `</select>`;
                        if (Array.isArray(field.values)) {
                            field.values.forEach(function(fieldValue) {
                                var priceId = `price-input-${field.name}-${fieldValue}`;
                                var displayStyle = Array.isArray(value) && value.includes(fieldValue) ? '' :
                                    'display: none;';
                                var fieldPrice = existingValue && existingValue.price && existingValue
                                    .price[fieldValue] ? existingValue.price[fieldValue] : '';
                                html +=
                                    `<div class="mb-3 mt-3 price-input" id="${priceId}" data-field-name="${field.name}" data-field-value="${fieldValue}" style="${displayStyle}"><label class="form-label">${fieldValue}:  السعر شامل الضريبة ر.س <span class="required" style="color: red!important">*</span></label><input class="form-control price-input-field" type="number" name="fields[${field.name}][price][${fieldValue}]" value="${fieldPrice}"></div>`;
                            });
                        }
                        break;
                    case 'integer':
                        html +=
                            `<input class="form-control" type="number" name="fields[${field.name}][value]" value="${value}">`;
                        break;
                    case 'from-to':
                        var fromValue = '';
                        var toValue = '';
                        if (Array.isArray(value) && value.length === 2) {
                            fromValue = value[0];
                            toValue = value[1];
                        }

                        html +=
                            `<div class="mb-3 row"><div class="col-6"><label class="form-label">من :</label><input class="form-control mb-3" type="number"  name="fields[${field.name}][value][from]" value="${fromValue}"></div> <div class="col-6"><label class="form-label">الي :</label> <input class="form-control" type="number"  name="fields[${field.name}][value][to]" value="${toValue}"></div></div>`;
                        break;
                }
                if (field.depends_on_price_text && field.type !== 'dropdown-list') {
                    if (typeof price === 'object' && price !== null) {
                        var defaultPrice = Object.values(price)[0] || '';
                    } else {
                        var defaultPrice = price;
                    }
                    html +=
                        `<div class="mb-3 mt-3"><label class="form-label"> السعر شامل الضريبة ر.س <span class="required" style="color: red!important">*</span></label><input class="form-control price-input-field" type="number" name="fields[${field.name}][price]" value="${defaultPrice}" required></div>`;
                }
                html += `</div></div></div>`;
                return html;
            }

            // Function to handle Select2 changes and show/hide price inputs
            function handleSelect2Change(selectElement) {
                var selectedValues = selectElement.val() || [];
                var fieldName = selectElement.attr('name').match(/fields\[(.*?)\]/)[1];
                $(`[data-field-name="${fieldName}"]`).each(function() {
                    var value = $(this).data('field-value');
                    if (selectedValues.includes(value)) {
                        $(this).show().find('.price-input-field').attr('required', 'required').attr('min',
                            '1');
                    } else {
                        $(this).hide().find('.price-input-field').removeAttr('required');
                    }
                });
            }

            // Populate fields on category change
            $('#category').change(function() {
                var categoryId = $(this).val();
                populateFields(categoryId, oldFields, existingFields);
            });

            // Populate fields on page load if there's an old category
            var initialCategoryId = $('#category').val();
            if (initialCategoryId) {
                populateFields(initialCategoryId, oldFields, existingFields);
            }

            // Initialize Select2 on document ready for any static select elements
            $('.select2-dropdown').select2().on('change', function() {
                handleSelect2Change($(this));
            });

            // Handle initial selections for price inputs
            $('.select2-dropdown').each(function() {
                handleSelect2Change($(this));
            });

            // Populate values and show prices on page load
            function initializeFields() {
                $('.select2-dropdown').each(function() {
                    var fieldName = $(this).attr('name').match(/fields\[(.*?)\]/)[1];
                    var existingValue = existingFields[fieldName] ? existingFields[fieldName].value : null;
                    if (existingValue) {
                        $(this).val(existingValue).trigger('change');
                    }
                });
            }

            // Call initializeFields on document ready
            initializeFields();
        });
    </script>
@endsection
