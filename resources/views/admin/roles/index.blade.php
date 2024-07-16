@extends('admin.layouts.master')
@section('title')
    @lang('admin.permission_vendor_roles')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border border-dashed border-end-0 border-start-0">
                        <div class="d-flex justify-content-between">
                            <div class="w-75 d-flex">
                                <div class="w-50 me-3">
                                    <form action=" " class="d-flex  w-100">
                                        <input type="hidden" name="status" value="{{request()->get('status')}}">
                                        <div class=" me-3 w-100">
                                            <select class="form-control" data-choices data-choices-search-true
                                                    name="vendor_id" id="is_active">
                                                <option
                                                    value="" @selected(empty(request()->get('vendor_id'))) >@lang("admin.vendors_list")</option>
                                                @foreach ($vendors as $vendor)
                                                    <option
                                                        value="{{$vendor->id}}" @selected(request()->get('vendor_id') == $vendor->id) >{{$vendor->getTranslation('name','ar')}}  </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-secondary">
                                            <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                        </button>
                                    </form>
                                </div>
                                <div>
                                    <form action="{{route('admin.roles.export')}}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-primary"> تصدير Excel</button>
                                    </form>
                                </div>
                            </div>
                            <div class="">
                                <a href="{{ route("admin.roles.create") }}" class="btn btn-primary add-btn" id="create-btn">
                                    <i class="ri-add-line align-bottom me-1"></i>  @lang("admin.add")
                                </a>
                            </div>
                            <!--end col-->
                        </div>

                </div>
                <br>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('admin.permission_vendor_role_name')</th>
                                <th scope="col">@lang('admin.permission_vendor_role_permissions')</th>
                                <th scope="col">@lang('admin.vendor_name')</th>
                                <th scope="col">@lang('admin.created_at')</th>
                                <th scope="col">@lang('admin.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2 fs-16">
                                            @foreach ($role->permissions as $permission)
                                            <div class="badge fw-medium badge-info">@lang('vendors.permissions_keys.' . $permission)</div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>{{ $role->vendor->name }}</td>
                                    <td>{{ date('d-m-Y h:i', strtotime($role->created_at)) }}</td>
                                    <td>
                                        <div class="hstack gap-3 flex-wrap">
                                            <a href="{{ route('admin.roles.edit', ['role' => $role]) }}" class="fs-15 link-success">
                                                <i class="ri-edit-2-line"></i>
                                            </a>
                                            <a href="{{ route('admin.roles.delete', ['role' => $role]) }}" class="fs-15 link-danger">
                                                <i class="ri-delete-bin-line"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
