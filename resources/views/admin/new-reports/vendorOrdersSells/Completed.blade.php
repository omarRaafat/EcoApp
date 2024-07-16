@extends('layouts.dashapp')
@push('page_title')
    تقارير مبيعات البائع
@endpush

@section('content')
    <div class="container">
        <div class="showdata">
            <div class="row pt-2 pb-2">
                <div class="col-md-6">
                    <div class="title_pagge">
                        <a href="{{ route('vendor.dashboard') }}">الرئيسية</a>
                        <i class="fas fa-chevron-left"></i>
                        <a href=" " class="acitve"> تقارير مبيعات البائع <span class="badge badge-info"> العدد :
                                {{ $earns->total() }}</span></a>
                    </div>
                </div>
            </div>
            <br>
            <div class="text-right">
                <form action=" " method="get">
                    <div class="row">
                        <div class="col-md-2">
                            <label>البائع</label>
                            <select name="vendor_id" class="form-control" required>
                                <option value="" selected disabled>إختر البائع</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}"
                                            @if ($vendor->id == request()->get('vendor_id')) selected @endif>
                                        {{ $vendor->shop_name }}</option>
                                @endforeach
                            </select>
                        </div>
{{--                        <div class="col-md-2">--}}
{{--                            <label>تاريخ الطلب من</label>--}}
{{--                            <input type="date" name="date" class="form-control" value="{{ request()->get('date') }}">--}}
{{--                        </div>--}}
{{--                        <div class="col-md-2">--}}
{{--                            <label> الطلب إلى</label>--}}
{{--                            <input type="date" name="date_to" class="form-control"--}}
{{--                                   value="{{ request()->get('date_to') }}">--}}
{{--                        </div>--}}
                        <div class="col-md-2">
                            <label>تاريخ التسليم من </label>
                            <input type="date" name="completed_date" class="form-control"
                                   value="{{ request()->get('completed_date') }}">
                        </div>
                        <div class="col-md-2">
                            <label> التسليم إلى </label>
                            <input type="date" name="completed_date_to" class="form-control"
                                   value="{{ request()->get('completed_date_to') }}">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-sm btn-success mt-1 ml-1"><i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row text-left">
                        @if (!empty(request()->get('vendor_id')))
                        <div class="col-md-2 text-center">
                            <a href="?action=export_to_excel&vendor_id={{ request()->get('vendor_id') }}&search={{ request()->get('search') }}&date={{ request()->get('date') }}&date_to={{ request()->get('date_to') }}&completed_date={{ request()->get('completed_date') }}&completed_date_to={{ request()->get('completed_date_to') }}"
                                class="btn btn-success mt-4" style="width: 100%">Excel</a>
                         </div>
                        <div class="col-md-2 text-center">
                            <a href="?action=printAll&vendor_id={{ request()->get('vendor_id') }}&page={{ request()->get('page') }}&search={{ request()->get('search') }}&date={{ request()->get('date') }}&date_to={{ request()->get('date_to') }}&completed_date={{ request()->get('completed_date') }}&completed_date_to={{ request()->get('completed_date_to') }}"
                                class="btn btn-success mt-4" style="width: 100%">طباعة</a>
                        </div>

                            @endif
                    </div>

                </form>
                <table id="exampleee" class="display table table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>التاجر</th>
                        <th>رقم الفاتورة الخاص بالتاجر</th>
                        <th>رقم الطلب</th>
                        <th>تاريخ انشاء الطلب</th>
                        <th>تاريخ التسليم</th>

                        <th>قيمة مبيعات التجار غير شاملة VAT</th>
                        <th>قيمة الضريبة (15%)</th>
                        <th>قيمة مبيعات التجار شاملة VAT</th>

                        <th>عمولة المنصة غير شاملة VAT</th>
                        <th>قيمة الضريبة على العمولة (15%)</th>
                        <th>قيمة عمولة المنصة شاملة VAT</th>

                        {{--                            <th> رقم البوليصة </th>--}}
                        {{--                            <th> تاريخ الطلب </th>--}}
                        {{--                            <th> تاريخ التسليم </th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($earns as $earn)
                        <tr>
                            <td class="text-center">{{ $earn->shop_name }}</td>
                            <td class="text-center">
                                <a href="{{ route('dash.orders.show', $earn->globalorder_id) }}"
                                   class="badge badge-success">{{ $earn->vendor_id . $earn->id_rand }}
                                </a>
                            </td>
                            <td class="text-center">{{ $earn->globalorder_id }}</td>
                            <td class="text-center">{{ $earn->order_created_at }}</td>
                            <td class="text-center">{{ $earn->cart_vendor_earns_created_at }}</td>

                            <td class="text-center">
                                {{ number_format($total_without_vat = bcdiv($earn->products_price, 1.15, 4), 2, '.', ',') }}
                                ر.س
                            </td>
                            <td class="text-center">
                                {{ number_format($total_vat = bcmul($total_without_vat, 0.15, 4), 2, '.', ',') }}
                                ر.س
                            </td>
                            <td class="text-center"> {{ number_format(bcadd($total_without_vat, $total_vat,4), 2, '.', ',') }}
                                ر.س
                            </td>

                            <td class="text-center">
                                {{ number_format($commission_without_vat = bcdiv($earn->dash_earn,1.15, 4), 2, '.', ',') }}
                            </td>
                            <td class="text-center">{{ number_format($commission_vat = bcmul($commission_without_vat, 0.15, 4), 2, '.', ',') }}</td>
                            <td class="text-center">{{ number_format(bcadd($commission_without_vat, $commission_vat, 4), 2, '.', ',') }}</td>

{{--                            <td class="text-center">--}}
{{--                                @if (count($earn->cartVendors))--}}
{{--                                    <a--}}
{{--                                        href="https://www.aramex.com/track/results?ShipmentNumber={{ $earn->cartVendors[0]->tracking }}"--}}
{{--                                        class="badge badge-success" target="_blank">--}}
{{--                                        {{ $earn->cartVendors[0]->tracking }}--}}
{{--                                    </a>--}}
{{--                                @endif--}}
{{--                            </td>--}}
{{--                            <td class="text-center">{{ date('Y-m-d, H:i', strtotime($earn->created_at)) }}</td>--}}
{{--                            <td class="text-center">--}}
{{--                                @if (count($earn->cartVendorEarn))--}}
{{--                                    {{ date('Y-m-d, H:i', strtotime($earn->cartVendorEarn[0]->created_at)) }}--}}
{{--                                @else--}}
{{--                                    <p class="badge badge-info">{{ $earn->getStatus() }}</p>--}}
{{--                                @endif--}}
{{--                            </td>--}}
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if (count($earns))
                    {{ $earns->withQueryString()->links('pagination.default') }}
                @endif
                <br>
                <div class="">
                    {{--                    <table class="table table-bordered">--}}
                    {{--                        <thead>--}}
                    {{--                            <th>قيمة المبيعات غير شامل VAT</th>--}}
                    {{--                            <th>قيمة VAT (15%)</th>--}}
                    {{--                            <th>قيمة المبيعات شامل VAT</th>--}}

                    {{--                            <th>عمولة المنصة غير شامل VAT</th>--}}
                    {{--                            <th>قيمة VAT (15%) على عمولة المنصة</th>--}}
                    {{--                            <th>عمولة المنصة شامل VAT</th>--}}

                    {{--                            <th>صافي مستحقات التجار</th>--}}
                    {{--                        </thead>--}}
                    {{--                        <tbody>--}}
                    {{--                            <tr>--}}
                    {{--                                <td class="text-center">--}}
                    {{--                                    {{ number_format($total_without_vat = $earns->sum('products_price') / 1.15, 2, '.', '') }}--}}
                    {{--                                </td>--}}
                    {{--                                <td class="text-center">--}}
                    {{--                                    {{ number_format($earns->sum('products_price') - $total_without_vat, 2, '.', '') }}--}}
                    {{--                                </td>--}}
                    {{--                                <td class="text-center">--}}
                    {{--                                    {{ number_format($earns->sum('products_price'), 2, '.', '') }}</td>--}}
                    {{--                                @php--}}
                    {{--                                    $commission = $total_without_vat * 0.1;--}}
                    {{--                                    $commission_without_vat = $commission / 1.15;--}}
                    {{--                                @endphp--}}
                    {{--                                <td class="text-center">{{ number_format($commission / 1.15, 2, '.', '') }}</td>--}}
                    {{--                                <td class="text-center">--}}
                    {{--                                    {{ number_format($commission - $commission_without_vat, 2, '.', '') }}</td>--}}
                    {{--                                <td class="text-center">{{ number_format($commission, 2, '.', '') }}</td>--}}

                    {{--                                <td class="text-center">{{ number_format($earns->sum('sum_vendor_earns'), 2, '.', '') }}--}}
                    {{--                                </td>--}}
                    {{--                            </tr>--}}
                    {{--                        </tbody>--}}
                    {{--                    </table>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
