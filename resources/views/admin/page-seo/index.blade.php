@extends('admin.layouts.master')
@section('title')
    @lang('page-seo.title')
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
                        <h5 class="card-title mb-0 flex-grow-1">@lang('page-seo.title')</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route("admin.page-seo.create") }}" class="btn btn-primary add-btn" id="create-btn">
                                    <i class="ri-add-line align-bottom me-1"></i>  @lang('page-seo.create')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('page-seo.page-name')</th>
                                    <th>@lang('page-seo.page-tags')</th>
                                    <th>@lang('page-seo.page-description')</th>
                                    <th>@lang('translation.actions')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @if($collection->isNotEmpty())
                                        @foreach($collection as $model)
                                            <tr>
                                                <td class="id">
                                                    <a href="{{ route("admin.page-seo.show", $model->id) }}"class="fw-medium link-primary">
                                                        {{ $model->page }}
                                                    </a>
                                                </td>
                                                <td title="{{ $model->getTranslation('tags', 'ar') }}">
                                                    {{ \Str::limit($model->getTranslation('tags', 'ar'), 50) }}
                                                </td>
                                                <td title="{{ $model->getTranslation('description', 'ar') }}">
                                                    {{ \Str::limit($model->getTranslation('description', 'ar'), 50) }}
                                                </td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="@lang('page-seo.edit')">
                                                            <a href="{{ route("admin.page-seo.show", $model->id) }}"
                                                                class="text-success d-inline-block">
                                                                <i class="ri-eye-fill"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="@lang('page-seo.edit')">
                                                            <a href="{{ route("admin.page-seo.edit", $model->id) }}"
                                                                class="text-primary d-inline-block">
                                                                <i class="ri-edit-2-line"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                            <a class="text-danger d-inline-block remove-item-btn"
                                                                data-bs-toggle="modal" href="#deleteproductClass-{{$model->id}}">
                                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <!-- Start Delete Modal -->
                                                    <div class="modal fade flip" id="deleteproductClass-{{$model->id}}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body p-5 text-center">
                                                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                                            colors="primary:#25a0e2,secondary:#00bd9d"
                                                                            style="width:90px;height:90px">
                                                                    </lord-icon>
                                                                    <div class="mt-4 text-center">
                                                                        <h4>@lang('page-seo.delete_modal.title')</h4>
                                                                        <p class="text-muted fs-15 mb-4">@lang('page-seo.delete_modal.description', ['page' => $model->page])</p>
                                                                        <div class="hstack gap-2 justify-content-center remove">
                                                                            <button class="btn btn-link link-primary fw-medium text-decoration-none"
                                                                                data-bs-dismiss="modal" id="deleteRecord-close">
                                                                                <i class="ri-close-line me-1 align-middle"></i>
                                                                                @lang('admin.close')
                                                                            </button>
                                                                            <form action="{{ route("admin.page-seo.destroy", $model->id) }}" method="post">
                                                                                @csrf
                                                                                @method("DELETE")
                                                                                <button type="submit" class="btn btn-primary" id="delete-record">
                                                                                    @lang('page-seo.delete')
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
                                    @else
                                        <tr>
                                            <td class="text-center" colspan = "4"> @lang('page-seo.not_found')</td>
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
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
