@extends('admin.layouts.master')
@section('title')
    @lang('admin.productRates.manage_productRates')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="productRates">
                <div class="card-body border border-dashed border-end-0 border-start-0" style="margin-bottom: 10px">
                    <form action="{{ route("admin.productRates.index") }}" class="d-inline">
                        <div class="row g-3">
                            <div class="col-xxl-2 col-sm-6">
                                <div class="search-box">
                                    <input name="search" value="{{ request()->get('search') }}"
                                        type="text" class="form-control search"
                                           placeholder="@lang("admin.productRates.search")">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-6">
                                <div>
                                    <select name="relation" class="form-control" data-choices data-choices-search-false  id="idStatus">
                                        <option @selected(request()->get('relation') == 'all') value="all" selected>@lang("admin.productRates.all_productRates")</option>
                                        <option @selected(request()->get('relation') == 'product') value="product">@lang("admin.productRates.product_id")</option>
                                        <option @selected(request()->get('relation') == 'user') value="user">@lang("admin.productRates.user_id")</option>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-2">
                                <div>
                                    <select name="admin_approved" class="form-control" data-choices data-choices-search-false  id="idStatus">
                                        <option @selected(request()->get('admin_approved') == '') value="" selected>@lang("admin.productRates.filter_is_active")</option>
                                        <option @selected(request()->get('admin_approved') == '1') value="1">@lang("admin.admin_approved_state.pending")</option>
                                        <option @selected(request()->get('admin_approved') == '2') value="2">@lang("admin.admin_approved_state.approved")</option>
                                        <option @selected(request()->get('admin_approved') == '3') value="3">@lang("admin.admin_approved_state.rejected")</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-3">
                                <div class="d-flex ">
                                    <input value="{{ request('avgRatingFrom') }}" name="avgRatingFrom" type="number" step="0.1" min="0.1" max="5" class="form-control " placeholder="متوسط التقييم من">
                                    <input value="{{ request('avgRatingTo') }}" name="avgRatingTo" type="number" step="0.1" min="0.1" max="5" class="form-control " placeholder="متوسط التقييم إلى">
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
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100" onclick="SearchData();"><i
                                            class="ri-equalizer-fill    "></i>
                                            @lang("admin.productRates.filter")
                                    </button>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-1">
                                <div>
                                    <a href="{{ route('admin.productRates.index' , [
                                        'action' => 'exportExcel' ,
                                        'search' => request()->get('search') ,
                                        'relation' => request()->get('relation') ,
                                        'admin_approved' => request()->get('admin_approved') ,
                                         'from' => request()->get('from') ,
                                         'to' => request()->get('to') ,
                                         'avgRatingFrom' => request()->get('avgRatingFrom') ,
                                         'avgRatingTo' => request()->get('avgRatingTo') ,
                                         ]) }}" class="btn btn-sm btn-primary mt-2"> تصدير إكسل</a>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                    <div class="text-left mt-3">
                        <button type="button" class="btn btn-sm btn-success " onclick="updateChecks(2)"> <i class="ri-check-fill fs-169"></i>   الموافقة على التقييمات المحددة </button>
                        <button type="button" class="btn btn-sm btn-danger " onclick="updateChecks(3)"> <i class="ri-close-fill fs-169"></i>   رفض التقييمات المحددة </button>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="productRatesTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('admin.productRates.id')</th>
                                    <th>@lang('admin.productRates.rate')</th>
                                    <th>@lang('admin.productRates.user_id')</th>
                                    <th>@lang('admin.productRates.product_id')</th>
                                    <th style="width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap">@lang('admin.productRates.admin_id')</th>
                                    <th style="width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap">@lang('admin.productRates.comment')</th>
                                    <th>@lang('admin.productRates.admin_approved')</th>
                                    <th>@lang('admin.productRates.reporting')</th>
                                    <th>@lang('translation.actions')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @if ($productRates->count() > 0)
                                        @foreach($productRates as $rate)
                                            <tr>
                                                <td class="id">
                                                    <a href="{{ route("admin.productRates.show", $rate->id) }}"class="fw-medium link-primary">
                                                        #{{$rate->id}}
                                                    </a>
                                                </td>
                                                <td style="width: 114px; !important">
                                                    <div class="stars">
                                                        <i class="fas fa-star {{ ($rate->rate >= 1) ? 'clr_yellow' : '' }}"></i>
                                                        ({{$rate->rate}})
                                                    </div>
                                                </td>

                                                <td class="user_id">{{  $rate->client->name }}</td>
                                                <td class="product_id">{{ $rate->product?->name ?? null }}</td>
                                                <td class="admin_id">{{ $rate->admin->name ?? trans("admin.productRates.not_found") }}</td>
                                                <td class="comment"> <small>{{ $rate->comment ?? trans("admin.productRates.not_found") }}</small> </td>
                                                <td class="admin_approved">
                                                    <span class="{{ \App\Enums\AdminApprovedState::getStateWithClass($rate->admin_approved)["class"] }}">
                                                        {{ \App\Enums\AdminApprovedState::getStateWithClass($rate->admin_approved)["name"] }}
                                                    </span>
                                                </td>
                                                <td class="reporting">{{ !empty($rate->reporting) ? trans("admin.productRates.yes") : trans("admin.productRates.no") }}</td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.productRates.show')">
                                                            <a href="{{ route("admin.productRates.show", $rate->id) }}"
                                                            class="text-primary d-inline-block">
                                                                <i class="ri-eye-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                        @if(in_array($rate->admin_approved,[1,null]))
                                                        <li><input type="checkbox"  class="row-checkbox" value="{{$rate->id}}"></li>
                                                        <li>
                                                            <form action="{{ route('admin.productRates.update', $rate->id) }}" method="post" class="form-steps" autocomplete="on">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="admin_approved" value="2">
                                                                <button type="submit" class="btn btn-sm btn-success"> <i class="ri-check-fill fs-169"></i> </button>
                                                            </form>
                                                        </li>
                                                        @endif
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                            <a class="text-danger d-inline-block remove-item-btn"
                                                            data-bs-toggle="modal" href="#deletecity-{{$rate->id}}">
                                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <!-- Start Delete Modal -->
                                            <div class="modal fade flip" id="deletecity-{{$rate->id}}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-5 text-center">
                                                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                                    colors="primary:#25a0e2,secondary:#00bd9d"
                                                                    style="width:90px;height:90px">
                                                            </lord-icon>
                                                            <div class="mt-4 text-center">
                                                                <h4>@lang('admin.productRates.delete_modal.title')</h4>
                                                                <p class="text-muted fs-15 mb-4">@lang('admin.productRates.delete_modal.description')</p>
                                                                <div class="hstack gap-2 justify-content-center remove">
                                                                    <button class="btn btn-link link-primary fw-medium text-decoration-none"
                                                                            data-bs-dismiss="modal" id="deleteRecord-close">
                                                                        <i class="ri-close-line me-1 align-middle"></i>
                                                                        @lang('admin.close')
                                                                    </button>
                                                                    <form action="{{ route("admin.productRates.destroy", $rate->id) }}" method="post">
                                                                        @csrf
                                                                        @method("DELETE")
                                                                        <button type="submit" class="btn btn-primary" id="delete-record">
                                                                            @lang('admin.productRates.delete')
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Delete Modal -->
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan = "4">
                                                <center>
                                                    @lang('admin.productRates.not_found')
                                                </center>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                    <!-- End Delete Modal -->
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                               colors="primary:#25a0e2,secondary:#0ab39c"
                                               style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">@lang('admin.productRates.no_result_found')</h5>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{ $productRates->appends(request()->query())->links("pagination::bootstrap-4") }}
                            </div>
                        </div>
                    </div>
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

    <script>
        function updateChecks(action){
            var selectedIds = [];
            document.querySelectorAll('.row-checkbox:checked').forEach(function(checkbox) {
                selectedIds.push(checkbox.value); 
            });
            
            $.ajax({
                url: "{{ route('admin.productRates.update-checks') }}",
                type: 'POST',
                data: { 
                    "checks": selectedIds,
                    "action": action,
                    "_token": "{{ csrf_token() }}",
                 },
                success: function(response) {
                    window.location.href = window.location.href
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request error:', error);
                }
            });

            
        }
    </script>
@endsection
