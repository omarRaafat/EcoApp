@extends('admin.layouts.master')
@section('title')
    @lang('admin.vendor_users')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.permission_vendor_roles')</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route("admin.vendor-users.create") }}" class="btn btn-primary add-btn" id="create-btn">
                                    <i class="ri-add-line align-bottom me-1"></i>  @lang("admin.add")
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-bottom-dashed border-bottom">
                    <form method="get" action="{{ URL::asset('/admin') }}/vendor-users/">
                        <div class="row g-3">
                            <div class="col-xl-3">
                                <div class="search-box">
                                    <input value="{{ request('name') }}" type="text" name="name" class="form-control search" placeholder="@lang('admin.vendor_user_name')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="search-box">
                                    <input value="{{ request('email') }}" type="text" name="email" class="form-control search" placeholder="@lang('admin.vendor_user_email')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="search-box">
                                    <input value="{{ request('phone') }}" type="text" name="phone" class="form-control search" placeholder="@lang('admin.vendor_user_phone')">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <select class="form-control" name="vendor_id" id="vendor_id" data-choices data-choices-sorting-false>
                                    <option value="">@lang('admin.vendors')</option>
                                    @foreach($vendors AS $vendor)
                                        <option @if(request('vendor_id') == $vendor->id) SELECTED @endif value="{{ $vendor->id }}">{{ $vendor->vendorName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-2">
                                <div>
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">@lang('admin.vendor_user_name')</th>
                                <th scope="col">@lang('admin.vendor_user_email')</th>
                                <th scope="col">@lang('admin.vendor_user_phone')</th>
                                <th scope="col">@lang('admin.vendor_name')</th>
                                <th scope="col">@lang('admin.created_at')</th>
                                <th scope="col">@lang('admin.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->vendor?->name }}</td>
                                    <td>{{ date('d-m-Y h:i', strtotime($user->created_at)) }}</td>
                                    <td>
                                        <div class="hstack gap-3 flex-wrap">
                                            <a href="javascript:void(0);" onclick="vendorUserApprove('{{ $user->id }}',this);">
                                                @if($user->is_banned == 1)
                                                    <i id="user_approve_icon" class="ri-check-fill"></i>
                                                @else
                                                    <i id="user_approve_icon" class="link-danger ri-indeterminate-circle-fill"></i>
                                                @endif
                                            </a>
                                            <a href="{{ route('admin.vendor-users.edit', ['user' => $user]) }}" class="fs-15 link-success">
                                                <i class="ri-edit-2-line"></i>
                                            </a>
                                            @if($user->type != 'vendor')
                                            <a href="{{ route('admin.vendor-users.delete', ['user' => $user]) }}" class="fs-15 link-danger">
                                                <i class="ri-delete-bin-line"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
@section('script-bottom')
    <script>
        function vendorUserApprove(userId, item)
        {
            let iconSpan = $(item).find('#user_approve_icon');
            $.post("{{ URL::asset('/admin') }}/vendor-users/block/" + userId, {
                id: userId,
                "_token": "{{ csrf_token() }}"
            }, function (data) {
                if (data.status == 'success')
                {
                    Swal.fire({
                        html: '<div class="mt-3">' +
                            '<div class="mt-4 pt-2 fs-15">' +
                            '<h4>' + data.message + '</h4>' +
                            '</div>' +
                            '</div>',
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 1000
                    });
                    if (data.data == 1)
                    {
                        iconSpan.removeClass('link-danger ri-indeterminate-circle-fill').addClass('ri-check-fill');
                    }
                    else
                    {
                        iconSpan.removeClass('ri-check-fill').addClass('link-danger ri-indeterminate-circle-fill');
                    }
                }
            }, "json");
        }
    </script>
@endsection
