@extends('vendor.layouts.master')
@section('title')
    @lang('translation.product-Details')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1')
    @lang('translation.app_name')
@endslot
@slot('title')
    @lang('translation.product_details')
@endslot
@endcomponent
@if(session()->has('success'))
    <div class="alert alert-success">
        <h3> {{ session('success') }} </h3>
    </div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row gx-lg-5">
                    <div class="col-xl-4 col-md-8 mx-auto">
                        <div class="service-img-slider sticky-side-div">
                            <div class="swiper service-thumbnail-slider p-2 rounded bg-light">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        @if($row->square_image_temp && $row->square_image_temp != $row->square_image)
                                            <img src="{{ $row->square_image_temp }}" alt="" class="img-fluid d-block" />
                                        @else
                                        <img src="{{ $row->square_image }}" alt="" class="img-fluid d-block" />
                                        @endif
                                    </div>
                                    @foreach($row->images->where('is_accept',1) as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ $image->square_image }}" alt="" class="img-fluid d-block" />
                                        </div>
                                    @endforeach

                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                            <!-- end swiper thumbnail slide -->
                            <div class="swiper service-nav-slider mt-2">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="nav-slide-item ">
                                            @if($row->square_image_temp && $row->square_image_temp != $row->square_image)
                                            <img src="{{ $row->square_image_temp }}" alt="" class="img-fluid d-block" />
                                            @else
                                            <img src="{{ $row->square_image }}" alt="" class="img-fluid d-block" />
                                            @endif
                                        </div>
                                    </div>

                                    @foreach($row->images->where('is_accept',($row->status=='pending' ? 0 : 1 )) as $image)
                                        <div class="swiper-slide">
                                            <div class="nav-slide-item ">
                                                <img src="{{ $image->square_image }}" alt=""
                                                     class="img-fluid d-block" />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- end swiper nav slide -->
                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-8">
                        @if($row?->temp?->approval == 'refused')
                        <div class="alert alert-danger d-flex justify-content-between align-items-center">
                            <div>
                                <b> تفاصيل رفض  التعديل</b>:  <span>{{$row->temp->note}}</span>
                            </div>

                        </div>
                        @endif
                        @if(!empty($row?->note->note))
                        <div class="alert alert-danger d-flex justify-content-between align-items-center">
                            <div>
                                <b> تفاصيل رفض  الموافقة</b>:  <span>{{$row?->note->note}}</span>
                            </div>
                        </div>
                        @endif
                        <div class="mt-xl-0 mt-5">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <div class="hstack gap-3 flex-wrap">
                                        <div><a href="#" class="text-primary d-block">{{$row->vendor?->name}}</a></div>
                                        <div class="vr"></div>
                                        <div class="text-muted">@lang('translation.seller') :
                                            <span class="text-body fw-medium">
                                                {{ $row->vendor?->owner?->name }}
                                            </span>
                                        </div>
                                        <div class="vr"></div>
                                        <div class="text-muted">@lang('translation.published_date') : <span class="text-body fw-medium">{{$row->created_at?->toFormattedDateString()}}</span>
                                        </div>

                                        <a href="{{ route('vendor.services.edit', ['service' => $row]) }}" class="btn btn-light"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                            <i class="ri-pencil-fill align-bottom"></i>
                                         </a>
                                    </div>
                                </div>

                            </div>

                            <div class="row mt-4">
                                <div class="col-lg-3 col-sm-6">
                                    <div class="p-2 border border-dashed rounded">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="avatar-title rounded bg-transparent text-primary fs-24">
                                                    <i class="ri-file-copy-2-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">@lang('translation.no_orders') :</p>
                                                <h5 class="mb-0">{{ $row->orderServices->count() }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- end col -->
                                <div class="col-lg-3 col-sm-6">
                                    <div class="p-2 border border-dashed rounded">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="avatar-title rounded bg-transparent text-primary fs-24">
                                                    <i class="ri-inbox-archive-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">@lang('translation.total_revenue') :</p>
                                                <h5 class="mb-0">{{ $row->orderServices->sum('totalInSar') }} @lang('translation.sar')</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>


                            <div class="row">
                                @foreach(config('app.locales') AS $locale)
                                <div class="card-body border-end">
                                    <b>@lang("translation.service_name")-@lang('language.'.$locale) :</b> {{ $row->getTranslation('name', $locale)}}
                                </div>

                                 <div class="card-body border-end">
                                    <b>@lang("translation.service_desc")-@lang('language.'.$locale) :</b> {!! $row->getTranslation('desc',$locale) !!}
                                </div>

                                <div class="card-body border-end">
                                    <b>@lang("translation.service_conditions")-@lang('language.'.$locale) :</b> {!! $row->getTranslation('conditions',$locale) !!}
                                </div>

                                <div class="card-body border-end">
                                    <b>@lang("translation.service_cities") :</b><br>
                                    @foreach ($row->cities as $city)
                                        <span class="btn btn-primary btn-sm">{{ $city->name }}</span>
                                    @endforeach
                                </div>

                                <br>
                                <hr>

                                @endforeach
                            </div>

                            <div class="service-content mt-5">
                                <nav>
                                    <ul class="nav nav-tabs nav-tabs-custom nav-primary" id="nav-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="nav-speci-tab" data-bs-toggle="tab"
                                               href="#nav-speci" role="tab" aria-controls="nav-speci"
                                               aria-selected="true">@lang('translation.service_details') :</a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab"
                                                href="#nav-detail" role="tab" aria-controls="nav-detail"
                                                aria-selected="false">@lang('translation.sizes')</a>
                                        </li> -->
                                    </ul>
                                </nav>
                                <div class="tab-content border border-top-0 p-4" id="nav-tabContent" style="height:328px">
                                    <div class="tab-pane fade show active" id="nav-speci" role="tabpanel"
                                         aria-labelledby="nav-speci-tab">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <tbody>
                                                        <tr>
                                                            <th scope="row" style="width: 200px;">
                                                                @lang('translation.categroy')</th>
                                                            <td>{{$row->category?->name}}</td>
                                                        </tr>
                                                        @foreach ($row->fields as $field)
                                                        <tr>
                                                            <th scope="row" style="width: 200px;">
                                                                {{ $field->field_name }}</th>
                                                            <td>{{ $field->field_value }}</td>
                                                            <td>{{ $field->field_price ?? 0 }} ر.س</td>
                                                        </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- service-content -->
                                <!-- end card body -->
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
    </div>
</div>


@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/swiper/swiper.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/ecommerce-product-details.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

@endsection
