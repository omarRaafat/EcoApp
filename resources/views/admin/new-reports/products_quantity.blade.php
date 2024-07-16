@extends('admin.layouts.master')
@section('title')
    @lang('admin.reports.product_quantity')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
@include('sweetalert::alert')
@if(session()->has('error'))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger">{{ session("error") }}</div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="reports">
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form action="{{ route("admin.reports.products_quantity") }}">
                    <div class="row g-3">
                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input name="id" type="text" class="form-control search"
                                       placeholder="@lang("admin.reports.search_id")" value="{{ request('id') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input name="vendor_name" type="text" class="form-control search"
                                       placeholder="@lang("admin.reports.search_vendor_name")"  value="{{ request('vendor_name') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input name="stock" type="text" class="form-control search"
                                       placeholder="@lang("admin.reports.search_stock")" value="{{ request('stock') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input name="product_name" type="text" class="form-control search"
                                       placeholder="@lang("admin.reports.search_product_name")" value="{{ request('product_name') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-xxl-1 col-sm-4">
                            <div>
                                <button type="submit" class="btn btn-secondary w-100" onclick="SearchData();"><i
                                        class="ri-equalizer-fill me-1 align-bottom"></i>
                                        @lang("admin.reports.filter")
                                </button>
                            </div>
                        </div>
                        <div class="col-xxl-1 col-sm-4">
                            <div>
                                <a href="{{route('admin.reports.products_quantity')}}" class="btn btn-info w-100"><i
                                        class="ri-equalizer-fill me-1 align-bottom"></i>
                                        @lang("admin.warehouses.reset")
                                </a>
                            </div>
                        </div>

                        <div class="col-xxl-1 col-sm-4">
                            <div>
                                <a href="{{ route('admin.reports.products_quantity' , ['export_excel'=>true, 'id' => request()->get('id') , 'vendor_name' => request()->get('vendor_name') ,'product_name' => request()->get('product_name') , 'stock' => request()->get('stock') ]) }}" class="btn btn-primary">Excel تصدير</a>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </form>

            </div>
            <br>
            <div class="card-body">
                <div>
                    <div class="table-responsive table-card mb-1">
                        <table class="table table-nowrap align-middle" id="warehousesTable">
                            <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                <th># المعرف</th>
                                <th> أسم المتجر</th>
                                <th>أسم المنتج</th>
                                <th>الكمية</th>
                            </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->vendor->name }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td> {{ $product->stock }}
                                             @if($product->vendor->stock_system == 0)
                                                    @foreach ($product->warehouseStock as $item)
                                                     ( &nbsp{{ $item->warehouse->name ?? NULL }} = {{ $item->stock ?? 0 }} &nbsp) &nbsp;
                                                    @endforeach
                                              @endif
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                <!-- End Delete Modal -->
                @if($products->isEmpty())
                    <div class="noresult">
                        <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                           colors="primary:#25a0e2,secondary:#0ab39c"
                                           style="width:75px;height:75px">
                                </lord-icon>
                                <h5 class="mt-2">@lang('admin.reports.no_result_found')</h5>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        {{ $products->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
