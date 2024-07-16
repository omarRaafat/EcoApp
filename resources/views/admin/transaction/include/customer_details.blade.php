<div class="form-group row">
    <label for="customerName" class="col-sm-2 col-form-label">أسم العميل</label>
    <div class="col-sm-10">
        <input type="text" readonly class="form-control-plaintext" id="customerName" value="{{ $transaction->client->name ?? null   }}">
    </div>
</div>

<div class="form-group row">
    <label for="identity" class="col-sm-2 col-form-label">رقم الهوية</label>
    <div class="col-sm-10">
        <input type="text" readonly class="form-control-plaintext" id="identity" value="{{ $transaction->client->identity ?? null   }}">
    </div>
</div>

<div class="form-group row">
    <label for="mobile" class="col-sm-2 col-form-label">رقم الجوال</label>
    <div class="col-sm-10">
        <input type="text" readonly class="form-control-plaintext" id="mobile" value="{{ $transaction->client->phone ?? null   }}">
    </div>
</div>

<div class="form-group row">
    <label for="birthDate" class="col-sm-2 col-form-label">تاريخ الميلاد</label>
    <div class="col-sm-10">
        <input type="text" readonly class="form-control-plaintext" id="birthDate" value="{{ $transaction->client->birthDate ?? null   }}">
    </div>
</div>
