@extends('admin.layouts.master')
@section('title')
    @lang('postHarvestServices.post-harvest-services') : {{ $data->name }}
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="areas">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('postHarvestServices.post-harvest-services')</h5>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="areasTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th>@lang('postHarvestServices.id')</th>
                                        <th>@lang('postHarvestServices.name')</th>
                                        <th>@lang('postHarvestServices.image')</th>
                                        <th>@lang('postHarvestServices.status')</th>
                                        <th>@lang('postHarvestServices.Interior_construction')</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @if ($data)
                                        <tr>
                                            <td>
                                                {{ $data->id }}
                                            </td>
                                            <td>
                                                {{ $data->name }}
                                            </td>
                                            <td>
                                                <img width="100"
                                                    src="{{ asset('storage/uploads/postHarvestServicesDepartment/' . $data->image) }}"
                                                    alt="{{ $data->image }}">
                                            </td>
                                            <td>
                                                <span
                                                    class="badge {{ $data->status == 'active' ? 'badge-soft-success' : 'badge-soft-danger' }}">{{ $data->status == 'active' ? 'نشط' : 'غير نشط' }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.post-harvest-services-departments.fields', $data->id) }}"
                                                    class="ri-menu-fold-line fs-16"></a>
                                            </td>
                                        </tr>
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
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
