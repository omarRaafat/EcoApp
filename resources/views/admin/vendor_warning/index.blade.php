@extends('admin.layouts.master')
@section('title')
    @lang('admin.vendor_warnings')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="modal fade" id="AddVendorWarning" tabindex="-1" aria-labelledby="AddVendorWarningLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="AddVendorWarningLabel">@lang('admin.vendor_warning_new')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    <form id="vendorWarningForm">
                        @csrf
                        <input name="vendor_id" type="hidden" value="{{ $vendor->id }}"/>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">@lang('admin.vendor_warning')</label>
                            <textarea name="body" class="form-control" id="message-text"></textarea>
                            <span class="invalid-feedback" id="body_alert" role="alert"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('admin.close')</button>
                    <button onclick="addWarningSubmit();" type="button" class="btn btn-primary">@lang('admin.add')</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <!-- Varying Modal Content -->
                    @if (auth()->user()?->isAdminPermittedTo('admin.vendors.warnings.store'))

                    <div class="hstack gap-2 flex-wrap">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddVendorWarning">@lang('admin.vendor_warning_new_add')</button>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                           style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('admin.vendor_warning')</th>
                                <th scope="col">@lang('admin.vendor_warning_date')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vendorWarnings as $vendorWarning)
                                <tr>
                                    <td>{{ $vendorWarning->id }}</td>
                                    <td>{{ $vendorWarning->body }}</td>
                                    <td>{{ $vendorWarning->created_at->todatestring() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
        function addWarningSubmit()
        {
            var form = $('#vendorWarningForm');
            $.post('{{ route('admin.vendors.warnings.store') }}', form.serialize()
            , function(data) {
                if (data.status == 'success')
                {
                    Swal.fire({
                        html: '<div class="mt-3">' +
                            '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>' +
                            '<div class="mt-4 pt-2 fs-15">' +
                            '<h4>' + data.message + '</h4>' +
                            '</div>' +
                            '</div>',
                        showCancelButton: false,
                        showConfirmButton: false,
                        buttonsStyling: false,
                        showCloseButton: true
                    });

                    setInterval(function () {location.reload();}, 1000);
                }
                else
                {
                    $('#body_alert').css('display','block').html('<strong>'+data.message+'</strong>');
                }
            },'json');
            form.trigger('reset');
        }

        $('#AddVendorWarning').on('hidden.bs.modal', function () {
            $('#vendorWarningForm').trigger('reset');
            $('#body_alert').removeAttr('style')
        });
    </script>
@endsection
