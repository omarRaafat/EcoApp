@extends('admin.layouts.master')
@section('title')
    @lang('admin.sliders.manage_sliders')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="productClasses">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.sliders.manage_sliders')</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-1 flex-wrap mb-3">

                                @if (auth()->user()?->isAdminPermittedTo('admin.slider.create'))
                                <a href="{{ route("admin.slider.create") }}" class="btn btn-primary add-btn" id="create-btn">
                                    <i class="ri-add-line align-bottom me-1"></i>  @lang("admin.sliders.create")
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="slidersTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('admin.sliders.id')</th>
                                    <th>@lang('admin.sliders.name')</th>
                                    <th>@lang('admin.sliders.category')</th>
                                    <th>@lang('admin.sliders.offer')</th>
                                    <th>@lang('translation.actions')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @if ($sliders->count() > 0)
                                        @foreach($sliders as $slider)
                                            <tr>
                                                <td class="id">
                                                    <a href="{{ route("admin.productClasses.show", $slider->id) }}"class="fw-medium link-primary">
                                                        #{{$slider->id}}
                                                    </a>
                                                </td>
                                                <td class="name_ar">{{ $slider?->getTranslation("name", "ar")}}</td>
                                                <td class="name_ar">{{ $slider?->getTranslation("category", "ar")}}</td>
                                                <td class="name_ar">{{ $slider?->getTranslation("offer", "ar")}}</td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.sliders.edit')">
                                                            <a href="{{ route("admin.slider.edit", $slider->id) }}"
                                                            class="text-primary d-inline-block">
                                                                <i class="ri-edit-2-line"></i>
                                                            </a>
                                                        </li>

                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top" title="@lang('admin.sliders.delete')">
                                                            <a class="text-danger d-inline-block remove-item-btn"
                                                                data-bs-toggle="modal" href="#deleteSlider-{{ $slider->id }}">
                                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <div class="modal fade flip" id="deleteSlider-{{ $slider->id }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body p-5 text-center">
                                                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                                        colors="primary:#25a0e2,secondary:#00bd9d"
                                                                        style="width:90px;height:90px">
                                                                    </lord-icon>
                                                                    <div class="mt-4 text-center">
                                                                        <h4>@lang('admin.sliders.delete_modal.title')</h4>
                                                                        <p class="text-muted fs-15 mb-4">@lang('admin.sliders.delete_modal.description')</p>
                                                                        <div class="hstack gap-2 justify-content-center remove">
                                                                            <button class="btn btn-link link-primary fw-medium text-decoration-none"
                                                                                    data-bs-dismiss="modal" id="deleteRecord-close">
                                                                                <i class="ri-close-line me-1 align-middle"></i>
                                                                                @lang('admin.close')
                                                                            </button>
                                                                            <form action="{{ route("admin.slider.destroy", $slider->id) }}" method="post">
                                                                                @csrf
                                                                                @method("DELETE")
                                                                                <button type="submit" class="btn btn-primary" id="delete-record">
                                                                                    @lang('admin.sliders.remove')
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center" colspan = "5">
                                                @lang('admin.productClasses.not_found')
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="pagination-wrap hstack gap-2">
                            {{ $sliders->appends(request()->query())->links("pagination::bootstrap-4") }}
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
