@extends('admin.layouts.master')
@section('title')
    @lang('admin.certificates')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('admin.certificate_request_vendor')</th>
                                <th scope="col">@lang('admin.certificate_request_file')</th>
                                <th scope="col">@lang('admin.certificate_request_expire')</th>
                                <th scope="col">@lang('admin.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($certificate_requests as $certificate_request)
                                <tr id="request_{{ $certificate_request->id }}">
                                    <td>{{ $certificate_request->id }}</td>
                                    <td>{{ $certificate_request->vendor->name }}</td>
                                    <td><a target="_blank" href="{{ URL::asset($certificate_request->certificate_file) }}">@lang('admin.certificate_download')</a></td>
                                    <td>{{ date('d-m-Y h:i', strtotime($certificate_request->expire_date )) }}</td>
                                    <td>
                                        <div class="hstack gap-3 flex-wrap">
                                            @if($certificate_request->approval != 'approved')
                                            <a href="javascript:void(0);" onclick="requestApprove('{{ $certificate_request->id }}',this);" class="fs-15 link-success">
                                                <i class="ri-checkbox-circle-fill"></i>
                                            </a>
                                            @endif
                                            <a href="javascript:void(0);" onclick="requestReject('{{ $certificate_request->id }}',this);" class="fs-15 link-danger">
                                                <i class="ri-indeterminate-circle-fill"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $certificate_requests->links() }}
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
        function requestApprove(certificate_request, item)
        {
            $.post("{{ URL::asset('/admin') }}/certificates/approve/" + certificate_request, {
                id: certificate_request,
                "_token": "{{ csrf_token() }}"
            }, function (data) {
                if (data.status == 'success')
                {
                    Swal.fire({
                        html: '<div class="mt-3">' +
                            '<div class="mt-4 pt-2 fs-15">' +
                            '<h4>@lang('admin.certificate_approve')</h4>' +
                            '</div>' +
                            '</div>',
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 1000
                    });
                    $(item).remove();
                }
            }, "json");
        }
        function requestReject(certificate_request, item)
        {
            $.post("{{ URL::asset('/admin') }}/certificates/reject/" + certificate_request, {
                id: certificate_request,
                "_token": "{{ csrf_token() }}"
            }, function (data) {
                if (data.status == 'success')
                {
                    Swal.fire({
                        html: '<div class="mt-3">' +
                            '<div class="mt-4 pt-2 fs-15">' +
                            '<h4>@lang('admin.certificate_reject')</h4>' +
                            '</div>' +
                            '</div>',
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 1000
                    });
                    $('#request_'+certificate_request).remove();
                }
            }, "json");
        }
    </script>
@endsection
