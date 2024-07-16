<div class="col-lg-10">
    <p class="text-muted mb-2 text-uppercase fw-semibold">بيانات المشتري</p>
    <p class="text-muted mb-2 text-uppercase fw-semibold"> المشتري : {{$transaction->client->name}}</p>
    <p class="text-muted mb-2 text-uppercase fw-semibold"> الجوال : {{$transaction->client->phone}}</p>
</div><!--end col-->
<div class="col-2">
    <p class="text-muted mb-2 text-uppercase fw-semibold">@lang("admin.payment_method")</p>
    <span class="badge badge-soft-success fs-11" id="payment-status">
        {{ $transaction->getPaymentMethod() }}
    </span>
</div><!--end col-->