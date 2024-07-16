@extends('admin.layouts.master')
@section('title')
    @lang('admin.delivery.domestic-zones.title')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.delivery.domestic-zones.title')</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-1 flex-wrap">
                                @if (auth()->user()?->isAdminPermittedTo('admin.domestic-zones.create'))

                                <a href="{{ route("admin.domestic-zones.create") }}" class="btn btn-primary add-btn" id="create-btn">
                                    <i class="ri-add-line align-bottom me-1"></i>  @lang("admin.delivery.domestic-zones.create")
                                </a>

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form class="mb-3" action="{{ route("admin.domestic-zones.index") }}">
                        <div class="row g-3">
                            <div class="col-xxl-3 col-sm-6">
                                <div class="search-box">
                                    <input name="search" type="text" class="form-control search"
                                           placeholder="@lang("translation.search")" value="{{ request()->get('search') }}">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="ri-search-line search-icon"></i>
                                            @lang("translation.search")
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
                            <table class="table table-nowrap align-middle">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('admin.delivery.domestic-zones.id')</th>
                                    <th>@lang('admin.delivery.domestic-zones.name-ar')</th>
                                    <th>@lang('translation.actions')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach($collection ?? [] as $model)
                                        <tr>
                                            <td class="id"> #{{ $model->id }} </td>
                                            <td class="name_ar"> {{ $model->getTranslation('name', 'ar') }} </td>
{{--                                            <td class="name_en"> @lang('admin.'. $model->type) </td>--}}
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    @if (auth()->user()?->isAdminPermittedTo('admin.domestic-zones.show'))

                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="@lang('translation.show')">
                                                        <a href="{{ route("admin.domestic-zones.show", $model->id) }}"
                                                        class="text-primary d-inline-block">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                    </li>
                                                    @endif

                                                    @if (auth()->user()?->isAdminPermittedTo('admin.domestic-zones.edit'))

                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="@lang('translation.edit')">
                                                        <a href="{{ route("admin.domestic-zones.edit", $model->id) }}"
                                                        class="text-primary d-inline-block">
                                                            <i class="ri-edit-2-line"></i>
                                                        </a>
                                                    </li>
                                                    @endif

                                                    @if (auth()->user()?->isAdminPermittedTo('admin.domestic-zones.destroy'))

                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="@lang('translation.delete')">
                                                        <a class="text-danger d-inline-block remove-item-btn"
                                                        data-bs-toggle="modal" href="#delete-domestic-zone-{{$model->id}}">
                                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    @endif
                                                </ul>
                                                <!-- Start Delete Modal -->
                                                <div class="modal fade flip" id="delete-domestic-zone-{{$model->id}}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-body p-5 text-center">
                                                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                                        colors="primary:#25a0e2,secondary:#00bd9d"
                                                                        style="width:90px;height:90px">
                                                                </lord-icon>
                                                                <div class="mt-4 text-center">
                                                                    <h4>@lang('admin.delivery.delete-modal-title')</h4>
                                                                    <p class="text-muted fs-15 mb-4">
                                                                        @lang('admin.delivery.domestic-zones.delete-body', ['zone' => $model->getTranslation('name', 'ar')])
                                                                    </p>
                                                                    <div class="hstack gap-2 justify-content-center remove">
                                                                        <button class="btn btn-link link-primary fw-medium text-decoration-none"
                                                                                data-bs-dismiss="modal" id="deleteRecord-close">
                                                                            <i class="ri-close-line me-1 align-middle"></i>
                                                                            @lang('admin.close')
                                                                        </button>
                                                                        <form action="{{ route("admin.domestic-zones.destroy", $model->id) }}" method="post">
                                                                            @csrf
                                                                            @method("DELETE")
                                                                            <button type="submit" class="btn btn-primary" id="delete-record">
                                                                                @lang('translation.delete')
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Delete Modal -->
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($collection->isEmpty())
                                        <tr>
                                            <td colspan = "5">
                                                <center>
                                                    @lang('admin.delivery.domestic-zones.no-zones')
                                                </center>
                                            </td>
                                        </tr>
                                    @endif
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
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
