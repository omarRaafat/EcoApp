@extends('admin.layouts.master')
@section('title')
    @lang('admin.categories.manage_categories')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css" />
    <style>
        table th,
        table td {
            width: 100px;
            padding: 5px;
        }

        .selected {
            background-color: #f3f6f9;
            color: #000;
        }
    </style>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="categories">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.categories.manage_categories')</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary add-btn"
                                    id="create-btn">
                                    <i class="ri-add-line align-bottom me-1"></i> @lang('admin.categories.create')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form action="{{ route('admin.categories.index') }}">
                        <div class="row g-3">
                            <div class="col-xxl-2 col-sm-4">
                                <div class="search-box">
                                    <input name="search" type="text" class="form-control search"
                                        value="{{ request()->get('search') }}" placeholder="@lang('admin.categories.search')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false name="trans"
                                        id="trans">
                                        <option value="all" selected>@lang('admin.categories.choose_search_lang')</option>
                                        <option value="ar" @selected(request()->get('trans') == 'ar')>@lang('admin.categories.name_ar')</option>
                                        <option value="en" @selected(request()->get('trans') == 'en')>@lang('admin.categories.name_en')</option>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false name="is_active"
                                        id="is_active">
                                        <option value="all" selected>@lang('admin.select-option')</option>
                                        <option value="1" @selected(request()->get('is_active') == '1')>@lang('admin.categories.active')</option>
                                        <option value="0" @selected(request()->get('is_active') == '0')>@lang('admin.categories.inactive')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100" onclick="SearchData();"><i
                                            class="ri-equalizer-fill me-1 align-bottom"></i>
                                        @lang('admin.categories.filter')
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
                        <ul class="nav nav-tabs nav-tabs-custom nav-primary mb-3" role="tablist">
                            <li class="nav-item">
                                <form action="{{ route('admin.categories.index') }}" method="get">
                                    <button class="nav-link py-3 {{ empty(request()->query()) ? 'active' : '' }}"
                                        data-bs-toggle="tab" id="active" role="tab" aria-selected="false">
                                        <i class="ri-store-2-fill me-1 align-bottom"></i> @lang('admin.categories.all_categories')
                                    </button>
                                </form>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route('admin.categories.index') }}" method="get">
                                    <input type="hidden" name="is_active" value="1">
                                    <button
                                        class="nav-link py-3 {{ request()->has('is_active') && request()->is_active == 1 ? 'active' : '' }}"
                                        data-bs-toggle="tab" id="active" role="tab" aria-selected="false">
                                        <i class="ri-checkbox-circle-line me-1 align-bottom"></i> @lang('admin.customer_finances.wallets.active')
                                    </button>
                                </form>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route('admin.categories.index') }}" method="get">
                                    <input type="hidden" name="is_active" value="0">
                                    <button type="submit"
                                        class="nav-link py-3 {{ request()->has('is_active') && request()->is_active == 0 ? 'active' : '' }}"
                                        data-bs-toggle="tab" id="inactive" role="tab" aria-selected="false">
                                        <i class="ri-truck-line me-1 align-bottom"></i> @lang('admin.customer_finances.wallets.inactive')
                                    </button>
                                </form>
                            </li>
                        </ul>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="categoriesTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th><i data-feather="menu"></i></th>
                                        <th>@lang('admin.categories.id')</th>
                                        <th>@lang('admin.categories.image')</th>
                                        <th>@lang('admin.categories.name_ar')</th>
                                        <th>@lang('admin.categories.child_count')</th>
                                        <th>@lang('admin.categories.order')</th>
                                        <th>@lang('admin.categories.is_active')</th>
                                        <th>@lang('translation.actions')</th>
                                    </tr>
                                </thead>
                                <tbody id="categoriesSort" class="list form-check-all">
                                    @foreach ($categories as $category)
                                        <tr data-id="{{ $category->id }}" data-order="{{ $category->order }}">
                                            <td><i data-feather="menu"></i></td>
                                            <td>
                                                <a href="{{ route('admin.categories.show', ['id' => $category->id, 'type' => 1]) }}"
                                                    class="fw-medium link-primary">
                                                    #{{ $category->id }}
                                                </a>
                                            </td>
                                            <td>
                                                <img src="{{ $category->image_url_thumb }}" alt="{{ $category->name }}">
                                            </td>
                                            <td>{{ $category->getTranslation('name', 'ar') }}</td>
                                            <td>{{ $category->SubCategoriesCount() }}</td>
                                            <td>{{ $category->order }}</td>
                                            <td>
                                                <span
                                                    class="{{ \App\Enums\CategoryIsActiveStatus::getStatusWithClass($category->is_active)['class'] }}">
                                                    {{ \App\Enums\CategoryIsActiveStatus::getStatusWithClass($category->is_active)['name'] }}
                                                </span>
                                            </td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                        title="@lang('admin.categories.show')">
                                                        <a href="{{ route('admin.categories.show', $category->id) }}"
                                                            class="text-primary d-inline-block">
                                                            <i class="ri-eye-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                        title="@lang('admin.categories.edit')">
                                                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                            class="text-primary d-inline-block">
                                                            <i class="ri-edit-2-line"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                        <a class="text-danger d-inline-block remove-item-btn"
                                                            data-bs-toggle="modal"
                                                            href="#deleteCategory-{{ $category->getUniqueIdentifier() }}">
                                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                                        </a>
                                                        <!-- Start Delete Modal -->
                                                        <div class="modal fade flip"
                                                            id="deleteCategory-{{ $category->getUniqueIdentifier() }}"
                                                            tabindex="-1" aria-hidden="true">
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
                                                                                    action="{{ route('admin.categories.destroy', $category->id) }}"
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
                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#25a0e2,secondary:#0ab39c"
                                        style="width:75px;height:75px"></lord-icon>
                                    <h5 class="mt-2">@lang('admin.categories.no_result_found')</h5>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{ $categories->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
@endsection
@section('script-bottom')
    <script type="text/javascript">
        $(function() {
            let data = []
            $("#categoriesSort").find("tr").each(function(index) {
                data.push({
                    'index': index,
                    'id': $(this).data('id'),
                    'order': $(this).data('order')
                });
            });
            $("#categoriesSort").sortable({
                items: 'tr',
                cursor: "move",
                axis: 'y',
                dropOnEmpty: false,
                handle: ".handle",
                start: function(e, ui) {
                    ui.item.addClass("selected");
                },
                stop: function(e, ui) {
                    ui.item.removeClass("selected");
                    let newData = []
                    $(this).find("tr").each(function(index) {
                        let id = $(this).data('id');
                        let order = $(this).data('order');
                        data.forEach(function(item) {
                            if (index == item.index) {
                                newData.push({
                                    'id': id,
                                    'order': item.order
                                });
                                $("tr[data-id='" + id + "']").attr('data-order', item
                                    .order);
                                $("tr[data-id='" + id + "']").find("td").eq(6).html(item
                                    .order);
                            }
                        });
                    });
                    $.post("{{ route('admin.categories.updateCategoryOrder') }}", {
                        "data": newData,
                        "_token": "{{ csrf_token() }}"
                    }, function(data) {}, 'json');
                }
            });
        });
    </script>
@endsection
