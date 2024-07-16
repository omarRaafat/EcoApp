@extends('vendor.layouts.master')
@section('title')
    @lang('translation.order-details')
@endsection
@section('content')
    @include('sweetalert::alert')
    @if($errors->has('no_packages'))
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
    @if(session()->has('shipment.should.delivered'))
        <div class="fs-18 alert alert-warning">
            {{session('shipment.should.delivered')}}
        </div>
    @endif
    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">@lang('translation.order_id') #{{$row->code}}</h5>
                        <div class="flex-shrink-0">
                            <a href="{{ route("vendor.orders.invoice", $row->id) }}" class="btn btn-primary btn-sm">
                                <i class="ri-download-2-fill align-middle me-1"></i>
                                @lang('admin.transaction_invoice.invoice_brif')
                            </a>
                            @if (
                                    $row->status == \App\Enums\OrderStatus::COMPLETED ||
                                    $row->status == \App\Enums\OrderStatus::SHIPPING_DONE ||
                                    $row->status == \App\Enums\OrderStatus::REFUND
                                )
                                <a href="{{ route("vendor.orders.pdf-invoice", $row->id) }}" class="btn btn-primary btn-sm" target="_blank">
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
                                <th scope="col">@lang('translation.product_details')</th>
                                <th scope="col">@lang('translation.product_price')</th>
                                <th scope="col">@lang('translation.quantity')</th>
                                <th scope="col">@lang('translation.reviews')</th>
                                <th scope="col" >@lang('translation.price')</th>
                                <th scope="col" class="text-end">@lang('translation.total_price')</th>
                                <th>@lang('translation.warehouse')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($row->orderProducts as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                <img src="{{ $product->product->square_image }}" alt=""
                                                     class="img-fluid d-block">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="fs-15"><a href="{{URL::asset('/vendor/products/'.$product->product->id)}}"
                                                                     class="link-primary">{{$product->product->name}}</a></h5>
                                                <p class="text-muted mb-0">@lang('translation.quantity_type'): <span class="fw-medium">{{$product->$product?->quantity_type?->name}}</span>
                                                </p>
                                                <p class="text-muted mb-0">@lang('translation.type'): <span class="fw-medium">{{$product->product->type?->name}}</span></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $product->unit_price }} @lang('translation.sar')</td>
                                    <td>{{ $product->quantity }}</td>

                                    <td>
                                        <div class="text-warning fs-15">
                                                <?php $avg = round($product->product->reviews()->avg('rate')); ?>
                                                <?php $non_avg = 5 - $avg; ?>
                                        {{--@for($i= 0; $i < $avg ; $i++)--}}
                                                <i class="ri-star-fill"></i>
                                            {{--@endfor--}}
                                            @for($i= 0; $i < $non_avg ; $i++)
                                                <i class="ri-star-line"></i>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="fw-medium">{{ $product->total }} @lang('translation.sar')</td>
                                    <td class="fw-medium text-end">{{ $product->total + $row->orderVendorShippings()->sum('total_shipping_fees') }} @lang('translation.sar')</td>
                                    {{--
                                    <td class="fw-medium">{{ $row->total }} @lang('translation.sar')</td>
                                    <td class="fw-medium text-end">{{ $row->total + $row->orderVendorShippings()->sum('total_shipping_fees') }} @lang('translation.sar')</td>
                                    --}}
                                    <td>
                                        @php
                                            $warehouse = \App\Models\Warehouse::find($row->orderVendorShippingWarehouses()->where('product_id',$product->product_id)->first()?->warehouse_id);
                                        @endphp
                                        @if($warehouse)
                                        {{ $warehouse->getTranslation('name', 'ar') }}
                                        @endif
                                    </td>

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
                        @if($row->orderShip && $orderVendorShipping?->shipping_type_id == 2)
                            <h5 class="card-title flex-grow-1 mb-0">@lang('translation.track_id') : {{ $row->orderShip->gateway_tracking_id ?? null  }}</h5>
                        @else
                            <h5 class="card-title flex-grow-1 mb-0">@lang('translation.order_info')</h5>
                        @endif

                        @if($orderVendorShipping->status == 'processing' || $orderVendorShipping->status == 'completed' || $orderVendorShipping->status == 'in_shipping' || $orderVendorShipping->status == 'refund')
                            @if($orderVendorShipping?->shipping_type_id == 2 &&  $row?->orderShip?->gateway_tracking_url)
                                {{-- SPL--}}
                                @if($orderVendorShipping->shipping_method_id == 2)
                                <div class="flex-shrink-0 mt-2 mt-sm-0">
                                    <a href="{{ $row?->orderShip?->gateway_tracking_url  }}"  target="_blank" class="btn btn-soft-primary btn-sm mt-2 mt-sm-0"> @lang('translation.polica')</a>
                                 </div>

                                        <div class="flex-shrink-0 mt-8 mt-sm-0">
                                            <a href="{{ env('SPL_TRACKING_URL'). $row?->orderShip?->gateway_tracking_id }}" target="_blank" class="btn btn-soft-primary btn-sm mt-2 mt-sm-0"><i
                                                    class="ri-map-pin-line align-middle me-1"></i> @lang('translation.track_order')
                                            </a>
                                        </div>
                                @elseif($orderVendorShipping->shipping_method_id == 1)
                                    <a href="{{ route('vendor.orders.PrintLabel',$row?->orderShip?->gateway_tracking_id) }}"
                                        target="_blank" class="btn btn-soft-primary btn-sm mt-2 mt-sm-0">
                                        @lang('translation.polica')</a>


                                        <div class="flex-shrink-0 mt-8 mt-sm-0">
                                            <a href="{{ env('ARAMEX_TRACKING_URL'). $row?->orderShip?->gateway_tracking_id  }}" target="_blank" class="btn btn-soft-primary btn-sm mt-2 mt-sm-0"><i
                                                    class="ri-map-pin-line align-middle me-1"></i> @lang('translation.track_order')</a>
                                        </div>
                                @endif

                             @endif
                        @endif
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
                                                        class="fw-normal">{{$row->created_at->toFormattedDateString() }} <small class="text-muted">{{$row->created_at->format('g:i A')}}</small></span></h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body ms-2 ps-5 pt-0">
                                        <h6 class="mb-1">@lang('translation.an_order_has_been_placed')</h6>
                                        <p class="text-muted">{{$row->created_at->format('l') }}, {{$row->created_at->toFormattedDateString() }} - {{$row->created_at->format('g:i A')}}</p>


                                    </div>
                                </div>
                            </div>
                            @foreach($row->steps as $step)
                                <div class="accordion-item border-0">
                                    <div class="accordion-header" id="headingOne">
                                        <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse"
                                           href="#collapseOne{{$step->id}}" aria-expanded="true" aria-controls="collapseOne{{$step->id}}">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-xs">
                                                    <div class="avatar-title bg-primary rounded-circle">
                                                        @if($step->new_status == \App\Enums\OrderStatus::SHIPPING_DONE)
                                                            <i class="mdi mdi-package-variant"></i>
                                                        @endif
                                                        @if($step->new_status == \App\Enums\OrderStatus::IN_DELEVERY)
                                                            <i class="ri-takeaway-fill"></i>
                                                        @endif
                                                        @if($step->new_status == \App\Enums\OrderStatus::CANCELED)
                                                            <i class="ri-close-circle-fill"></i>
                                                        @endif
                                                        @if($step->new_status == \App\Enums\OrderStatus::COMPLETED)
                                                            <i class="ri-checkbox-circle-fill"></i>
                                                        @endif
                                                        @if($step->new_status == \App\Enums\OrderStatus::REFUND)
                                                            <i class=" ri-refund-2-line"></i>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-15 mb-0 fw-semibold">
                                                        {{ \App\Enums\OrderStatus::getStatus($step->new_status) }} -
                                                        <span class="fw-normal">
                                                        {{$row->created_at->format('l') }} , {{$step->created_at->toFormattedDateString() }}
                                                        <small class="text-muted">{{$step->created_at->format('g:i A')}}</small>
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
        </div>
        <div class="col-xl-3">
            @if($orderVendorShipping?->shipping_type_id == 1)
            <!--end col-->
            <div class="">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0"><i class="mdi mdi-truck-fast-outline align-middle me-1 text-muted"></i> @lang("admin.shipping_info")</h5>
                            <div class="flex-shrink-0">
                                {{$orderVendorShipping->shippingType->title}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                </div>
                <div class="card-body">

                    <div class="text-center">
                        @if($orderVendorShipping->order->checkOrderIsPaid())
                        <form action="{{route('vendor.change_shipping_status')}}" method="post" id="shipping_status_form">
                            @csrf
                            <input type="hidden" name="order_vendor_shipping_id" value="{{$orderVendorShipping->id}}">
                            <input type="hidden" name="shipping_type_id" value="{{$orderVendorShipping->shipping_type_id}}">
                            <input type="hidden" name="vendor_id" value="{{$orderVendorShipping->vendor_id}}">
                            <label for="">@lang("vendors.shipping_info.status")</label>
                            <select id="orderStatus" name="shipping_status" class="form-control text-center" @disabled($orderVendorShipping->status == 'completed')>
                                @if($orderVendorShipping->status == 'registered')
                                    <option value="registered" @if($orderVendorShipping->status == 'registered') selected @endif>@lang('vendors.shipping_status.registered')</option>
                                    <option value="processing" @if($orderVendorShipping->status == 'processing') selected @endif>@lang('vendors.shipping_status.processing')</option>
                                @endif

                                @if($orderVendorShipping->status == 'processing')
                                <option value="processing" @if($orderVendorShipping->status == 'processing') selected @endif>@lang('vendors.shipping_status.processing')</option>
                                @endif

                                @if($orderVendorShipping->status == 'in_delivery')
                                    <option value="in_delivery" @if($orderVendorShipping->status == 'in_delivery') selected @endif>@lang('vendors.shipping_status.in_delivery')</option>
                                @endif

                                @if($orderVendorShipping->status == 'completed')
                                <option value="completed" @if($orderVendorShipping->status == 'completed') selected @endif>@lang('vendors.shipping_status.completed')</option>
                                @endif

                                @if($orderVendorShipping->status == 'paid')
                                <option value="paid" @if($orderVendorShipping->status == 'paid') selected @endif>@lang('vendors.shipping_status.paid')</option>
                                @endif
                            </select>
                        </form>
                        @else
                        <p><label for="">@lang("vendors.shipping_info.status")</label> : @lang("vendors.shipping_status.$orderVendorShipping->status")</p>

                        @endif
                    </div>
                </div>
                @if($orderVendorShipping->status == 'processing' && $row->status != 'canceled')
                    <div class="card-footer">
                        <div class="text-center">
                            @if($orderVendorShipping->order->checkOrderIsPaid())
                            <form action="{{route('vendor.change_shipping_status')}}" method="post" id="shipping_status_form">
                                @csrf
                                <input type="hidden" name="order_vendor_shipping_id" value="{{$orderVendorShipping->id}}">
                                <input type="hidden" name="shipping_type_id" value="{{$orderVendorShipping->shipping_type_id}}">
                                <input type="hidden" name="vendor_id" value="{{$orderVendorShipping->vendor_id}}">
                                <label for="">@lang("vendors.shipping_info.status")</label>
                                <select id="orderStatus" name="shipping_status" class="form-control text-center" @disabled($orderVendorShipping->status == 'completed')>
                                    @if($orderVendorShipping->status == 'registered')
                                        <option value="registered" @if($orderVendorShipping->status == 'registered') selected @endif>@lang('vendors.shipping_status.registered')</option>
                                        <option value="processing" @if($orderVendorShipping->status == 'processing') selected @endif>@lang('vendors.shipping_status.processing')</option>
                                    @endif

                                    @if($orderVendorShipping->status == 'processing')
                                    <option value="processing" @if($orderVendorShipping->status == 'processing') selected @endif>@lang('vendors.shipping_status.processing')</option>
                                    @endif

                                    @if($orderVendorShipping->status == 'in_delivery')
                                        <option value="in_delivery" @if($orderVendorShipping->status == 'in_delivery') selected @endif>@lang('vendors.shipping_status.in_delivery')</option>
                                    @endif

                                    @if($orderVendorShipping->status == 'completed')
                                    <option value="completed" @if($orderVendorShipping->status == 'completed') selected @endif>@lang('vendors.shipping_status.completed')</option>
                                    @endif

                                    @if($orderVendorShipping->status == 'paid')
                                    <option value="paid" @if($orderVendorShipping->status == 'paid') selected @endif>@lang('vendors.shipping_status.paid')</option>
                                    @endif

                                    @if($orderVendorShipping->status == 'canceled')
                                    <option value="canceled" @if($orderVendorShipping->status == 'canceled') selected @endif>@lang('vendors.shipping_status.canceled')</option>
                                    @endif
                                </select>
                            </form>

                            @if(in_array($orderVendorShipping->status,['registered','processing','paid']))
                            <div class="mt-5">
                                @foreach ($orderVendorShipping->orderVendorWarehouses as $orderVendorWarehouse)
                                <span class="d-block border pt-2 pb-2 border-info">
                                    {{$orderVendorWarehouse->warehouse->getTranslation('name','ar')}} &nbsp;
                                    <a href="{{ route('vendor.orders.resend_receive_code',$orderVendorWarehouse->id) }}" class="btn btn-sm btn-warning" title="إعادة إرسال الرمز">
                                        <i data-feather="refresh-cw" style="width: 13px;height: 13px;"></i>  إعادة إرسال الرمز
                                    </a>
                                </span>
                                @endforeach
                            </div>
                            @endif

                        @else
                            <p><label for="">@lang("vendors.shipping_info.status")</label> : @lang("vendors.shipping_status.$orderVendorShipping->status")</p>
                            @endif
                        </div>
                    </div>
                    @if($orderVendorShipping->status == 'processing')
                        <div class="card-footer">
                            <div class="text-center">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalScrollable">@lang('admin.check_otp')</button>
                            </div>

                            <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                    <form class="modal-dialog" role="document" method="post" action="{{ route('vendor.order.check_otp')  }}">
                                        @csrf

                                        <input type="hidden" name="order_id" value="{{ $row->id  }}" />
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalScrollableTitle">@lang('admin.check_otp_to_recieve_order')</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <label for="otp" class="form-label">@lang('admin.otp')</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="otp" class="form-control" id="otp" required>
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
            @else
            <!--end col-->
            <div class="">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0"><i
                                    class="mdi mdi-truck-fast-outline align-middle me-1 text-muted"></i> @lang("admin.shipping_info")</h5>
                                    <div class="flex-shrink-0">
                                        {{$orderVendorShipping->shippingType->title}}
                                    </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="text-center">
                            <lord-icon src="https://cdn.lordicon.com/uetqnvvg.json" trigger="loop" colors="primary:#25a0e2,secondary:#00bd9d" style="width:80px;height:80px"></lord-icon>
                            <h5 class="fs-16 mt-2">@lang("vendors.shipping_info.title")</h5>
                            <p class="text-muted mb-0">@lang("vendors.shipping_info.shipping_method"): {{ $orderVendorShipping->shippingMethod->name}}</p>
                            <p class="text-muted mb-0">@lang("المدينة"): {{ $row->transaction->city->name }}</p>

                            <p class="text-muted mb-0">@lang("vendors.shipping_info.total_weight"): {{ $orderVendorShipping->total_weight }}</p>
                            <p class="text-muted mb-0">@lang("vendors.shipping_info.base_shipping_fees"): {{ $orderVendorShipping->base_shipping_fees ?? 0}}</p>
                            <p class="text-muted mb-0">@lang("vendors.shipping_info.extra_shipping_fees"): {{ $orderVendorShipping->extra_shipping_fees ?? 0}}</p>
                            <p class="text-muted mb-0">@lang("vendors.shipping_info.total_shipping_fees"): {{  $orderVendorShipping->total_shipping_fees}}</p>

                            @if($row->visa_amount > 0 && $row->wallet_amount > 0)
                                <p class="text-muted mb-0">@lang('translation.payment_method') : {{ \App\Enums\PaymentMethods::getStatusList()[$row->payment_id] }} - {{ \App\Enums\PaymentMethods::getStatus(3) }}</p>
                            @else
                                <p class="text-muted mb-0">@lang('translation.payment_method') : {{ \App\Enums\PaymentMethods::getStatusList()[$row->payment_id] }}</p>
                            @endif
                            @if($orderVendorShipping->order->checkOrderIsPaid())

                            <form action="{{route('vendor.change_shipping_status')}}" method="post" id="shipping_status_form">
                                @csrf
                                <input type="hidden" name="order_vendor_shipping_id" value="{{$orderVendorShipping?->id}}">
                                <label for="">@lang("vendors.shipping_info.status")</label>
                                @if($orderVendorShipping->status == 'registered')
                                    <select id="orderStatus" name="is_accepted_shipping" class="form-control text-center" @disabled($orderVendorShipping->is_accepted_shipping == 1)>
                                        @if($orderVendorShipping->is_accepted_shipping == 0 )
                                            <option value="0" {{$orderVendorShipping->is_accepted_shipping == 0 ? 'selected' : ''}}>@lang('vendors.shipping_status.registered')</option>
                                            <option value="1" {{$orderVendorShipping->is_accepted_shipping == 1 ? 'selected'  : ''}}>@lang('vendors.shipping_status.processing')</option>
                                        @else
                                            <option value="1" {{$orderVendorShipping->is_accepted_shipping == 1 ? 'selected'  : ''}}>@lang('vendors.shipping_status.processing')</option>
                                        @endif
                                    </select>
                                @else
                                    <p><label for="">@lang("vendors.shipping_info.status")</label> : @lang("vendors.shipping_status.$orderVendorShipping->status")</p>

                                @endif
                            </form>
                            @else
                                <p><label for="">@lang("vendors.shipping_info.status")</label> : @lang("vendors.shipping_status.$orderVendorShipping->status")</p>
                            @endif


                        </div>
                    </div>
                </div>
                <!--end card-->
            </div>

            @endif

            <div class="card mt-5">
                <div class="card-header">
                    <span>ملاحظات</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('vendor.order.note',$row->id) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>أكتب ملاحظاتك على طلب</label>
                            <textarea name="note" class="form-control" rows="7" placeholder="أضف ملاحظة على الطلب (ستظهر للإدارة)">{{$row->orderNote->note}}</textarea>
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
                <form class="modal-dialog" role="document" method="post" action="{{ route('vendor.order.check_otp')  }}">
                    @csrf

                    <input type="hidden" name="order_id" value="{{ $row->id  }}" />
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalScrollableTitle">@lang('admin.check_otp_to_recieve_order')</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label for="otp" class="form-label">@lang('admin.otp')</label>
                            <div class="input-group mb-3">
                                <input type="text" name="otp" class="form-control" id="otp" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('admin.close')</button>
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


    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog" id="form-package" role="document"  >
        <form  method="post" action="{{route('vendor.change_shipping_status')}}">
            @csrf
            {{-- <input type="hidden" name="order_id" value="{{ $row->id  }}" /> --}}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">ادخل عدد قطع الشحن</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="no_packages" class="form-label">عدد القطع <small class="text-danger">(قم بادخال عدد القطع التي ستقوم بتسليمها إلى أراميكس لهذا الطلب وليس كمية المنتج)</small> </label>
                    <div class="input-group mb-3">
                        <input type="number" min="1" name="no_packages" class="form-control" id="no_packages" required>
                        {{-- <input type="text" name="no_packages_shipping" class="form-control" id="otp" required> --}}
                        <input type="hidden" name="order_vendor_shipping_id" value="{{$orderVendorShipping->id}}">
                        <input type="hidden" name="is_accepted_shipping" value="1">
                        <input type="hidden" name="shipping_type_id" value="{{$orderVendorShipping->shipping_type_id}}">
                        <input type="hidden" name="vendor_id" value="{{$orderVendorShipping->vendor_id}}">
                        <input type="hidden" name="order_id" value="{{$row->id}}">
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

            var sOptionVal =$(this).val();
            if(sOptionVal=='processing'){

                $('#exampleModalScrollable' ).modal('show');
                $(this).closest('#form-package').submit();
            }

            if(sOptionVal == "1"){
                $("#form-package").append('<input type="hidden" name="is_accepted_shipping" value="1" />');

                $('#exampleModalScrollable' ).modal('show');
                $(this).closest('#form-package').submit();
            }


            // if(sOptionVal == "confirmed"){
            //     $('#shipping_status_form').submit();
            // }
        });
    </script>



@endsection
