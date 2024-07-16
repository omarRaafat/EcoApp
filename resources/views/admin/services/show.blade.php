@extends('admin.layouts.master')
@section('title')
    @lang("admin.services.title")
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .cursor:hover {
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
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

                               <div>
                                   <a href="#" class="editRejectNote btn btn-light">
                                    <i class="ri-edit-2-line" ></i>
                                   </a>

                                   <a href="#" class="deleteRejectNote btn btn-light" >
                                    <i class="ri-delete-bin-5-fill fs-16" ></i>
                                   </a>
                               </div>

                            </div>
                            @endif
                            @if(!empty($row?->note->note))
                            <div class="alert alert-danger d-flex justify-content-between align-items-center">
                                <div>
                                    <b> تفاصيل رفض  الموافقة</b>:  <span>{{$row?->note->note}}</span>
                                </div>

                               <div>
                                   <a href="#" class="editRejectNote2 btn btn-light">
                                    <i class="ri-edit-2-line" ></i>
                                   </a>

                                   <a href="#" class="deleteRejectNote2 btn btn-light" >
                                    <i class="ri-delete-bin-5-fill fs-16" ></i>
                                   </a>
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
                                            <div class="vr"></div>
                                            <div class="text-muted">
                                                @lang('admin.services.is_active') :
                                                @if( $row?->status == 'accepted')
                                                    <span class="badge badge-soft-success text-uppercase">
                                                        @lang('admin.services.yes')
                                                    </span>
                                                @else
                                                    <span class="badge badge-soft-danger text-uppercase">
                                                        @lang("admin.services.{$row->status}")
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="d-flex align-items-center gap-2">
                                            @if($row->temp)
                                            <!-- Scrollable modal -->
                                            @if($row->temp->approval == 'pending')
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModalScrollable">@lang('admin.services.follow_edits')</button>
                                            @endif
                                            <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalScrollableTitle">@lang('admin.edits_history')</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- <h6 class="fs-15">@lang('admin.edits_history')</h6> -->
                                                            <div class="live-preview">
                                                                @include('admin.services.updates_accordion')
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger showRejectNote" >@lang('admin.services.reject') <i class="ri-indeterminate-circle-fill"></i></button>
                                                            <form action="{{ route('admin.services.accept-update', ['service' => $row]) }}" method="POST">
                                                                @csrf
                                                                @method('put')
                                                                <button class="btn btn-success" type="submit" title="@lang('admin.services.accepting')">@lang('admin.services.accept_update')
                                                                    <i class="ri-check-double-fill align-bottom"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                            @endif
                                            {{-- <a href="{{ route('admin.services.print-barcode', ['service' => $row]) }}" class="btn btn-info"
                                               data-bs-toggle="tooltip" target="_blank" data-bs-placement="top" title="@lang('admin.services.print-barcode')">
                                               <i class="ri-download-fill align-bottom"></i> @lang('admin.services.print-barcode')
                                            </a> --}}
                                            <a href="{{ route('admin.services.edit', ['service' => $row]) }}" class="btn btn-light"
                                               data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                               <i class="ri-pencil-fill align-bottom"></i>
                                            </a>
                                            <form action="{{ route('admin.services.toggle-status', ['service' => $row]) }}" method="POST">
                                                @csrf
                                                @method('put')
                                                @if($row->status != 'accepted' && empty($row?->note->note))
                                                    <button type="submit" class="btn btn-success" title="@lang('admin.services.accepting')">
                                                        <i class="ri-check-double-fill align-bottom"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btnrejectservice" title="@lang('admin.services.reject')">
                                                        <i class="ri-chat-delete-line  align-bottom"></i>
                                                    </button>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between mt-3">
                                    @if($row->reviews->isNotEmpty())
                                        <div class="text-muted fs-16">
                                            @for($i=0 ;$i < $row->reviews()->avg('rate') ; $i++)
                                                <span class="mdi mdi-star text-warning"></span>
                                            @endfor
                                        </div>
                                    @endif
                                    <div class="text-muted">( {{$row->reviews()->count()}} @lang('translation.customers_rating') )</div>
                                    <div class="text-muted">@lang('admin.services.barcode'): {{ $row->sku }} </div>
                                    <div class="text-muted">@lang('translation.hs_code'): {{ $row->hs_code }} </div>
                                </div> --}}

                                <div class="row mt-4">
                                    {{-- <div class="col-lg-3 col-sm-6">
                                        <div class="p-2 border border-dashed rounded">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <div class="avatar-title rounded bg-transparent text-primary fs-24">
                                                        <i class="ri-money-dollar-circle-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="text-muted mb-1">@lang('translation.price') :</p>
                                                    <h5 class="mb-0">{{number_format($row->price_in_sar, 2)}} @lang('translation.sar')</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <!-- end col -->
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
                                            <div class="tab-pane fade" id="nav-detail" role="tabpanel"
                                                 aria-labelledby="nav-detail-tab">
                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <tbody>
                                                        <tr>
                                                            <th scope="row" style="width: 200px;">
                                                                @lang('translation.total_weight')</th>
                                                            <td>{{$row->total_weight}} @lang('translation.gram')</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">@lang('translation.net_weight')</th>
                                                            <td>{{$row->net_weight}} @lang('translation.gram')</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">@lang('translation.length') </th>
                                                            <td>{{$row->length}} @lang('translation.cm')</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">@lang('translation.width')</th>
                                                            <td>{{$row->width}} @lang('translation.cm')</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">@lang('translation.height')</th>
                                                            <td>{{$row->height}} @lang('translation.cm')</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- service-content -->

                                    {{-- <div class="mt-5">
                                        <div>
                                            <h5 class="fs-14 mb-3">@lang('translation.ratings_and_Reviews')</h5>
                                        </div>
                                        <div class="row gy-4 gx-0">
                                            <div class="col-lg-4">
                                                <div>
                                                    <div class="pb-3">
                                                        <div class="bg-light px-3 py-2 rounded-2 mb-2">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-grow-1">
                                                                    <div class="fs-16 align-middle text-warning">
                                                                        @for($i=0 ;$i < $row->reviews()->avg('rate') ; $i++)
                                                                            <i class="ri-star-fill"></i>
                                                                        @endfor

                                                                    </div>
                                                                </div>
                                                                <div class="flex-shrink-0">
                                                                    <h6 class="mb-0">{{round( $row->reviews()->avg('rate'),1 )}} @lang('translation.out_of') 5</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <div class="text-muted">@lang('translation.total') <span
                                                                    class="fw-medium">{{$reviews_count=$row->reviews()->count()}}</span>@lang('translation.reviews')
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-3">
                                                        <div class="row align-items-center g-2">
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0">5 @lang('translation.stars')</h6>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="p-2">
                                                                    <div class="progress animated-progress progress-sm">
                                                                        <div class="progress-bar bg-primary" role="progressbar"
                                                                             style="width: {{$row->reviews()->where('rate',5)->count()/$row->reviews_count*100}}%" aria-valuenow="50.16"
                                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0 text-muted">{{$row->reviews()->where('rate',5)->count()}}</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end row -->

                                                        <div class="row align-items-center g-2">
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0">4 @lang('translation.stars')</h6>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="p-2">
                                                                    <div class="progress animated-progress progress-sm">
                                                                        <div class="progress-bar bg-success" role="progressbar"
                                                                             style="width: {{$row->reviews()->where('rate',4)->count()/$row->reviews_count*100}}%" aria-valuenow="19.32"
                                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0 text-muted">{{$row->reviews()->where('rate',4)->count()}}</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end row -->

                                                        <div class="row align-items-center g-2">
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0">3 @lang('translation.stars')</h6>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="p-2">
                                                                    <div class="progress animated-progress progress-sm">
                                                                        <div class="progress-bar bg-secondary"
                                                                             role="progressbar" style="width: {{$row->reviews()->where('rate',3)->count()/$row->reviews_count*100}}%"
                                                                             aria-valuenow="18.12" aria-valuemin="0"
                                                                             aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0 text-muted">{{$row->reviews()->where('rate',3)->count()}}</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end row -->

                                                        <div class="row align-items-center g-2">
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0">2 @lang('translation.stars')</h6>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="p-2">
                                                                    <div class="progress animated-progress progress-sm">
                                                                        <div class="progress-bar bg-warning" role="progressbar"
                                                                             style="width: {{$row->reviews()->where('rate',2)->count()/$row->reviews_count*100}}%" aria-valuenow="7.42"
                                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0 text-muted">{{$row->reviews()->where('rate',2)->count()}}</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end row -->

                                                        <div class="row align-items-center g-2">
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0">1 @lang('translation.star')</h6>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="p-2">
                                                                    <div class="progress animated-progress progress-sm">
                                                                        <div class="progress-bar bg-danger" role="progressbar"
                                                                             style="width: {{$row->reviews()->where('rate',1)->count()/$row->reviews_count*100}}%" aria-valuenow="4.98"
                                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0 text-muted">{{$row->reviews()->where('rate',1)->count()}}</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end row -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->

                                            <div class="col-lg-8">
                                                <div class="ps-lg-4">
                                                    <div class="d-flex flex-wrap align-items-start gap-3">
                                                        <h5 class="fs-14">@lang('translation.reviews'): </h5>
                                                    </div>

                                                    <div class="me-lg-n3 pe-lg-4" data-simplebar style="max-height: 225px;">
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach($row->reviews as $review)
                                                                <li class="py-2">
                                                                    <div class="border border-dashed rounded p-3">
                                                                        <div class="d-flex align-items-start mb-3">
                                                                            <div class="hstack gap-3">
                                                                                <div class="badge rounded-pill bg-primary mb-0">
                                                                                    <i class="mdi mdi-star"></i>
                                                                                    {{$review->rate}}
                                                                                </div>
                                                                                <div class="vr"></div>
                                                                                <div class="flex-grow-1">
                                                                                    <p class="text-muted mb-0">
                                                                                        {{$review->comment}}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="d-flex flex-grow-1 gap-2 mb-3">
                                                                            <a href="#" class="d-block">
                                                                                <img src="{{ URL::asset($review->user?->image) }}" alt=""
                                                                                     class="avatar-sm rounded object-cover">
                                                                            </a>
                                                                            <!-- <a href="#" class="d-block">
                                                                        <img src="{{ URL::asset('assets/images/small/img-11.jpg') }}" alt=""
                                                                            class="avatar-sm rounded object-cover">
                                                                    </a>
                                                                    <a href="#" class="d-block">
                                                                        <img src="{{ URL::asset('assets/images/small/img-10.jpg') }}" alt=""
                                                                            class="avatar-sm rounded object-cover">
                                                                    </a> -->
                                                                        </div>

                                                                        <div class="d-flex align-items-end">
                                                                            <div class="flex-grow-1">
                                                                                <h5 class="fs-14 mb-0">{{$review->user?->name}}
                                                                                </h5>
                                                                            </div>

                                                                            <div class="flex-shrink-0">
                                                                                <p class="text-muted fs-13 mb-0">
                                                                                    {{$review->created_at->toFormattedDateString()}}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <!-- end Ratings & Reviews -->
                                    </div> --}}
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
    <!-- Varying modal content -->
    <div class="modal fade" id="varyingcontentModal" tabindex="-1" aria-labelledby="varyingcontentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="varyingcontentModalLabel">@lang('admin.services.reject_reason')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.services.refuse-update', ['service' => $row]) }}" method="POST">
                    <div class="modal-body">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">@lang('admin.services.write_your_reject_reason'): <span style="color:red" >*</span></label>
                                <textarea class="form-control" id="message-text" rows="4" name="note"></textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">@lang('admin.services.reject_confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

         <!-- Start Delete Modal -->
         <div class="modal fade flip" id="deleteRejectNote" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admin.services.refuse-delete', ['service' => $row]) }}" method="POST">
                    <div class="modal-body p-5 text-center">
                        @csrf
                        @method('put')
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                   colors="primary:#25a0e2,secondary:#00bd9d"
                                   style="width:90px;height:90px">
                        </lord-icon>
                        <div class="mt-4 text-center">
                            <h4>@lang('admin.services.delete_reject_reason_modal.title')</h4>
                            <p class="text-muted fs-15 mb-4">@lang('admin.services.delete_reject_reason_modal.description')</p>
                            <div class="hstack gap-2 justify-content-center remove">
                                <button class="btn btn-link link-primary fw-medium text-decoration-none"
                                        data-bs-dismiss="modal" id="deleteRecord-close"><i
                                        class="ri-close-line me-1 align-middle"></i>
                                    {{__('admin.close')}}
                                </button>
                                <button type="submit" class="btn btn-primary" id="delete-record">{{__('admin.delete')}}
                                </button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade flip" id="deleteRejectNote2" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admin.services.refuse-delete2', ['service' => $row]) }}" method="POST">
                    <div class="modal-body p-5 text-center">
                        @csrf
                        @method('put')
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                   colors="primary:#25a0e2,secondary:#00bd9d"
                                   style="width:90px;height:90px">
                        </lord-icon>
                        <div class="mt-4 text-center">
                            <h4>@lang('admin.services.delete_reject_reason_modal.title')</h4>
                            <p class="text-muted fs-15 mb-4">@lang('admin.services.delete_reject_reason_modal.description')</p>
                            <div class="hstack gap-2 justify-content-center remove">
                                <button class="btn btn-link link-primary fw-medium text-decoration-none"
                                        data-bs-dismiss="modal" id="deleteRecord-close"><i
                                        class="ri-close-line me-1 align-middle"></i>
                                    {{__('admin.close')}}
                                </button>
                                <button type="submit" class="btn btn-primary" id="delete-record">{{__('admin.delete')}}
                                </button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Delete Modal -->

    <div class="modal fade" id="editVaryingcontentModal" tabindex="-1" aria-labelledby="varyingcontentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="varyingcontentModalLabel">@lang('admin.services.reject_reason')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.services.refuse-update', ['service' => $row]) }}" method="POST">
                    <div class="modal-body">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">@lang('admin.services.edit_your_reject_reason'): <span style="color:red" >*</span></label>
                                <textarea class="form-control" id="message-text" rows="4" name="note">{{$row?->temp?->note}}</textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">@lang('admin.services.reject_confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editVaryingcontentModal2" tabindex="-1" aria-labelledby="varyingcontentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="varyingcontentModalLabel">@lang('admin.services.reject_reason')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.services.refuse-update2', ['service' => $row]) }}" method="POST">
                    <div class="modal-body">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">@lang('admin.services.edit_your_reject_reason'): <span style="color:red" >*</span></label>
                                <textarea class="form-control" id="message-text" rows="4" name="note">{{$row?->note?->note}}</textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">@lang('admin.services.reject_confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalRejectService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <form action="{{ route('admin.services.reject', ['service' => $row]) }}" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تفاصيل الرفض</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalContent" >
                        <div class="modal-body">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">@lang('admin.services.write_your_reject_reason'): <span style="color:red" >*</span></label>
                                <textarea class="form-control" id="message-text" rows="4" name="note"></textarea>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-danger">@lang('admin.services.reject_confirm')</button>
                </div>
            </div>
        </form>
        </div>
    </div>
@endsection
@section('script')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="{{ URL::asset('assets/libs/swiper/swiper.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/ecommerce-service-details.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.5/JsBarcode.all.min.js"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>

        $(document).ready(function() {
            $(".showRejectNote").on("click", function() {
                $('#exampleModalScrollable').modal('toggle');
                $('#varyingcontentModal').modal('toggle');
            });

            $(".btnrejectservice").on("click", function() {
                $('#modalRejectService').modal('show');
            });


            @if($errors->any())
                $("#add-stock-modal").modal("toggle")
            @endif

            $(".editRejectNote").on("click", function() {

                $('#editVaryingcontentModal').modal('toggle');
            });

            $(".deleteRejectNote").on("click", function() {

              $('#deleteRejectNote').modal('toggle');
          });

          $(".editRejectNote2").on("click", function() {

              $('#editVaryingcontentModal2').modal('toggle');
          });

          $(".deleteRejectNote2").on("click", function() {

            $('#deleteRejectNote2').modal('toggle');
        });
        })
    </script>
@endsection
