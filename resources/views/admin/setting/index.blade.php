@extends('admin.layouts.master')
@section('title')
    @lang('admin.settings.manage_settings')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="productClasses">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.settings.manage_settings')</h5>
                        
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form action="{{ route("admin.settings.index") }}">
                        <div class="row g-3">
                            <div class="col-xxl-3 col-sm-6">
                                <div class="search-box">
                                    <input name="search" type="text" class="form-control search" value="{{ request()->get('search') }}"
                                           placeholder="@lang("admin.productClasses.search")">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                           
                            <!--end col-->
                            <div class="col-xxl-1 col-sm-4">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="ri-search-line search-icon"></i>
                                        @lang("admin.productClasses.search")
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
                            <table class="table table-nowrap align-middle" id="recipesTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>@lang('admin.settings.key')</th>
                                    <th>@lang('admin.settings.value')</th>
                                    <th>@lang('translation.actions')</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @if ($settings->count() > 0)
                                        @foreach($settings as $setting)
                                            <tr>
                                                <td class="key">{{ $setting->desc }}</td>
                                                <td class="key">
                                                    @if($setting->value && ($setting->input_type == 'pdf' || $setting->input_type == 'image'))
                                                        <a target="_blank" href="{{ ossStorageUrl($setting->value) }}">
                                                            Show
                                                        </a>
                                                    @else
                                                        {{ $setting->value }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        @if ($setting->editable == 1)
                                                            <li class="list-inline-item" data-bs-toggle="tooltip"
                                                                data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                                <a class="text-info d-inline-block remove-item-btn"
                                                                    {{-- data-bs-toggle="modal" href="#editproductClass-{{$setting->id}}"> --}}
                                                                    href="{{ route('admin.settings.edit', ['setting' => $setting]) }}"/>
                                                                    <i class="ri-edit-2-line"></i>
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </td>
                                            </tr>
                                            <div class="modal fade flip" id="editproductClass-{{$setting->id}}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form action="{{ route("admin.settings.update", $setting->id) }}" method="post" enctype="multipart/form-data">
                                                            <div class="modal-body p-5 text-center">
                                                                <div class="row">
                                                                    <div class="col-lg-4">
                                                                        <label> @lang('admin.settings.key') </label>
                                                                    </div>
                                                                    <div class="col-lg-8">    
                                                                        {{ $setting->desc }}
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-3">
                                                                    <div class="col-lg-4">
                                                                        <label> @lang('admin.settings.value') </label>
                                                                    </div>
                                                                    <div class="col-lg-8">    
                                                                        @switch($setting->input_type)
                                                                            @case('text')
                                                                                <textarea class="form-control" name="value">{{$setting->value}}</textarea>
                                                                                @break
                                                                            @case('date')
                                                                                    <input type="date" type="" class="form-control" value="{{$setting->value}}" name="value">
                                                                                @break
                                                                            @case('image')
                                                                                <input type="file" type="" class="form-control"  name="value">
                                                                                @break
                                                                            @case('pdf')
                                                                                <input type="file" type="" class="form-control" name="value">
                                                                                @break
                                                                            @case('email')
                                                                                <input type="email" type="" class="form-control" value="{{$setting->value}}" name="value">
                                                                                @break
                                                                            @case('phone')
                                                                                <input type="phone" type="" class="form-control" value="{{$setting->value}}" name="value">
                                                                                @break
                                                                        
                                                                            @default
                                                                            <input type="text" type="" class="form-control" value="{{$setting->value}}" name="value">
                                                                        @endswitch
                                                                    
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="input_type" value="{{$setting->input_type}}">
                                                                <div class="mt-4 text-center">
                                                                    <div class="hstack gap-2 justify-content-center remove">
                                                                        <button type="button" class="btn btn-link link-primary fw-medium text-decoration-none"
                                                                                data-bs-dismiss="modal" id="deleteRecord-close">
                                                                            <i class="ri-close-line me-1 align-middle"></i>
                                                                            @lang('admin.close')
                                                                        </button>
                                                                            @csrf
                                                                        @method("PUT")
                                                                        <button type="submit" class="btn btn-primary" id="delete-record">
                                                                            @lang('admin.settings.edit')
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan = "4">
                                                <center>
                                                    @lang('admin.productClasses.not_found')
                                                </center>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        @if($errors->any())
                        <div id="validationsModal" class="modal show" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header p-5">
                                        <button type="button" class="close" onClick="displayModal()" data-dismiss="modal" aria-label="Close">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body p-5 text-center">
                                        <div class="d-flex justify-content-center align-items-center" style="gap: 20px;">
                                            <div>
                                                <i class="fa fa-times" style="
                                                    padding: 15px;
                                                    font-size: 25px;
                                                    background: #da534d;
                                                    border: 4px solid #b24950;
                                                    border-radius: 50px;
                                                    width: 60px;
                                                    height: 60px;
                                                    display: flex;
                                                    align-items: center;
                                                    justify-content: center;
                                                    color: #fff;
                                                    "></i>
                                            </div>
                                            <div>
                                                <h3>حدث خطاء </h3>
                                                @error('value')
                                                    <p>{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-link link-primary fw-medium text-decoration-none"
                                        data-bs-dismiss="modal" id="validationErrors-close" onClick="displayModal()">
                                        <i class="ri-close-line me-1 align-middle"></i>
                                            @lang('admin.close')
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                               colors="primary:#25a0e2,secondary:#0ab39c"
                                               style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">@lang('admin.productClasses.no_result_found')</h5>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{ $settings->appends(request()->query())->links("pagination::bootstrap-4") }}
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
        @if($errors->any)
            $("#validationsModal").modal("toggle")
        @endif
        function submitEditForm(e) {
            e.preventDefault()
            console.log(e.)
        }
    </script>
@endsection
