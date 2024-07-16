@if(session()->has('error'))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger"> {{ session()->get('error') }} </div>
        </div>
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger text-right mt-1">
        @foreach ($errors->all() as $error)
            <p style="margin:0">{{ $error }}</p>
        @endforeach
    </div>
@endif
@if(session()->has('success'))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-success"> {{ session()->get('success') }} </div>
        </div>
    </div>
@endif
@if(session()->has('warning'))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-warning"> {!! session()->get('warning') !!} </div>
        </div>
    </div>
@endif