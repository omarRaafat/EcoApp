@extends('admin.layouts.master')
@section('title')
    @lang('admin.dispensingOrder.title')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="wallets">

                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.dispensingOrder.dispensingOrderFilter')</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="get" action="{{ route("admin.dispensingOrder.index")  }}">
                        <div class="row g-3">
                            <div class="col-xxl-3 col-sm-4">
                                <div class="search-box">
                                    <input type="text" name="vendor" class="form-control search" value="{{ request()->get('vendor') }}"
                                           placeholder="@lang("admin.dispensingOrder.vendor_name_and_user")">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <input value="{{ request('from') }}" name="from" type="text" class="form-control flatpickr-input active" data-provider="flatpickr"  data-maxDate="today" data-date-format="Y-m-d" placeholder="@lang('admin.from')">
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <input value="{{ request('to') }}" name="to" type="text" class="form-control flatpickr-input active" data-provider="flatpickr"  data-maxDate="today" data-date-format="Y-m-d" placeholder="@lang('admin.to')">
                                </div>
                            </div>

                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i> تصفية
                                    </button>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <a href="{{route('admin.dispensingOrder.index')}}" type="reset" class="btn btn-secondary w-100"> <i class=" ri-loader-3-line me-1 align-bottom"></i>
                                        @lang('translation.reset')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form action="{{ route('admin.dispensingOrder.store')  }}" method="post">
                        @csrf
                        <input type="hidden" name="vendor" value="{{ $request->vendor  }}"/>
                        <input type="hidden" name="from" value="{{ $request->from  }}"/>
                        <input type="hidden" name="to" value="{{ $request->to  }}"/>
                        <div class="col-md-3 float-right">
                            <button class="btn btn-secondary action-button" type="submit">
                                أمر الصرف
                            </button>
                        </div>
                    </form>
                </div>


                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body ">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="walletsTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
{{--                                    <th>@lang('admin.vendorWallets.id')</th>--}}
                                    <th>@lang('admin.vendorWallets.vendor_name_ar')</th>
                                    {{-- <th>@lang('admin.vendorWallets.vendor_name_en')</th> --}}
                                    <th>@lang('admin.vendorWallets.user_vendor_name')</th>
                                    <th>@lang('admin.dispensingOrder.amount')</th>
{{--                                    <th>@lang('admin.vendorWallets.last_update')</th>--}}
{{--                                    <th>@lang('translation.actions')</th>--}}
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach($orders as $order)
                                    <tr>
{{--                                        <td class="id">--}}
{{--                                            <a href="{{ route("admin.wallets.show", $wallet->id) }}"class="fw-medium link-primary">--}}
{{--                                                #{{$wallet->id}}--}}
{{--                                            </a>--}}
{{--                                        </td>--}}
                                        <td class="admin_id">{{ $order->vendor?->getTranslation('name' ,'ar') }}</td>
                                        {{-- <td class="admin_id">{{ $wallet->vendor?->getTranslation('name' ,'en') }}</td> --}}
                                        <td class="customer_id">{{ $order->vendor?->owner?->name }}</td>
                                        <td class="amount">{{ $order->total_amount  . ' ' . __('translation.sar') }}</td>
{{--                                        <td class="date">{{ $wallet->updated_at?->diffForHumans()}}</td>--}}
{{--                                        <td>--}}
{{--                                            <ul class="list-inline hstack gap-2 mb-0">--}}
{{--                                                <li class="list-inline-item" data-bs-toggle="tooltip"--}}
{{--                                                    data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.vendorWallets.manage')">--}}
{{--                                                    <a href="{{ route("admin.dispensingOrder.show", $order->id) }}"--}}
{{--                                                       class="text-primary d-inline-block">--}}
{{--                                                        <i class="ri-eye-fill fs-16"></i>--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                            </ul>--}}
{{--                                        </td>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                               colors="primary:#25a0e2,secondary:#0ab39c"
                                               style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">@lang('admin.vendorWallets.no_result_found')</h5>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{ $orders->appends(request()->query())->links("pagination::bootstrap-4") }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
