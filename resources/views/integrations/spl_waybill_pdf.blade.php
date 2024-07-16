<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MOUZARE SHIPPING WAYBILL</title>
</head>
<body>
    <div class="row">
<div class="header">    
    <div style="float:right; width:50%" class="col-2">
        <img width="50px"  src="{{asset('images/spl_logo.png')}}">
    </div>  
    <div style="float:left; width:50%" class="col-8">
        <img width="50px" src="{{asset('images/logo.png')}}">

        <div>
</div>

    </div>

    <div class="row" style="overflow: auto">
        {{-- <div style="margin-left:201px;"> --}}

            {{-- <div style="display: flex; justify-content: space-between;">
                <img src="{{asset('images/spl_logo.png')}}" alt="Left Image" style="order: 1;width:50%">
                <img src="{{asset('images/logo.png')}}" alt="Right Image" style="order: 2;">
            </div> --}}
        {{-- </div> --}}
        <div style="float:right;">
            <p style="font-weight: 600">Shipment Date:
                <span style="color: #949191">{{ $order->created_at }}</span>
            </p>
        </div>
    </div>
    <hr>
    <div class="row">
        <p >From: </p>
         <p style="margin-left: 30px"><b>- Sender Name: </b>{{ $warehouse->administrator_name }}</p>
         <p style="margin-left: 30px"><b>- Sender Phone: </b>{{ $warehouse->administrator_phone }}</p>
         <p style="margin-left: 30px"><b>- Address: <b>{{ $warehouse->address }}</b></p>
         <p style="margin-left: 30px"><b>- Latitude: </b>{{ $warehouse->latitude }}</p>
         <p style="margin-left: 30px"><b>- Longitude: </b>{{ $warehouse->longitude }}</p>
    </div>
    <hr>
    <div class="row">
        <p> To: </p> 
        <p style="margin-left: 30px"><b>- Received name: </b>{{ $order->transaction->client->name }}</p>
        <p style="margin-left: 30px"><b>- Received phone: </b>{{ $order->transaction->client->phone }}</p>
        <p style="margin-left: 30px"><b>- Country: </b>{{ $order->transaction->city->area->country->name }}</p>
        <p style="margin-left: 30px"><b>- AddressLine1: </b>{{ $order->transaction->city->name }}</p>
        <p style="margin-left: 30px"><b>- AddressLine2: </b>{{ $order->transaction->city->name }}</p>
    </div>
    <hr>
    <div class="row">
        <p style="margin-left: 30px"> Total Weight Of Package ( kilo ): {{$orderVendorShipping->total_weight}} </p>
    </div>
    <div class="row">
        <p style="margin-left: 30px"> Number Of Pieces: {{$orderVendorShipping->no_of_products}}  </p>
    </div>
    <hr>
    <div class="row">
        <h3 style="margin-left: 30px">Tracking Number: <span>#{{ $tracking_id }}</span></h3>
    </div>
    <div class="row" style="margin-left: 30px">
        <img src="data:image/png;base64,{{ base64_encode($barcodeImage) }}" height="60" width="180" /><br />
    </div>
</body>
</html>
