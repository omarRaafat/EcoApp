@extends('admin.layouts.master')
@section('title')
    @lang('admin.customers_list')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom-dashed border-bottom">
                    <div class="d-flex justify-content-between">
                        <form class="d-flex w-50" method="get" action="{{ URL::asset('/admin') }}/customers/">
                            <div class="search-box w-75 me-3">
                                <input value="{{ request()->get('search') }}" type="search" name="search"
                                       class="form-control search"
                                       placeholder="@lang('admin.customer_name'), @lang('admin.customer_phone'), @lang('admin.customer_identity')">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                            <button type="submit" class="btn btn-secondary w-25">
                                <i class="ri-equalizer-fill me-1 align-bottom"></i>
                            </button>
                        </form>
                        <form action="{{route('admin.customers.export')}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary"> تصدير Excel</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">@lang('admin.customer_name')</th>
                            <th scope="col">@lang('admin.customer_phone')</th>
                            <th scope="col">@lang('admin.identity')</th>
                            <th scope="col">@lang('admin.BOD')</th>
                            <th scope="col">@lang('admin.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($customers as $customer)
                            <tr data-id="">
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->identity }}</td>
                                <td>{{ $customer->birthDate }}</td>

                                <td>
                                    <div class="hstack gap-3 flex-wrap">
                                        <a href="{{ route('admin.customers.show', ['user' => $customer->id]) }}"
                                           class="fs-15">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                    {{ $customers->links() }}
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
        function customerChangePriority(customerId, item) {
            let priority = $(item).val();
            $.post("{{ URL::asset('/admin') }}/customers/priority/" + customerId, {
                id: customerId,
                priority: priority,
                "_token": "{{ csrf_token() }}"
            }, function (data) {
                if (data.status == 'success') {
                    Swal.fire({
                        html: '<div class="mt-3">' +
                            '<div class="mt-4 pt-2 fs-15">' +
                            '<h4>@lang('admin.customer_change_priority_message')</h4>' +
                            '</div>' +
                            '</div>',
                        showCancelButton: true,
                        showConfirmButton: false,
                        cancelButtonClass: 'btn btn-primary w-xs mb-1',
                        cancelButtonText: '@lang('admin.back')',
                        buttonsStyling: false,
                        showCloseButton: true
                    });
                }
            }, "json");
        }

        function customerApprove(customerId, item) {
            let iconSpan = $(item).find('#customer_approve_icon');
            let customerBanned = $('#customerBanned_' + customerId);
            $.post("{{ URL::asset('/admin') }}/customers/block/" + customerId, {
                id: customerId,
                "_token": "{{ csrf_token() }}"
            }, function (data) {
                if (data.status == 'success') {
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
                    if (data.data == 1) {
                        iconSpan.removeClass('link-danger ri-indeterminate-circle-fill').addClass('ri-check-fill');
                        customerBanned.text('@lang('admin.yes')');
                    } else {
                        iconSpan.removeClass('ri-check-fill').addClass('link-danger ri-indeterminate-circle-fill');
                        customerBanned.text('@lang('admin.no')');
                    }
                }
            }, "json");
        }
    </script>
@endsection
