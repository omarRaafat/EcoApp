@extends('admin.layouts.master')
@section('title')
    @lang('admin.countries.manage_countries')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="countries">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.countries.manage_countries')</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route("admin.countries.create") }}" class="btn btn-primary add-btn" id="create-btn">
                                    <i class="ri-add-line align-bottom me-1"></i>  @lang("admin.countries.create")
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form action="{{ route("admin.countries.index") }}">
                        <div class="row g-3">
                            <div class="col-xxl-3 col-sm-6">
                                <div class="search-box">
                                    <input name="search" type="text" class="form-control search"
                                           placeholder="@lang("admin.countries.search")">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-sm-6">
                                <div>
                                    <select name="trans" class="form-control" data-choices data-choices-search-false  id="idStatus">
                                        <option value="all" selected>@lang("admin.customer_finances.wallets.all")</option>
                                        <option value="ar">@lang("admin.countries.name_ar")</option>
                                        <option value="en">@lang("admin.countries.name_en")</option>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select name="is_active" class="form-control" data-choices data-choices-search-false  id="idStatus">
                                        <option value="all" selected>@lang("admin.countries.filter_is_active")</option>
                                        <option value="1">@lang("admin.countries.active")</option>
                                        <option value="0">@lang("admin.countries.inactive")</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100" onclick="SearchData();"><i
                                            class="ri-equalizer-fill me-1 align-bottom"></i>
                                            @lang("admin.countries.filter")
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="countriesTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('admin.countries.id')</th>
                                    <th>@lang('admin.countries.name_ar')</th>
                                    <th>@lang('admin.countries.name_en')</th>
                                    <th>@lang('admin.countries.code')</th>
                                    <th>@lang('admin.countries.vat_percentage')</th>
                                    <th>@lang('admin.countries.is_active')</th>
                                    <th>@lang('admin.countries.is_national')</th>
                                    <th>@lang('admin.countries.spl_id')</th>
                                    <th>@lang('admin.countries.title-minimum_order_weight')</th>
                                    <th>@lang('admin.countries.title-maximum_order_weight')</th>
                                    <th>@lang('admin.countries.title-maximum_order_total')</th>
                                    <th>@lang('translation.actions')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @if ($countries->count() > 0)
                                        @foreach($countries as $country)
                                            <tr>
                                                <td class="id">
                                                    <a href="{{ route("admin.countries.show", $country->id) }}"class="fw-medium link-primary">
                                                        #{{$country->id}}
                                                    </a>
                                                </td>
                                                <td class="name_ar">{{ $country->getTranslation('name', 'ar') }}</td>
                                                <td class="name_en">{{ $country->getTranslation('name', 'en') }}</td>
                                                <td class="name_en">{{ $country->code }}</td>
                                                <td class="name_en">{{ $country->vat_percentage }}% </td>
                                                <td class="is_active">
                                                    <span class="{{ \App\Enums\CountryStatus::getStatusWithClass($country->is_active)["class"] }}">
                                                        {{ \App\Enums\CountryStatus::getStatusWithClass($country->is_active)["name"] }}
                                                    </span>
                                                </td>
                                                <td class="is_active">
                                                    <span class="{{ \App\Enums\NationalCountry::getTypeWithClass($country->is_national)["class"] }}">
                                                        {{ \App\Enums\NationalCountry::getTypeWithClass($country->is_national)["name"] }}
                                                    </span>
                                                </td>
                                                <td class="spl_id">{{ $country->spl_id ? $country->spl_id : trans("admin.not_found") }}</td>
                                                <td>
                                                    {{ $country->minimum_order_weight ? $country->minimum_order_weight ." ". trans("translation.kilo") : trans("admin.not_found") }}
                                                </td>
                                                <td>
                                                    {{ $country->maximum_order_weight ? $country->maximum_order_weight ." ". trans("translation.kilo") : trans("admin.not_found") }}
                                                </td>
                                                <td>
                                                    {{ $country->maximum_order_total ? $country->maximum_order_total ." ". trans("translation.sar") : trans("admin.not_found") }}
                                                </td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.categories.show')">
                                                            <a href="{{ route("admin.countries.show", $country->id) }}"
                                                            class="text-primary d-inline-block">
                                                                <i class="ri-eye-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.countries.edit')">
                                                            <a href="{{ route("admin.countries.edit", $country->id) }}"
                                                            class="text-primary d-inline-block">
                                                                <i class="ri-edit-2-line"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <!-- Start Delete Modal -->
                                            <div class="modal fade flip" id="deletecountry-{{$country->id}}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-5 text-center">
                                                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                                    colors="primary:#25a0e2,secondary:#00bd9d"
                                                                    style="width:90px;height:90px">
                                                            </lord-icon>
                                                            <div class="mt-4 text-center">
                                                                <h4>@lang('admin.countries.delete_modal.title')</h4>
                                                                <p class="text-muted fs-15 mb-4">@lang('admin.countries.delete_modal.description')</p>
                                                                <div class="hstack gap-2 justify-content-center remove">
                                                                    <button class="btn btn-link link-primary fw-medium text-decoration-none"
                                                                            data-bs-dismiss="modal" id="deleteRecord-close">
                                                                        <i class="ri-close-line me-1 align-middle"></i>
                                                                        @lang('admin.close')
                                                                    </button>
                                                                    <form action="{{ route("admin.countries.destroy", $country->id) }}" method="post">
                                                                        @csrf
                                                                        @method("DELETE")
                                                                        <button type="submit" class="btn btn-primary" id="delete-record">
                                                                            @lang('admin.categories.delete')
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
                                                    @lang('admin.countries.not_found')
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
                                    <h5 class="mt-2">@lang('admin.countries.no_result_found')</h5>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{ $countries->appends(request()->query())->links("pagination::bootstrap-4") }}
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
@endsection
