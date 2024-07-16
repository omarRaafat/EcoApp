<div class="row" style="margin-top : 10px;">
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="vendor_select2_is_active">@lang('Invoice.create.select_vendor')</label>
            <select class="select2 form-control" name="vendor" id="vendor_select2_is_active">
                <option selected disabled value="">
                    @lang('Invoice.create.select_vendor')
                </option>
                @foreach ($vendors as $vendor)
                    <option value="{{$vendor->id}}">
                        {{ $vendor->name }}
                    </option>
                @endforeach
            </select>
            @error('vendor')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-lg-6">
            <div class="mb-3">
                <input type="checkbox" id="all_vendors" name="all_vendors" onchange="updateVendorList(this.checked)">
                <label class="form-label" for="all_vendors">@lang('Invoice.create.all_vendors')</label>
                @error('all_vendors')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top : 10px;">
    <div class="col-lg-6">
        <div class="mb-3">
            <label class="form-label" for="select2_year">@lang('Invoice.create.select_year')</label>
            <select class="select2 form-control" name="year" id="select2_year">
                <option selected disabled value="">
                    @lang('Invoice.create.select_year')
                </option>
                @foreach (range(2020, now()->format("Y")) as $month)
                    <option value="{{$month}}">
                        {{ $month }}
                    </option>
                @endforeach
            </select>
            @error('year')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-6">
        <div class="mb-3">
            <label id="select2_month" class="form-label"
                   for="select2_month">@lang('Invoice.create.select_month')</label>
            <select class="select2 form-control" name="month" id="select2_month">
                <option selected disabled value="">
                    @lang('Invoice.create.select_month')
                </option>
                @foreach (range(1, 12) as $month)
                    <option value="{{$month}}">
                        {{ $month }}
                    </option>
                @endforeach
            </select>
            @error('month')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
