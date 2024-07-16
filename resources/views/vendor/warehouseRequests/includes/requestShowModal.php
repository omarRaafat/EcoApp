

<div class="modal fade bs-example-modal-center bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5 row">
                <div class="col-xl-12">
                    <div class="sticky-side-div">
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <h5 class="card-title mb-0">Order Summary</h5>
                            </div>
                            <div class="card-header bg-soft-light border-bottom-dashed">
                                <div class="text-center">
                                    <h6 class="mb-2">Have a <span class="fw-semibold">promo</span> code ?</h6>
                                </div>
                                <div class="hstack gap-3 px-3 mx-n3">
                                    <input class="form-control me-auto" type="text" placeholder="Enter coupon code"
                                        aria-label="Add Promo Code here...">
                                    <button type="button" class="btn btn-primary w-xs">Apply</button>
                                </div>
                            </div>
                            <div class="card-body pt-2">
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <td>@lang('admin.wareHouseRequests.id') :</td>
                                                <td class="text-end" id="cart-subtotal">{{ $vendorRequest->id }}</td>
                                            </tr>
                                            <tr>
                                                <td>@lang("admin.wareHouseRequests.vendor") <span class="text-muted"></span> : </td>
                                                <td class="text-end" id="cart-discount">{{ $vendorRequest->request->vendor->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>@lang("translation.product_name") :</td>
                                                <td class="text-end" id="cart-shipping">{{ $vendorRequest->product->getTranslation('name', 'ar') }}</td>
                                            </tr>
                                            <tr>
                                                <td>@lang("admin.wareHouseRequests.qnt") : </td>
                                                <td class="text-end" id="cart-tax">{{ $vendorRequest->qnt }}</td>
                                            </tr>
                                            <tr>
                                                <td>@lang("admin.wareHouseRequests.mnfg_date") : </td>
                                                <td class="text-end" id="cart-tax">{{ $vendorRequest->mnfg_date }}</td>
                                            </tr>
                                            <tr>
                                                <td>@lang("admin.wareHouseRequests.expire_date") : </td>
                                                <td class="text-end" id="cart-tax">{{ $vendorRequest->expire_date }}</td>
                                            </tr>
                                            <tr class="table-active">
                                                <th>Total (USD) :</th>
                                                <td class="text-end">
                                                    <span class="fw-semibold" id="cart-total">
                                                        $415.96
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>

                        <div class="alert border-dashed alert-primary" role="alert">
                            <div class="d-flex align-items-center">
                                <lord-icon src="https://cdn.lordicon.com/nkmsrxys.json" trigger="loop"
                                    colors="primary:#121331,secondary:#25a0e2" style="width:80px;height:80px">
                                </lord-icon>
                                <div class="ms-2">
                                    <h5 class="fs-14 text-primary fw-semibold"> Buying for a loved one?</h5>
                                    <p class="text-black mb-1">Gift wrap and personalised message on card, <br />Only for <span
                                            class="fw-semibold">$9.99</span> USD</p>
                                    <button type="button" class="btn ps-0 btn-sm btn-link text-primary text-uppercase">Add Gift
                                        Wrap</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end stickey -->

                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->