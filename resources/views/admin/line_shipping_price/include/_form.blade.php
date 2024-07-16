<div class="tab-content">
    <!-- Start Of Arabic Info tab pane -->
    <div class="tab-pane fade active show" id="areas-arabic-info" role="tabpanel" aria-labelledby="areas-arabic-info-tab">
        <div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">@lang('admin.city_from')</label>
                        <select name="city_id" class="form-select" dir="rtl" data-choices data-choices-removeItem>
                            <option>@lang('translation.select-option')</option>
                            @foreach($cities as $key => $city)
                                <option value="{{ $city->id }}"  @if($city->id == old('city_id' , $line->city_id)) selected @endif>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('city_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">@lang('admin.city_to')</label>
                        <select name="city_to_id" class="form-select" dir="rtl" data-choices data-choices-removeItem>
                            <option>@lang('translation.select-option')</option>
                            @foreach($cities as $key => $city)
                                <option value="{{ $city->id }}"  @if($city->id == old('city_to_id' , $line->city_to_id)) selected @endif>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('city_to_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label" for="dyna">@lang('admin.dyna')</label>
                        <input type="number" name="dyna" class="form-control"
                               value="{{ old("dyna" , $line->dyna)}}"
                               id="dyna"
                               min="0"
                               placeholder="{{ trans('admin.dyna') }}">
                        @error('dyna')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label" for="dyna">@lang('admin.lorry')</label>
                        <input type="number" name="lorry" class="form-control"
                               value="{{ old("lorry" , $line->lorry)}}"
                               id="lorry"
                               min="0"
                               placeholder="{{ trans('admin.lorry') }}">
                        @error('lorry')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label" for="dyna">@lang('admin.truck')</label>
                        <input type="number" name="truck" class="form-control"
                               value="{{ old("truck" , $line->truck) }}"
                               id="truck"
                               min="0"
                               placeholder="{{ trans('admin.truck') }}">
                        @error('truck')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- End Of Arabic Info tab pane -->
</div>
