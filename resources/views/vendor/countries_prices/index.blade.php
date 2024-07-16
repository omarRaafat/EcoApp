@extends('admin.layouts.master')
@section('title')
    @lang('admin.countries_prices.title')
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
                                <th scope="col">@lang('admin.countries_prices.country')</th>
                                <th scope="col">@lang('translation.price') @lang('translation.sar')</th>
                                <th scope="col">@lang('translation.price_before_offer') @lang('translation.sar')</th>
                                <th scope="col">@lang('admin.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($countriesPrices as $countryPrice)
                                <tr>
                                    <td>{{ $countryPrice->id }}</td>
                                    <td>{{ $countryPrice->country?->name }}</td>
                                    <td>{{ $countryPrice->priceInSar }}</td>
                                    <td>{{ $countryPrice->priceBeforeInSar }}</td>
                                    <td>
                                        <div class="hstack gap-3 flex-wrap">
                                            <a href="{{ route("vendor.products.prices.edit", $countryPrice->id) }}" class="fs-15">
                                                <i class="ri-edit-2-line"></i>
                                            </a>
                                            <a class="text-danger d-inline-block remove-item-btn"
                                               data-bs-toggle="modal" href="#deletestaticcontent-{{ $countryPrice->id }}">
                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Start Delete Modal -->
                                <div class="modal fade flip" id="deletestaticcontent-{{ $countryPrice->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body p-5 text-center">
                                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                           colors="primary:#25a0e2,secondary:#00bd9d"
                                                           style="width:90px;height:90px">
                                                </lord-icon>
                                                <div class="mt-4 text-center">
                                                    <h4>@lang('admin.countries_prices.delete_modal.title')</h4>
                                                    <p class="text-muted fs-15 mb-4">@lang('admin.countries_prices.delete_modal.description')</p>
                                                    <div class="hstack gap-2 justify-content-center remove">
                                                        <button class="btn btn-link link-primary fw-medium text-decoration-none"
                                                                data-bs-dismiss="modal" id="deleteRecord-close">
                                                            <i class="ri-close-line me-1 align-middle"></i>
                                                            @lang('admin.close')
                                                        </button>
                                                        <form action="{{ route("vendor.products.prices.delete", $countryPrice->id) }}" method="post">
                                                            @csrf
                                                            @method("DELETE")
                                                            <button type="submit" class="btn btn-primary" id="delete-record">
                                                                @lang('admin.delete')
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Delete Modal -->
                            @endforeach
                        </tbody>
                    </table>
                    {{ $countriesPrices->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
