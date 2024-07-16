@extends('vendor.layouts.master')
@section('title')
    @lang('translation.order-details')
@endsection
@section('content')
    @include('sweetalert::alert')
    @if ($errors->has('no_packages'))
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-danger">{{ $errors->first('no_packages') }}</div>
            </div>
        </div>
    @endif

    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.orders')
        @endslot
        @slot('title')
            @lang('translation.order_details')
        @endslot
    @endcomponent


    <!--  -->
    @if (session()->has('shipment.should.delivered'))
        <div class="fs-18 alert alert-warning">
            {{ session('shipment.should.delivered') }}
        </div>
    @endif

    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">@lang('translation.order_id') #{{ $row->code }}</h5>
                        <div class="flex-shrink-0">
                            <a href="{{ route('vendor.service_orders.invoice', $row->id) }}" class="btn btn-primary btn-sm">
                                <i class="ri-download-2-fill align-middle me-1"></i>
                                @lang('admin.transaction_invoice.invoice_brif')
                            </a>
                            @if ($row->status == \App\Enums\ServiceOrderStatus::COMPLETED)
                                <a href="{{ route('vendor.service_orders.pdf-invoice', $row->id) }}"
                                    class="btn btn-primary btn-sm" target="_blank">
                                    <i class="ri-download-2-fill align-middle me-1"></i>
                                    @lang('admin.tax-invoices.print')
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap align-middle table-borderless mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col">@lang('translation.service_details')</th>
                                    <th scope="col">@lang('translation.service_price')</th>
                                    <th scope="col">@lang('translation.quantity')</th>
                                    <th scope="col">@lang('translation.reviews')</th>
                                    <th scope="col">@lang('translation.price')</th>
                                    <th scope="col" class="text-end">@lang('translation.total_price')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($row->orderServices as $service)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                    <img src="{{ $service->service->square_image }}" alt=""
                                                        class="img-fluid d-block">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="fs-15"><a
                                                            href="{{ URL::asset('/vendor/services/' . $service->service->id) }}"
                                                            class="link-primary">{{ $service->service->name }}</a></h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $service->unit_price }} @lang('translation.sar')</td>
                                        <td>{{ $service->quantity }}</td>

                                        <td>
                                            <div class="text-warning fs-15">
                                                <?php $avg = round($service->service->reviews()->avg('rate')); ?>
                                                <?php $non_avg = 5 - $avg; ?>
                                                {{-- @for ($i = 0; $i < $avg; $i++) --}}
                                                <i class="ri-star-fill"></i>
                                                {{-- @endfor --}}
                                                @for ($i = 0; $i < $non_avg; $i++)
                                                    <i class="ri-star-line"></i>
                                                @endfor
                                            </div>
                                        </td>
                                        <td class="fw-medium">{{ $service->total }} @lang('translation.sar')</td>
                                        <td class="fw-medium text-end">{{ $service->total }} @lang('translation.sar')</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end card-->
            <div class="card">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">@lang('translation.order_info')</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="profile-timeline">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item border-0">
                                <div class="accordion-header" id="headingOne">
                                    <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse"
                                        href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 avatar-xs">
                                                <div class="avatar-title bg-primary rounded-circle">
                                                    <i class="ri-shopping-bag-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-15 mb-0 fw-semibold">@lang('translation.order_placed') - <span
                                                        class="fw-normal">{{ $row->created_at->toFormattedDateString() }}
                                                        <small
                                                            class="text-muted">{{ $row->created_at->format('g:i A') }}</small></span>
                                                </h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body ms-2 ps-5 pt-0">
                                        <h6 class="mb-1">@lang('translation.an_order_has_been_placed')</h6>
                                        <p class="text-muted">{{ $row->created_at->format('l') }},
                                            {{ $row->created_at->toFormattedDateString() }} -
                                            {{ $row->created_at->format('g:i A') }}</p>


                                    </div>
                                </div>
                            </div>
                            @foreach ($row->steps as $step)
                                <div class="accordion-item border-0">
                                    <div class="accordion-header" id="headingOne">
                                        <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse"
                                            href="#collapseOne{{ $step->id }}" aria-expanded="true"
                                            aria-controls="collapseOne{{ $step->id }}">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-xs">
                                                    <div class="avatar-title bg-primary rounded-circle">
                                                        @if ($step->new_status == \App\Enums\ServiceOrderStatus::CANCELED)
                                                            <i class="ri-close-circle-fill"></i>
                                                        @endif
                                                        @if ($step->new_status == \App\Enums\ServiceOrderStatus::COMPLETED)
                                                            <i class="ri-checkbox-circle-fill"></i>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-15 mb-0 fw-semibold">
                                                        {{ \App\Enums\ServiceOrderStatus::getStatus($step->new_status) }} -
                                                        <span class="fw-normal">
                                                            {{ $row->created_at->format('l') }} ,
                                                            {{ $step->created_at->toFormattedDateString() }}
                                                            <small
                                                                class="text-muted">{{ $step->created_at->format('g:i A') }}</small>
                                                        </span>
                                                    </h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!--end accordion-->
                    </div>
                </div>
            </div>
            <!--end card-->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">@lang('admin.customer_details')</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0 vstack gap-3">
                                <li>
                                    <a href="{{ route('admin.customers.show', ['user' => $row->transaction->customer]) }}"
                                        class="fs-15">
                                        <i class="ri-user-line me-2 align-middle text-muted fs-16"></i>
                                        {{ $row->transaction->customer_name ?? null }}
                                    </a>

                                </li>
                                <li>

                                    {{ str_replace('+966', '', $row->transaction->customer->phone) ?? null }}
                                    <i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i
                                    class="ri-map-pin-line align-middle me-1 text-muted"></i>@lang('admin.address_data')
                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                                <li>@lang('admin.cities.single_title') : {{ $row->transaction?->city?->name }}</li>
                                <li>@lang('admin.cities.service_address') : {{ $row->transaction?->service_address }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">

            <!--end col-->
            <!-- make assign service order request -->
            <div class="">
                <div class="card-header">
                    <div class="d-flex">
                        <h5 class="card-title flex-grow-1 mb-0"><i
                                class="mdi mdi-truck-fast-outline align-middle me-1 text-muted"></i>@lang('vendors.assign-order-services.assign-order-services-request')</h5>
                        <div class="flex-shrink-0">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <form action="{{ route('vendor.service_orders.assign-service-request') }}" method="post"
                            id="">
                            @csrf
                            <input type="hidden" name="order_service_id" value="{{ $row->id }}">
                            <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
                            <div class="form-group">
                                <label for="">@lang('vendors.assign-order-services.employees')</label>
                                <select id="" name="assign_by" class="form-control text-center">
                                    @isset($vendorUsers)
                                        @foreach ($vendorUsers as $item)
                                            <option value="{{ $item->id }}">{{ $item['name'] . ' - ' .'المستوى '. $item->typeOfEmployee?->level . ' - ' .  $item->typeOfEmployee?->name}}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" @if($row->status == 'completed' || $row->status == 'canceled') disabled @endif class="btn btn-sm btn-success w-100 mt-2" value="{{ trans('vendors.assign-order-services.assign') }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end make assign service order request -->
            <div class="">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0"><i
                                    class="mdi mdi-truck-fast-outline align-middle me-1 text-muted"></i> @lang('admin.shipping_info')
                            </h5>
                            <div class="flex-shrink-0">
                                استلام
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                    </div>
                    <div class="card-body">

                        <div class="text-center">
                            @if ($row->checkOrderIsPaid())
                                <form action="{{ route('vendor.service_change_shipping_status') }}" method="post"
                                    id="shipping_status_form">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $row->id }}">
                                    <input type="hidden" name="vendor_id" value="{{ $row->vendor_id }}">
                                    <label for="">@lang('vendors.shipping_info.status')</label>
                                    <select id="orderStatus" name="shipping_status" class="form-control text-center"
                                        @disabled($row->status == 'completed')>
                                        @if ($row->status == 'registered')
                                            <option value="registered" @if ($row->status == 'registered') selected @endif>
                                                @lang('vendors.service_shipping_status.registered')</option>
                                            <option value="processing" @if ($row->status == 'processing') selected @endif>
                                                @lang('vendors.service_shipping_status.processing')</option>
                                        @endif

                                        @if ($row->status == 'processing')
                                            <option value="processing" @if ($row->status == 'processing') selected @endif>
                                                @lang('vendors.service_shipping_status.processing')</option>
                                        @endif

                                        @if ($row->status == 'completed')
                                            <option value="completed" @if ($row->status == 'completed') selected @endif>
                                                @lang('vendors.service_shipping_status.completed')</option>
                                        @endif

                                        @if ($row->status == 'paid')
                                            <option value="paid" @if ($row->status == 'paid') selected @endif>
                                                @lang('vendors.service_shipping_status.paid')</option>
                                        @endif
                                    </select>
                                </form>
                            @else
                                <p><label for="">@lang('vendors.shipping_info.status')</label> : @lang("vendors.service_shipping_status.$row->status")</p>
                            @endif
                        </div>
                    </div>
                    @if ($row->status == 'processing' && $row->status != 'canceled')
                        @if ($row->status == 'processing')
                            <div class="card-footer">
                                <div class="text-center">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalScrollable">@lang('admin.check_otp')</button>
                                </div>

                                <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                    <form class="modal-dialog" role="document" method="post"
                                        action="{{ route('vendor.service_order.check_otp') }}">
                                        @csrf

                                        <input type="hidden" name="order_id" value="{{ $row->id }}" />
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalScrollableTitle">
                                                    @lang('admin.check_otp_to_recieve_order')</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <label for="otp" class="form-label">@lang('admin.otp')</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="otp" class="form-control"
                                                        id="otp" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">@lang('admin.submit')</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                </div>
                @endif
                <!--end card-->
            </div>


            <div class="card mt-5">
                <div class="card-header">
                    <span>ملاحظات</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('vendor.service_order.note', $row->id) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>أكتب ملاحظاتك على طلب</label>
                            <textarea name="note" class="form-control" rows="7" placeholder="أضف ملاحظة على الطلب (ستظهر للإدارة)">{{ $row->orderNote->note }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-success w-100 mt-2">حفظ</button>
                    </form>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->

    <div id="no_packs" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Role is changing to Admin</h4>
                </div>
                <div class="modal-body info">
                    <form class="modal-dialog" role="document" method="post"
                        action="{{ route('vendor.service_order.check_otp') }}">
                        @csrf

                        <input type="hidden" name="order_id" value="{{ $row->id }}" />
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalScrollableTitle">@lang('admin.check_otp_to_recieve_order')</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label for="otp" class="form-label">@lang('admin.otp')</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="otp" class="form-control" id="otp" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">@lang('admin.close')</button>
                                <button type="submit" class="btn btn-primary">@lang('admin.submit')</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer addHEIGHT">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog" id="form-package" role="document">
            <form method="post" action="{{ route('vendor.service_change_shipping_status') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">هل أنت متأكد من تحويل الطلب الي ( جاري
                            تقديم الخدمة )</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <input type="hidden" name="vendor_id" value="{{ $row->vendor_id }}">
                            <input type="hidden" name="order_id" value="{{ $row->id }}">
                            <input type="hidden" name="shipping_status" value="processing" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">@lang('admin.submit')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <script>
        // $( "form-package" ).submit(function( event ) {
        // if ( $( "input:first" ).val() === "javatpoint" ) {
        //     $( "span" ).text( "Submitted Successfully." ).show();
        //     return;
        // }
        // $( "span" ).text( "Not valid!" ).show().fadeOut( 2000 );
        // event.preventDefault();
        // });




        $("#orderStatus").on("change", function() {

            var sOptionVal = $(this).val();
            if (sOptionVal == 'processing') {

                $('#exampleModalScrollable').modal('show');
                $(this).closest('#form-package').submit();
            }

            if (sOptionVal == "1") {
                $("#form-package").append('<input type="hidden" name="is_accepted_shipping" value="1" />');

                $('#exampleModalScrollable').modal('show');
                $(this).closest('#form-package').submit();
            }

        });
    </script>
@endsection
