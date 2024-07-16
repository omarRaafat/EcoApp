<div class="col-lg-10">
    <p class="text-muted mb-2 text-uppercase fw-semibold">بيانات المشتري</p>
    <p class="text-muted mb-2 text-uppercase fw-semibold"> المشتري : {{$order->transaction->client->name}}</p>
    <p class="text-muted mb-2 text-uppercase fw-semibold"> الجوال : {{$order->transaction->client->phone}}</p>
</div><!--end col-->
