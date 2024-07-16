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
            <div class="card" id="areas">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang($translateBase. '.page-title')</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route("$routeBase.create") }}" class="btn btn-primary add-btn" id="create-btn">
                                    <i class="ri-add-line align-bottom me-1"></i>  @lang($translateBase. '.create')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0 mb-4">
                    <form action="{{ route("$routeBase.index") }}">
                        <div class="row g-3">
                            <div class="col-xxl-6 col-sm-9">
                                <div class="search-box">
                                    <input name="search" type="text" class="form-control search" value="{{ request()->get('search') }}"
                                           placeholder="@lang($translateBase. '.search')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-12">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                        @lang("translation.filter")
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
                            <table class="table table-nowrap align-middle" id="areasTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang($translateBase. '.title_ar')</th>
                                    {{--<th>@lang($translateBase. '.title_en')</th>--}}
                                    <th>@lang('translation.actions')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach($collection as $area)
                                        <tr>
                                            <td class="title_ar">{{ $area->getTranslation('title', 'ar') }}</td>
                                            {{--<td class="title_en">{{ $area->getTranslation('title', 'en') }}</td>--}}
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="@lang($translateBase. '.show')">
                                                        <a href="{{ route("$routeBase.show", $area->id) }}"
                                                            class="text-primary d-inline-block">
                                                            <i class="ri-eye-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="@lang($translateBase. '.edit')">
                                                        <a href="{{ route("$routeBase.edit", $area->id) }}"
                                                            class="text-primary d-inline-block">
                                                            <i class="ri-edit-2-line"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                        <a class="text-danger d-inline-block remove-item-btn"
                                                            data-bs-toggle="modal" href="#deletestaticcontent-{{ $area->id }}">
                                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <!-- Start Delete Modal -->
                                        <div class="modal fade flip" id="deletestaticcontent-{{ $area->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body p-5 text-center">
                                                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                                colors="primary:#25a0e2,secondary:#00bd9d"
                                                                style="width:90px;height:90px">
                                                        </lord-icon>
                                                        <div class="mt-4 text-center">
                                                            <h4>@lang($translateBase. '.delete_modal.title')</h4>
                                                            <p class="text-muted fs-15 mb-4">@lang($translateBase. '.delete_modal.description')</p>
                                                            <div class="hstack gap-2 justify-content-center remove">
                                                                <button class="btn btn-link link-primary fw-medium text-decoration-none"
                                                                        data-bs-dismiss="modal" id="deleteRecord-close">
                                                                    <i class="ri-close-line me-1 align-middle"></i>
                                                                    @lang('admin.close')
                                                                </button>
                                                                <form action="{{ route("$routeBase.destroy", $area->id) }}" method="post">
                                                                    @csrf
                                                                    @method("DELETE")
                                                                    <button type="submit" class="btn btn-primary" id="delete-record">
                                                                        @lang($translateBase. '.delete')
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{ $collection->appends(request()->query())->links("pagination::bootstrap-4") }}
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
