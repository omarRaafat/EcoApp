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
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.certificates')</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route("admin.certificates.create") }}" class="btn btn-primary add-btn" id="create-btn">
                                    <i class="ri-add-line align-bottom me-1"></i>  @lang("admin.add")
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('admin.certificate_title')</th>
                                <th scope="col">@lang('admin.certificate_image')</th>
                                <th scope="col">@lang('admin.certificate_requests')</th>
                                <th scope="col">@lang('admin.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($certificates as $certificate)
                                <tr>
                                    <td>{{ $certificate->id }}</td>
                                    <td>{{ $certificate->title }}</td>
                                    <td>
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="{{ URL::asset($certificate->image) }}" class="avatar-xs rounded-circle">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a @if($certificate->requests()->whereIn('approval', ['pending','approved'])->count())
                                            href="{{ route('admin.certificates.requests', ['certificate' => $certificate]) }}" @endif>
                                            @if ($certificate->requests()->whereIn('approval', ['pending','approved'])->count() > 0)
                                                @lang('admin.certificates_number'): {{ $certificate->requests()->whereIn('approval', ['pending','approved'])->count() }}
                                            @else
                                                @lang('admin.no_certificates')
                                            @endif
                                        </a>
                                    </td>
                                    <td>
                                        <div class="hstack gap-3 flex-wrap">
                                            <a href="{{ route('admin.certificates.edit', ['certificate' => $certificate]) }}" class="fs-15 link-success">
                                                <i class="ri-edit-2-line"></i>
                                            </a>
                                            <a href="{{ route('admin.certificates.delete', ['certificate' => $certificate]) }}" class="fs-15 link-danger">
                                                <i class="ri-delete-bin-line"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $certificates->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
