@extends('admin.layouts.master')
@section('title')
    @lang("admin.categories.single_title") : {{ $category->getTranslation('name', 'ar') }}
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#manage" role="tab" aria-selected="false">
                                @lang('admin.categories.manage_categories')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#show" role="tab" aria-selected="false">
                                @lang("admin.categories.show")
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content  text-muted">
                        <div class="tab-pane active" id="manage" role="tabpanel">
                            <div class="row">
                                <div class="card">
                                    <div class="card-header  border-0">
                                        <div class="d-flex align-items-center">
                                            <h5 class="card-title mb-0 flex-grow-1">@lang('admin.categories.manage_categories')</h5>
                                            <div class="flex-shrink-0">
                                                <div class="d-flex gap-1 flex-wrap">
                                                    <a href="{{ route("admin.categories.createSubChildCategory", ["parent_id" => $category->id]) }}" class="btn btn-primary add-btn" id="create-btn">
                                                        <i class="ri-add-line align-bottom me-1"></i>  @lang("admin.categories.create")
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div>
                                            <div class="table-responsive table-card mb-1">
                                                <table class="table table-nowrap align-middle" id="citiesTable">
                                                    <thead class="text-muted table-light">
                                                    <tr class="text-uppercase">
                                                        <th>@lang('admin.categories.id')</th>
                                                        <th>@lang('admin.categories.name_ar')</th>
                                                        <th>@lang('admin.categories.level')</th>
                                                        <th>@lang('admin.categories.is_active')</th>
                                                        <th>@lang('translation.actions')</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                    @foreach($category->child as $subcategory)
                                                        <tr>
                                                            <td class="id">
                                                                <a href="{{ route("admin.categories.showSubChildCategory", ["id" => $subcategory->id]) }}" class="fw-medium link-primary">
                                                                    #{{$subcategory->id}}
                                                                </a>
                                                            </td>
                                                            <td class="name_ar">{{ $subcategory->getTranslation('name', 'ar') }}</td>
                                                            <td class="level">
                                                                {{ \App\Enums\CategoryLevels::getLevels($subcategory->level) }}
                                                            </td>
                                                            <td class="is_active">
                                                                <span class="{{ \App\Enums\CategoryIsActiveStatus::getStatusWithClass($subcategory->is_active)["class"] }}">
                                                                    {{ \App\Enums\CategoryIsActiveStatus::getStatusWithClass($subcategory->is_active)["name"] }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <ul class="list-inline hstack gap-2 mb-0">
                                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.categories.show')">
                                                                        <a href="{{ route("admin.categories.showSubChildCategory", ["id" => $subcategory->id]) }}"
                                                                           class="text-primary d-inline-block">
                                                                            <i class="ri-eye-fill fs-16"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.categories.edit')">
                                                                        <a href="{{ route("admin.categories.editSubChildCategory", ["id" => $subcategory->id]) }}"
                                                                           class="text-primary d-inline-block">
                                                                            <i class="ri-edit-2-line"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                                        data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                                        <a class="text-danger d-inline-block remove-item-btn"
                                                                           data-bs-toggle="modal" href="#deleteCategory-{{$subcategory->id}}">
                                                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                                                        </a>
                                                                        <!-- Start Delete Modal -->
                                                                        <div class="modal fade flip" id="deleteCategory-{{$subcategory->id}}" tabindex="-1" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-body p-5 text-center">
                                                                                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                                                                   colors="primary:#25a0e2,secondary:#00bd9d"
                                                                                                   style="width:90px;height:90px">
                                                                                        </lord-icon>
                                                                                        <div class="mt-4 text-center">
                                                                                            <h4>@lang('admin.categories.delete_modal.title')</h4>
                                                                                            <p class="text-muted fs-15 mb-4">@lang('admin.categories.delete_modal.description')</p>
                                                                                            <div class="hstack gap-2 justify-content-center remove">
                                                                                                <button class="btn btn-link link-primary fw-medium text-decoration-none"
                                                                                                        data-bs-dismiss="modal" id="deleteRecord-close">
                                                                                                    <i class="ri-close-line me-1 align-middle"></i>
                                                                                                    @lang('admin.close')
                                                                                                </button>
                                                                                                <form action="{{ route("admin.categories.destroy", $subcategory->id) }}" method="post">
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
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="show" role="tabpanel">
                            <div class="row">
                                <div class="card">
                                    <div class="card-header  border-0">
                                        <div class="d-flex align-items-center">
                                            <h5 class="card-title mb-0 flex-grow-1">
                                                @lang("admin.categories.show"):
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <form action="javascript:void(0);" class="row g-3">
                                            @if($category->media->count() > 0)
                                            <div class="col-md-6">
                                                <label for="inputAddress2" class="form-label">@lang("admin.categories.image_for_show")</label>
                                                <span class="d-flex align-items-center">
                                                    <img src="{{ $category->getFirstMediaUrl('categories', 'thumb') }}" alt="{{ $category->name }}">
                                                </span>
                                            </div>
                                            @endif
                                            <div class="col-md-6">
                                                <label for="username" class="form-label">@lang("admin.categories.name_ar")</label>
                                                <input disabled="disabled" readonly type="text" class="form-control" value="{{ $category->getTranslation('name', 'ar') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="username" class="form-label">@lang("admin.categories.slug_ar")</label>
                                                <input disabled="disabled" readonly type="text" class="form-control" value="{{ $category->getTranslation('slug', 'ar') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="username" class="form-label">@lang("admin.categories.slug_en")</label>
                                                <input disabled="disabled" readonly type="text" class="form-control" value="{{ $category->getTranslation('slug', 'en') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="username" class="form-label">@lang("admin.categories.order")</label>
                                                <input disabled="disabled" readonly type="text" class="form-control" value="{{ $category->order }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="username" class="form-label">@lang("admin.categories.is_active")</label>
                                                <span class="{{ \App\Enums\CategoryIsActiveStatus::getStatusWithClass($category->is_active)["class"] }}">
                                                    {{ \App\Enums\CategoryIsActiveStatus::getStatusWithClass($category->is_active)["name"] }}
                                                </span>
                                            </div>
                                        @if($category->level != 1)
                                            <div class="col-md-6">
                                                <label for="username" class="form-label">@lang("admin.categories.parent_name_ar")</label>
                                                <input disabled="disabled" readonly type="text" class="form-control" value="{{ $category->parent_category_name_ar != 0 ? $category->parent_category_name_ar : trans('admin.categories.not_found') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="username" class="form-label">@lang("admin.categories.level")</label>
                                                <input disabled="disabled" readonly type="text" class="form-control" value="{{ \App\Enums\CategoryLevels::getLevels($category->level) }}">
                                            </div>
                                        @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!--end col-->
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
