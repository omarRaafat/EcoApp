@if(auth()->user()->isAdminPermittedTo("admin.transactions.sub_orders.change_warehouse"))
    @php
        $order_product = \App\Models\OrderProduct::where('order_id', $orderVendorWarehouse->order_id)
            ->where('product_id',$orderVendorWarehouse->product_id)->first()??NULL;
    @endphp
        <!-- Start Change Warehouse Modal -->
    <div class="modal fade flip" id="changeWarehouse-{{$orderVendorWarehouse->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">
                    {{--                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"--}}
                    {{--                           colors="primary:#25a0e2,secondary:#00bd9d"--}}
                    {{--                           style="width:90px;height:90px">--}}
                    {{--                </lord-icon>--}}
                    <form
                        action="{{ route("admin.transactions.sub_orders.change_warehouse", $orderVendorWarehouse->id) }}"
                        method="post">
                        @csrf
                        <div class="mt-4 text-center">
                            <h4>@lang('translation.change_city.title')</h4>
                            <p class="text-muted fs-15 mb-4">@lang('translation.change_city.description')</p>
                            <di>
                                @lang('translation.change_city.current') :
                                {{$orderVendorWarehouse->warehouse->getTranslation('name','ar')}}
                                ({{ $order_product?$order_product->quantity:NULL }})
                            </di>
                            <div class="m-4 text-center">
                                <select name="warehouse_id" class="form-select form-select-lg mb-3"
                                        aria-label=".form-select-lg example">
                                    <option selected hidden>@lang('translation.change_city.menu')</option>
                                    @foreach(\App\Models\Warehouse::where('vendor_id', $orderVendorWarehouse->vendor_id)
                                                ->where('id', '!=', $orderVendorWarehouse->warehouse_id)->get() as $warehouse)
                                        @php
                                            $product = \App\Models\ProductWarehouseStock::where('product_id', $orderVendorWarehouse->product_id)
                                                                ->where('warehouse_id', $warehouse->id)->first();
                                        @endphp
                                        <option value="{{$warehouse->id}}"
                                                title="{{$warehouse->name}}">{{str($warehouse->name)->limit(45)}} -
                                            ({{filled($product) ?$product->stock : 0}})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="hstack gap-2 justify-content-center remove">
                                <button type="button" class="btn btn-link link-primary fw-medium text-decoration-none"
                                        data-bs-dismiss="modal" id="deleteRecord-close">
                                    <i class="ri-close-line me-1 align-middle"></i>
                                    @lang('admin.close')
                                </button>
                                <button type="submit" class="btn btn-primary" id="delete-record">
                                    @lang('translation.change_city.button')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Warehouse Modal -->
@endif
