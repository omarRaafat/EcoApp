




@extends('vendor.layouts.master')
@section('title')
    @lang('admin.wareHouseRequests.create')
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
                            @lang('admin.wareHouseRequests.create')
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route("vendor.warhouse_request.store") }}" method="post" class="form-steps" autocomplete="on">
                                @csrf
                                @method('post')
                                <div class="text-center pt-3 pb-4 mb-1">
                                    <img src="assets/images/logo-dark.png" alt="" height="17">
                                </div>
                                <div class="tab-content">
                                    <!-- Start Of Arabic Info tab pane -->
                                    <div class="tab-pane fade active show" id="areas-arabic-info" role="tabpanel" aria-labelledby="areas-arabic-info-tab">
                                        <div>

                                        </div>
                                    </div>
                                    <!-- End Of Arabic Info tab pane -->
                                </div><br>
                                <div class="tab-content">
                                    <!-- Start Of Arabic Info tab pane -->
                                    <div class="tab-pane fade active show" id="areas-arabic-info" role="tabpanel" aria-labelledby="areas-arabic-info-tab">
                                        <div>
                                            <div class="row">
                                                <div class="card-body pt-0">
                                                    <div>
                                                        <div class="table-responsive table-card mb-1">
                                                            <table class="table table-nowrap align-middle" id="tableItems">
                                                                <thead class="text-muted table-light">
                                                                    <tr class="text-uppercase">
                                                                        <th>@lang('admin.wareHouseRequests.product')</th>
                                                                        <th>@lang('admin.wareHouseRequests.qnt')</th>
                                                                        <th>@lang('admin.wareHouseRequests.mnfg_date')</th>
                                                                        <th>@lang('admin.wareHouseRequests.expire_date')</th>
                                                                        <th>#</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="list form-check-all"  id="tableBody">
                                                                    <tr id="tableRow">
                                                                        <td colspan="4"></td>
                                                                        <td>
                                                                            <button class="btn btn-primary" type="button" name="addRow" id="addRow">+</button>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
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
                                        @lang('admin.wareHouseRequests.next')
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
        @php
            $oldValues = json_encode(old('requestItems'));
        @endphp
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('assets/js/pages/ecommerce-order.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
<script src="{{ URL::asset('assets/js/jquery-3.6.3.min.js') }}"></script>

    <script>
        function changeVendor(e) {
            window.location = e.value
        }

        var i = 0;

        $("#addRow").click(function() {
            $("#tableBody").append(generateProductRow(i, {}))
            i++
        })

        $(document).ready(function() {
            let validations = []

            @foreach(old('requestItems') ?? [] as $index => $item)
                validations['{{ $index }}'] = {
                    productId: '{{ $item['product_id'] }}',
                    productIdError: '{{ $errors?->first('requestItems.'.$index.'.product_id') }}',
                    productQnt: '{{ $item['qnt'] }}',
                    productQntError: '{{ $errors?->first('requestItems.'.$index.'.qnt') }}',
                    productMnfDate: '{{ $item['mnfg_date'] }}',
                    productMnfDateError: '{{ $errors?->first('requestItems.'.$index.'.mnfg_date') }}',
                    productExpireDate: '{{ $item['expire_date'] }}',
                    productExpireDateError: '{{ $errors?->first('requestItems.'.$index.'.expire_date') }}',
                }
            @endforeach

            validations.forEach((validation, index) => $("#tableBody").append(generateProductRow(index, validation)))
            i = validations.length
        })

        function removeRowTable(id) {
            $("#removeRow" + id).parents('tr').remove();
        }

        function generateProductRow(index, product) {
            return `
                <tr id="tableRow">
                    <td>
                        <select class="select2 form-control" name="requestItems[${index}][product_id]" data-id="select2_product_id">
                            <option selected value="">
                                @lang("admin.wareHouseRequests.choose_product")
                            </option>
                            @foreach ($vendor->products as $product)
                                <option value="{{ $product->id }}" ${product?.productId == "{{ $product->id }}" ? 'selected' : ''}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        ${product?.productIdError ? `<span class="text-danger">${product?.productIdError}</span>` : ''}
                    </td>
                    <td>
                        <input type="number" class="form-control" name="requestItems[${index}][qnt]" placeholder="{{ trans("admin.wareHouseRequests.qnt")}}" value="${product?.productQnt}">
                        ${product?.productQntError ? `<span class="text-danger">${product?.productQntError}</span>` : ''}
                    </td>
                    <td>
                        <input type="date" class="form-control" name="requestItems[${index}][mnfg_date]" value="${product?.productMnfDate}">
                        ${product?.productMnfDateError ? `<span class="text-danger">${product?.productMnfDateError}</span>` : ''}
                    </td>
                    <td>
                        <input type="date" class="form-control" name="requestItems[${index}][expire_date]" value="${product?.productExpireDate}">
                        ${product?.productExpireDateError ? `<span class="text-danger">${product?.productExpireDateError}</span>` : ''}
                    </td>
                    <td>
                        <button class="btn btn-danger" onclick="removeRowTable(${index})" type="button" name="removeRow${index}" id="removeRow${index}">-</button>
                    </td>
                </tr>
            `
        }

    </script>
@endsection
