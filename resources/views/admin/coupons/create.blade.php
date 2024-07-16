@extends('admin.layouts.master')
@section('title')
    @lang('admin.coupons.create')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"/>
    <style>
        #select2-couponProductsSelect-container    {
            display: flex;
            flex-wrap: wrap;
        }
        #select2-couponProductsSelect-container li button{
            position: relative;
        }
        #select2-couponProductsSelect-container li {
                position: relative;
                width: fit-content;
                display: flex;
                align-items: center;
                gap: 10px;
                margin-right: unset;
                flex-direction: row-reverse;
        }
        .select2-selection__choice__display{
            display: block;
        }
    </style>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            @lang('admin.coupons.create')
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.coupons.store') }}" method="post" class="form-steps" autocomplete="on">
                                @csrf
                                @method('post')
                                <div class="tab-content">
                                    <!-- Start Of Arabic Info tab pane -->
                                    <div class="tab-pane fade active show" id="coupons-arabic-info" role="tabpanel" aria-labelledby="coupons-arabic-info-tab">
                                        <div>
                                            @include('admin.coupons.form')
                                        </div>
                                        <!-- End Of Arabic Info tab pane -->
                                    </div>
                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <button type="submit" class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                            <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                            @lang('admin.create')
                                        </button>
                                    </div>
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
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
@endsection
@section('script-bottom')
    <script>
        function handle_coupon_type(item)
        {
            let type = $(item).val();
            if(type == "vendor")
            {
                $('#couponVendors').fadeIn('slow');
                $('#couponProducts').fadeOut('slow');

            }
            else if (type == "product")
            {
                $('#couponProducts').fadeIn('slow');
                $('#couponVendors').fadeOut('slow');
            }
            else
            {
                $('#couponProducts').fadeOut('slow');
                $('#couponVendors').fadeOut('slow');
            }
        }

        $(document).ready(function ()
        {
            $('#couponProductsSelect').select2({
                ajax: {
                    url: function (params)
                    {
                        return "{{ URL::asset('/admin') }}/coupons/products/" + params.term;
                    },
                    data: function (params)
                    {
                        return {};
                    },
                    dataType: 'json'
                }
            });
            $('#select2_discount_type').on("change", function(e) {
                if (e.target.value == "{{ \App\Enums\CouponDiscountType::PERCENTAGE }}") {
                    $(".percentage-fields").show()
                } else {
                    $(".percentage-fields").hide()
                }
            })
        });
    </script>
@endsection
