<div class="row">
    @php 
    $required = '<span class="required" style="color: red!important">*</span>';
    @endphp
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('translation.categories')</h5>
            </div>
            <div class="card-body">
{{--                <div class="mb-3" >--}}
{{--                    <label class="form-label">--}}
{{--                        @lang('translation.hs_code')--}}
{{--                    </label>--}}
{{--                    {{ Form::text('hs_code', ($row->hs_code ?? old('hs_code')), ['class'=>'form-control','placeholder'=>__('translation.hs_code')]) }}--}}
{{--                    @error('hs_code')--}}
{{--                        <span class="error text-danger"> {{ $message }} </span>--}}
{{--                    @enderror--}}
{{--                </div>--}}
                <div class="mb-3" >
                    <label for="choices-publish-status-input" class="form-label">@lang('translation.main_category')<span class="required" >*</span></label>
                    {{ Form::select('category_id', $main_categories, $row->category_id ?? old('category_id'), ['class'=>'js-example-basic-single form-select','id'=>'main-choices-publish-status-input','onchange'=>'getSubCategories($(this),2)',]) }}
                    @error('category_id')
                        <span class="error text-danger"> {{ $message }} </span>
                    @enderror
                </div>

                <div id="sub-cat" style="margin-top:23px;" class="mb-3">
                    <label for="sub-choices-publish-visibility-input" class="form-label">@lang('translation.sub_category')</label>
                    {{ Form::select('sub_category_id',  ['' => '---']+ $sub_categories, $row->sub_category_id ?? old('sub_category_id'), ['class'=>'js-example-basic-single form-select ','id'=>'sub-choices-publish-status-input','onchange'=>'getSubCategories($(this),3)']) }}
                    @error('sub_category_id')
                        <span class="error text-danger"> {{ $message }} </span>
                    @enderror
                </div>

                <div id="final-cat" style="margin-top: 23px;" class="mb-3">
                    <label for="final-choices-publish-visibility-input" class="form-label">@lang('translation.final_category')</label>
                    {{ Form::select('final_category_id', ['' => '---']+ $final_categories, $row->final_category_id ?? old('final_category_id'), ['class'=>'js-example-basic-single form-select','id'=>'final-choices-publish-status-input']) }}
                    @error('final_category_id')
                        <span class="error text-danger"> {{ $message }} </span>
                    @enderror
                </div>
                {{-- <div class="mb-3">
                    <label for="choices-publish-status-input" class="form-label">@lang('admin.products.vendor') {!! $required !!}</label>
                    {{ Form::select('vendor_id', $vendors, $row->vendor_id ?? old('vendor_id'), ['class'=>'form-select','id'=>'main-choices-input-vendor_id', 'placeholder'=>__('admin.products.vendor'),'data-choices','data-choices-search-true',]) }}
                    @error('vendor_id')
                        <span class="error text-danger"> {{ $message }} </span>
                    @enderror
                </div> --}}
            </div>
            <!-- end card body -->
        </div>

        @foreach(config('app.locales') AS $locale)
        <div class="card card-{{$locale}}">
            <div class="card-body">
                <div class="mb-3">
                    <div class="mb-3">
                        <label class="form-label" for="product-name-inputs">@lang('translation.product_name') {!! $required !!} (@lang('language.'.$locale))</label>
                        <input type="text" class="form-control @error('name.'.$locale) is-invalid @enderror" name="name[{{ $locale }}]"
                        value="{{isset($row) ? $row->getTranslation('name',$locale) : old('name.'.$locale)}}"
                        placeholder="{{__('translation.product_name_plcaholder')}}"
                        id="product-name-inputs">

                        @error('name.'.$locale)
                        <span class="error text-danger" role="alert"> {{ $message }} </span>
                         @enderror
                    </div>
                </div>
                <div>

                    <input type="hidden" name="desc[{{ $locale }}]" id="desc-hiddens_{{$locale}}">
                    <label>@lang('translation.product_desc')-(@lang('language.'.$locale))  {!! $required !!}</label>
                    @error('desc.'.$locale)
                    <span class="error text-danger"> {{ $message }} </span>
                    @enderror
                    <div id="ckeditor-classic_{{$locale}}">
                        @if(isset($row))
                            {!! $row->getTranslation('desc',$locale) !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
          <!-- end card -->
        @endforeach

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('translation.product_gallery')</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h5 class="fs-14 mb-1">@lang('translation.product_image') {!! $required !!}</h5>
                    <p class="text-muted">@lang('translation.add_product_main_image')</p>
                    @error('image')
                        <span class="error text-danger"> {{ $message }} </span>
                    @enderror
                    <p id="main-image-preview-error" class="mt-3 error text-danger" style="display: none"></p>
                    <div class="text-center">
                        <div class="position-relative d-inline-block">
                            <div class="position-absolute top-100 start-100 translate-middle">
                                <label for="product-image-input" class="mb-0"  data-bs-toggle="tooltip" data-bs-placement="right" title="Select Image">
                                    <div class="avatar-xs">
                                        <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                            <i class="ri-image-fill"></i>
                                        </div>
                                    </div>
                                </label>
                                <input class="form-control d-none" value="" id="product-image-input" type="file"
                                    accept="image/png, image/gif, image/jpeg" name="image">
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
                    <h5 class="fs-14 mb-1">@lang('translation.product_gallery')</h5>
                    <p class="text-muted">@lang('translation.add_product_gallery_images')</p>

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
                                            <img data-dz-thumbnail class="img-fluid rounded d-block" src="#" alt="Product-Image" />
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
                                        <button data-dz-remove class="btn btn-sm btn-danger">@lang('translation.delete')</button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <!-- end dropzon-preview -->
                </div>
            </div>
        </div>
        <!-- end card -->
        <div class="text-end mb-3">
            <button type="submit" class="btn btn-success w-sm">@lang('translation.submit')</button>
        </div>
    </div>
    <!-- end col -->

    <div class="col-lg-4">
        <!-- end card -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('translation.sizes')</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-6">
                        <div class="mb-4">
                            <label class="form-label" for="manufacturer-name-input">@lang('translation.total_weight') @lang('translation.gram') {!! $required !!}</label>
                            {{ Form::text('total_weight',$row->total_weight ?? old('total_weight'),['class'=>'form-control','id'=>'total-weight','placeholder'=> __('translation.total_weight_place_holder'),]) }}
                            @error('total_weight')
                                <span class="error text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="mb-2">
                            <label class="form-label" for="manufacturer-name-input">@lang('translation.net_weight') @lang('translation.gram') {!! $required !!}</label>
                            {{ Form::text('net_weight', $row->net_weight ?? old('net_weight'), ['class'=>'form-control','id'=>'net-weight','placeholder'=> __('translation.net_weight_placeholder'),]) }}
                            @error('net_weight')
                                <span class="error text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="manufacturer-name-input">@lang('translation.length') @lang('translation.cm')</label>
                            {{ Form::text('length', $row->length ?? old('length'), ['class'=>'form-control','id'=>'length','placeholder'=> __('translation.length_placeholder')]) }}
                            @error('length')
                                <span class="error text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="manufacturer-name-input">@lang('translation.width') @lang('translation.cm')</label>
                            {{ Form::text('width', $row->width ?? old('width'), ['class'=>'form-control','id'=>'width','placeholder'=> __('translation.width_placeholder')]) }}
                            @error('width')
                                <span class="error text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="manufacturer-name-input">@lang('translation.height') @lang('translation.cm')</label>
                            {{ Form::text('height', $row->height ?? old('height'), ['class'=>'form-control','id'=>'height','placeholder'=> __('translation.height_placeholder')]) }}
                            @error('height')
                                <span class="error text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>

                    <!-- end col -->
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->

        <!-- end card -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('translation.accessable')</h5>
            </div>
            <div class="card-body">
                <div>
                    <label for="choices-publish-visibility-input" class="form-label">@lang('translation.is_active')</label>
                    <input type="hidden" name="is_visible_from"    @if(isset($row)) value="{{$row->is_visible}}" @endif>
                    {{ Form::select('is_visible', ['0' => __('translation.hidden'), '1' => __('translation.visible')], null, ['class'=>'form-select','id'=>'choices-publish-visibility-input','data-choices' ]) }}
                    @error('is_visible')
                        <span class="error text-danger"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
        @if(isset($row) && $row->vendor->is_international == 1)
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('admin.countries_prices.title')</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-sm-4 text-center">
                        <a href="{{ route('vendor.products.prices.create',['id' => $row->id]) }}" class="btn btn-primary">
                            <i class="ri-add-line align-bottom me-1"></i>  @lang('admin.add')
                        </a>
                    </div>
                    <div class="col-lg-8 col-sm-8 text-center">
                        <a href="{{ route('vendor.products.prices.list',['id' => $row->id]) }}"  class="btn btn-primary">
                            <i class="ri-list-check align-bottom me-1"></i>  @lang('admin.countries_prices.list')
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('translation.pricing')</h5>
            </div>
            <div class="card-body">
                @if(!isset($row) && auth()->user()->vendor->is_international == 1)
                <div id="countriesPricesAlert" class="alert alert-warning" style="">@lang('admin.countries_prices.add_edit_alert')</div>
                @endif

                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="product-price-input">@lang('translation.price') @lang('translation.sar') {!! $required !!}</label>
                            <div class="input-group has-validation mb-3">
                                <input type="hidden" name="price_from" value="{{$row->price_in_sar ?? 0}}">
                                <input type="text" step=".01" min="0.01"  oninput="validatePrice(this)" name="price" id="price" value="{{ $row->price_in_sar ?? old('price') }}" placeholder="{{trans('translation.price_placeholder')}}" class="form-control" aria-label="Price" aria-describedby="product-price-addon" required>
                                <div class="invalid-feedback">@lang('translation.price_placeholder')</div>
                            </div>
                            @error('price')
                                <span class="error text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="product-price-input">@lang('translation.price_before_offer') @lang('translation.sar')</label>
                            <div class="input-group has-validation mb-3">
                                <input type="hidden" name="price_before_offer_from" value="{{$row->price_before_offer ?? 0}}">
                                <input type="text" step=".01" min="0.01" oninput="validatePrice(this)"    name="price_before_offer" id="price_before_offer" value="{{ $row->price_before_offer_in_sar ?? old('price_before_offer') }}" placeholder="{{trans('translation.price_before_offer_placeholder')}}" class="form-control" aria-label="Price" aria-describedby="product-price-addon">
                                <div class="invalid-feedback">@lang('translation.price_before_offer_placeholder')</div>
                            </div>
                            @error('price_before_offer')
                                <span class="error text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="col-lg-12 col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="order">@lang('translation.product_order_sort')</label> <span class="required">*</span>
                            {{ Form::number('order', $row->order ?? old('order'), ['class'=>'form-control','id'=>'orders-input','placeholder'=> __('translation.product_order_sort_placeholder'),'aria-label'=>'Price','aria-describedby'=>'product-order-addon',]) }}
                            <div class="invalid-feedback">@lang('translation.product_order_sort_placeholder').</div>
                            @error('order')
                                <span class="error text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div> --}}
                </div>
            </div>
            <!-- end card body -->
        </div>



        <div class="card ">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('translation.quantity')</h5>
            </div>
            <div class="card-body">
                <div>
                    <label for="main-choices-input-type_id" class="form-label">@lang('translation.type')</label>
                    {{ Form::select('type_id', $types, $row->type_id ?? old('type_id'), ['class'=>'form-select','id'=>'main-choices-input-type_id', 'placeholder'=>__('translation.type_placeholder'),'data-choices','data-choices-search-true',]) }}
                    @error('type_id')
                        <span class="error text-danger"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="mb-3" style="margin-top: 10px;">
                    <label for="choices-publish-status-input" class="form-label">@lang('translation.quantity_type') {!! $required !!}</label>
                    {{ Form::select('quantity_type_id', $quantity_types, $row->quantity_type_id ?? old('quantity_type_id'), ['class'=>'form-select','id'=>'main-choices-input-quantity-type_id', 'placeholder'=>__('translation.quantity_type_placeholder'),'data-choices','data-choices-search-true',]) }}
                    @error('quantity_type_id')
                        <span class="error text-danger"> {{ $message }} </span>
                    @enderror
                </div>
                {{-- 
                @if(isset($row))
                <div class="mb-3" style="margin-top: 10px;">
                    <label for="choices-publish-status-input" class="form-label">@lang('translation.stock')</label>
                    {{ Form::number('stock', $row->stock, ['class'=>'form-control','id'=>'stock-input','placeholder'=> __('translation.stock_placeholder'),'aria-label'=>'Stock','aria-describedby'=>'product-stock-addon']) }}
                    @error('stock')
                        <span class="error text-danger"> {{ $message }} </span>
                    @enderror
                </div>
                @endif
                --}}
                
                <div class="mb-3" style="margin-top: 10px;">
                    <label for="choices-publish-status-input" class="form-label">@lang('translation.sku') {!! $required !!} </label>
                    {{ Form::text('sku', $row->sku ?? old('sku'), ['class'=>'form-control','id'=>'sku-input','placeholder'=> __('translation.sku_placeholder'),'aria-label'=>'Stock','aria-describedby'=>'product-sku-addon','required']) }}
                    @error('sku')
                        <span class="error text-danger"> {{ $message }} </span>
                    @enderror
                </div>
                {{--
                <div class="row" style="margin-top:20px">
                    <div class="col-lg-6 col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="product-price-input">@lang('translation.quantity_bill_count')</label>
                            <div class="input-group has-validation mb-3">
                                {{ Form::number('quantity_bill_count', $row->quantity_bill_count ?? old('quantity_bill_count'), ['class'=>'form-control','id'=>'quantity-bill-counts-input','placeholder'=> __('translation.product_quantity_bill_count_sort_placeholder'),'aria-label'=>'Price','aria-describedby'=>'product-quantity-bill-count-addon',]) }}
                                <div class="invalid-feedback">@lang('translation.quantity_bill_count_placeholder')</div>
                            </div>
                            @error('quantity_bill_count')
                                <span class="error text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="product-price-input">@lang('translation.bill_weight') @lang('translation.gram')</label>
                            <div class="input-group has-validation mb-3">
                                {{ Form::number('bill_weight', $row->bill_weight ?? old('bill_weight'), ['class'=>'form-control','id'=>'quantity-bill-counts-input','placeholder'=> __('translation.bill_weight_placeholder'),'aria-label'=>'Price','aria-describedby'=>'product-quantity-bill-count-addon',]) }}
                                <div class="invalid-feedback">@lang('translation.bill_weight_placeholder')</div>
                            </div>
                            @error('bill_weight')
                                <span class="error text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                </div>
                --}}
                <div lass="mb-3 mt-2">
                    <label class="form-label">@lang('translation.clearance_cert')  </label>
                    <input type="file" class="form-control" name="clearance_cert">
                    @error('clearance_cert')
                        <span class="text-danger" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                    @if(isset($row) )
                        @if($row->clearance_cert_media_temp)
                        <a href="{{ $row->clearance_cert_media_temp }}" class="btn btn-sm btn-info"> عرض </a>
                        @elseif($row->clearance_cert_media)
                        <a href="{{ $row->clearance_cert_media }}" class="btn btn-sm btn-info"> عرض </a>
                        @endif
                    @endif 
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
        {{-- <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">@lang('translation.validity')</h5>
            </div>
            <!-- end card body -->
            <div class="card-body">
                <div>
                    <label for="datepicker-publish-input" class="form-label">@lang('translation.product_expire_date') {!! $required !!}</label>
                    {{ Form::date('expire_date', isset($row) ? Carbon\Carbon::parse($row->expire_date)?->format("Y-m-d") : old('expire_date'), ['class'=>'form-control','id'=>'datepicker-publish-input','placeholder'=> __('translation.product_expire_date_placeholder'),'aria-label'=>'Price','data-provider'=>'flatpickr','data-date-format'=>'Y-m-d',]) }}
                    @error('expire_date')
                        <span class="error text-danger"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
        </div> --}}
    </div>
</div>
<!-- end row -->

@section('script-bottom')
<!--select2 cdn-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

<script src="{{ URL::asset('assets/js/pages/select2.init.js') }}"></script>
    <script>
        var validatePrice = function(e) {
            var t = e.value;
            e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
        }

    $(document).ready(function() {
        $("#form-loader").hide()
    })

    function getSubCategories(ele,level)
    {
        if (!ele.val()) return
        $.get('/vendor/get-category-by-parent-id?parent_id='+ele.val()+'&level='+level,(response)=>{
            data = Object.entries(response)
            select_options = '';
            data.forEach(value => select_options += `<option ${value[0] == '' ? 'selected' : ''} value="${value[0]}"> ${value[1]} </option>`)

            if (level===2) {
                $('#sub-choices-publish-status-input').html(select_options)
                $('#sub-choices-publish-status-input').select2();
            }
            if (level===3) {
                $('#final-choices-publish-status-input').html(select_options)
                $('#final-choices-publish-status-input').select2();
            }
            $("#form-loader").hide()
        })
    }

    $("#price").on('change', function(){   // 1st
        if(!isDecimalNumber($(this).val()) || typeof $(this).val() == undefined) {
            var price = $(this).val()
            $(this).val(parseFloat(price).toFixed(2))
        }
    });

    $("#price_before_offer")
    .on('change', function() {   // 1st
        const priceBeforeOffer = $(this).val()
        if(
            (!isDecimalNumber(priceBeforeOffer)) || typeof priceBeforeOffer != undefined &&
            priceBeforeOffer &&
            !isNaN(priceBeforeOffer)
        ) $(this).val(parseFloat(priceBeforeOffer.toFixed(2)))
    });

    // Check if the given number is decimal or not.
    function isDecimalNumber(number)
    {
        return number % 1 != 0 ?? true;
    }

    @if(!isset($row) || $row->vendor->is_international != 1)
        function vendorChange(item)
        {
            let international = $('option:selected', item).attr('data-international');
            if(international == 1)
            {
                $('<div />', {
                    text: '@lang('admin.countries_prices.add_edit_alert')',
                    id:"countriesPricesAlert",
                    class:"alert alert-warning"
                }).hide().fadeIn(1000).insertAfter(item);
            }
            else
            {
                $('#countriesPricesAlert').remove();
            }
        }
    @endif
</script>
@endsection
