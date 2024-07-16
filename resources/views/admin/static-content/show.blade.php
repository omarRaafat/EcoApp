@extends('admin.layouts.master')
@section('title')
    @lang($translateBase. '.page-title')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            @lang($translateBase. '.show')
                        </h5>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
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
                                                    <h5>@lang($translateBase. '.title_ar')</h5>
                                                    <h4>{{ $model->getTranslation("title", "ar") }}</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <h5>@lang($translateBase. '.title_en')</h5>
                                                    <h4>{{ $model->getTranslation("title", "en") }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <h4>@lang($translateBase. '.paragraph_ar')</h4>
                                                    <h5>{{ $model->getTranslation("paragraph", "ar") }}</h5>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <h4>@lang($translateBase. '.paragraph_en')</h4>
                                                    <h5>{{ $model->getTranslation("paragraph", "en") }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Of Arabic Info tab pane -->
                            </div>
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
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('assets/js/pages/ecommerce-order.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
