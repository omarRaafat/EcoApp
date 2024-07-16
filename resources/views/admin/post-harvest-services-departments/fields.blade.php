@extends('admin.layouts.master')
@section('title')
    @lang('postHarvestServices.Interior_construction')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="areas">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('postHarvestServices.Interior_construction')</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route('admin.post-harvest-services-departments.fields.create', $postHarvest->id) }}"
                                    class="btn btn-primary add-btn" id="create-btn">
                                    <i class="ri-add-line align-bottom me-1"></i> @lang('postHarvestServices.interior_construction_fields.add')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                {{--  <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form action="{{ route('admin.post-harvest-services-departments.index') }}">
                        <div class="row g-3">
                            <div class="col-xxl-3 col-sm-6">
                                <div class="search-box">
                                    <input name="search" type="text" class="form-control search"
                                        placeholder="@lang('admin.areas.search')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-sm-6">
                                <div>
                                    <select name="status" class="form-control" data-choices data-choices-search-false
                                        id="idStatus">
                                        <option value="all" selected>@lang('admin.customer_finances.wallets.all')</option>
                                        <option value="active">@lang('postHarvestServices.status.active')</option>
                                        <option value="not_active">@lang('postHarvestServices.status.not_active')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100" onclick="SearchData();"><i
                                            class="ri-equalizer-fill me-1 align-bottom"></i>
                                        @lang('admin.areas.filter')
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>  --}}
                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="areasTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th>@lang('postHarvestServices.interior_construction_fields.id')</th>
                                        <th>@lang('postHarvestServices.interior_construction_fields.name')</th>
                                        <th>@lang('postHarvestServices.interior_construction_fields.type')</th>
                                        <th>@lang('postHarvestServices.interior_construction_fields.depends_on_price')</th>
                                        <th>@lang('postHarvestServices.interior_construction_fields.is_required')</th>
                                        <th>@lang('postHarvestServices.interior_construction_fields.status')</th>
                                        <th>@lang('postHarvestServices.actions')</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @if ($data->count() > 0)
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>
                                                    {{ $item->id }}
                                                </td>
                                                <td>
                                                    {{ $item->name }}
                                                </td>
                                                <td>
                                                    {{ $item->type }}
                                                </td>
                                                <td>
                                                    {{ $item->depends_on_price }}
                                                </td>
                                                <td>
                                                    {{ $item->is_required }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge {{ $item->status == 'active' ? 'badge-soft-success' : 'badge-soft-danger' }}">{{ $item->status == 'active' ? trans('postHarvestServices.status_fields.active') : trans('postHarvestServices.status_fields.not_active') }}</span>
                                                </td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top"
                                                            title="@lang('postHarvestServices.edit')">
                                                            <a href="{{ route('admin.post-harvest-services-departments.fields.edit', $item->id) }}"
                                                                class="text-primary d-inline-block">
                                                                <i class="ri-edit-2-line"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                            <a class="text-danger d-inline-block remove-item-btn"
                                                                data-bs-toggle="modal"
                                                                href="#deleteCategory-{{ $item->id }}">
                                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                                            </a>
                                                            <!-- Start Delete Modal -->
                                                            <div class="modal fade flip"
                                                                id="deleteCategory-{{ $item->id }}" tabindex="-1"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-body p-5 text-center">
                                                                            <lord-icon
                                                                                src="https://cdn.lordicon.com/gsqxdxog.json"
                                                                                trigger="loop"
                                                                                colors="primary:#25a0e2,secondary:#00bd9d"
                                                                                style="width:90px;height:90px">
                                                                            </lord-icon>
                                                                            <div class="mt-4 text-center">
                                                                                <h4>@lang('admin.categories.delete_modal.title')</h4>
                                                                                <p class="text-muted fs-15 mb-4">
                                                                                    @lang('admin.categories.delete_modal.description')</p>
                                                                                <div
                                                                                    class="hstack gap-2 justify-content-center remove">
                                                                                    <button
                                                                                        class="btn btn-link link-primary fw-medium text-decoration-none"
                                                                                        data-bs-dismiss="modal"
                                                                                        id="deleteRecord-close">
                                                                                        <i
                                                                                            class="ri-close-line me-1 align-middle"></i>
                                                                                        @lang('admin.close')
                                                                                    </button>
                                                                                    <form
                                                                                        action="{{ route('admin.post-harvest-services-departments.fields.destroy', $item->id) }}"
                                                                                        method="post">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <button type="submit"
                                                                                            class="btn btn-primary"
                                                                                            id="delete-record">
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
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan = "4">
                                                <center>
                                                    @lang('postHarvestServices.data_not_found')
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
                                    colors="primary:#25a0e2,secondary:#0ab39c" style="width:75px;height:75px">
                                </lord-icon>
                                <h5 class="mt-2">@lang('admin.areas.no_result_found')</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
