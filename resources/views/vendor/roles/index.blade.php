@extends('vendor.layouts.master')
@section('title')
@lang('vendors.roles')
@endsection
@section('css')
<link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('translation.app_name')
        @endslot

        @slot('title')
            @lang('vendors.roles')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-content-center align-items-center">
                    <h5 class="card-title mb-0">@lang('vendors.roles')</h5>
                    <a href="{{route('vendor.roles.create')}}" class="btn btn-success" id="addrole-btn"><i
                        class="ri-add-line align-bottom me-1"></i> @lang('vendors.create_role')</a>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('vendors.role-name')</th>
                                <th scope="col">@lang('vendors.role-permission')</th>
                                <th scope="col">@lang('vendors.created_at')</th>
                                <th scope="col">@lang('vendors.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($collection->isEmpty())
                                <tr>
                                    <td class="text-center" colspan="5"> @lang('vendors.no-roles') </td>
                                </tr>
                            @else
                                @foreach($collection as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->getTranslation('name','ar') }}</td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-2 fs-16">
                                                @foreach ($role->permissions as $permission)
                                                    <div class="badge fw-medium badge-info">@lang('vendors.permissions_keys.' . $permission)</div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>{{ date('d-m-Y h:i', strtotime($role->created_at)) }}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                    <a href="{{ route('vendor.roles.edit', ['role' => $role]) }}" class="text-success d-inline-block">
                                                        <i class="ri-edit-box-fill fs-16"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                    <a href="#" data-id='{{ $role->id }}' data-bs-toggle="modal"
                                                        data-bs-target="#removeItemModal" onclick="showDeleteModal('{{ route('vendor.roles.destroy', ['role' => $role]) }}')" class="text-danger d-inline-block">
                                                        <i class="ri-delete-bin-fill fs-16"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{ $collection->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- removeItemModal -->
    <div id="removeItemModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="btn-close"></button>
                </div>
                <form id="delete-fole-form" class="modal-body" method="POST">
                    @csrf
                    @method("DELETE")
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#25a0e2,secondary:#00bd9d" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>@lang('translation.Are_you_sure')</h4>
                            <p class="text-muted mx-4 mb-0">@lang('translation.Are_you_sure_you_want_to_remove_this')</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">@lang('translation.Close_back')</button>
                        <button type="submit" class="btn w-sm btn-primary" id="delete-user">@lang('translation.yes_delete_it')</button>
                    </div>
                </form>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!--ecommerce-customer init js -->
<script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
    function showDeleteModal(actionUrl) {
        $("#delete-fole-form").attr("action", actionUrl)
    }
</script>
@endsection
