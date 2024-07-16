@extends('admin.layouts.master')
@section('title')
    @lang('Invoice.create.label')
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex mb-3">
                    <h4 class="card-title mb-0 flex-grow-1">
                        @lang('Invoice.create.label')
                    </h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.invoices.store') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row gy-4">
                            @include("admin.invoice.form")
                            <div class="col-md-12 mb-3">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary"> @lang('admin.save') </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function updateVendorList(checked) {
            const vendorSelect = document.getElementById('vendor_select2_is_active');
            if (checked) {
                vendorSelect.setAttribute("disabled", checked);
            } else {
                vendorSelect.removeAttribute('disabled')
            }

        }
    </script>
@endsection
