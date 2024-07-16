@extends('admin.layouts.master')
@section('title')
    @lang('admin.delivery.domestic-zones.title')
@endsection
@section('content')
    @if(session()->has('danger'))
        <div class="alert alert-danger"> {{ session('danger') }} </div>
    @endif
    @if(session()->has('success'))
        <div class="alert alert-success"> {{ session('success') }} </div>
    @endif
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <h5 class="card-title flex-grow-1 mb-0">
                            <i class="mdi mdi-map align-middle me-1 text-muted"></i> @lang('admin.delivery.domestic-zones.show-title')
                        </h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-right">

                        <div class="row">
                            @foreach(config('app.locales') AS $locale)
                            <p class="mb-3">
                                @lang("admin.delivery.domestic-zones.name")-@lang('language.'.$locale) :</b> {{ $domesticZone->getTranslation('name', $locale)}}
                            </p>

                            @endforeach
                        </div>

            
                        <p class="mb-3">@lang('admin.delivery.domestic-zones.delivery-type'): @lang('admin.'. $domesticZone->type)</p>
                        @if($domesticZone->type == \App\Enums\DomesticZone::NATIONAL_TYPE)
                            <p class="mb-3">
                                @lang('admin.delivery.domestic-zones.delivery_fees'): {{ $domesticZone->delivery_fees }} @lang('translation.sar')
                            </p>
                            <p class="mb-3">
                                @lang('admin.delivery.domestic-zones.delivery_fees_covered_kilos'): {{ $domesticZone->delivery_fees_covered_kilos }}
                            </p>
                            <p class="mb-3">
                                @lang('admin.delivery.domestic-zones.additional_kilo_price'): {{ $domesticZone->additional_kilo_price }} @lang('translation.sar')
                            </p>
                        @endif
                        <p class="mb-3">
                            @lang('admin.delivery.domestic-zones.days-from'): {{ $domesticZone->days_from }}
                        </p>
                        <p class="mb-3">
                            @lang('admin.delivery.domestic-zones.days-to'): {{ $domesticZone->days_to }}
                        </p>
                    </div>
                </div>
            </div>
            @if($domesticZone->type == \App\Enums\DomesticZone::INTERNATIONAL_TYPE)
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">
                                <i class="mdi mdi-cash align-middle me-1 text-muted"></i>
                                @lang('admin.delivery.domestic-zones.delivery-feeses.title')
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-right">
                            <p class="mb-3">@lang('admin.delivery.domestic-zones.delivery-feeses.download-desc')</p>
                            <p class="mb-3">@lang('admin.delivery.domestic-zones.delivery-feeses.download-validation-desc')</p>
                            <p class="mb-3">@lang('admin.delivery.domestic-zones.delivery-feeses.download-rows-desc')</p>
                            <a href="{{ route('admin.domestic-zones-delivery-fees.download-demo') }}" target="_blank">
                                @lang('admin.delivery.domestic-zones.delivery-feeses.download')
                            </a>
                            <form class="mt-3" enctype="multipart/form-data"
                                action="{{ route('admin.domestic-zones-delivery-fees.upload-sheet', ['domestic' => $domesticZone]) }}"
                                method="POST">
                                @csrf
                                <div class="form-group">
                                    <input name="delivery_fees_sheet" type="file" class="form-control" required/>
                                    @error('delivery_fees_sheet')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mt-3">
                                    <button class="btn btn-primary">
                                        @lang('admin.delivery.domestic-zones.delivery-feeses.upload')
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">
                        @if($domesticZone->type == \App\Enums\DomesticZone::NATIONAL_TYPE)
                            @lang('admin.delivery.domestic-zones.cities')
                        @else
                            @lang('admin.delivery.domestic-zones.countries')
                        @endif
                    </h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="row gy-4">
                        @if($domesticZone->type == \App\Enums\DomesticZone::NATIONAL_TYPE)
                            @foreach($domesticZone->cities ?? [] as $city)
                                <div class="col-md-2">
                                    <h5> {{ $city->getTranslation('name', 'ar') }} </h5>
                                </div>
                            @endforeach
                        @else
                            @foreach($domesticZone->countries ?? [] as $city)
                                <div class="col-md-2">
                                    <h5> {{ $city->getTranslation('name', 'ar') }} </h5>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @if($domesticZone->type == \App\Enums\DomesticZone::INTERNATIONAL_TYPE)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="3"> @lang('admin.delivery.domestic-zones.delivery-feeses.title') </th>
                        </tr>
                        <tr>
                            <th> @lang('admin.delivery.domestic-zones.delivery-feeses.weight-from') </th>
                            <th> @lang('admin.delivery.domestic-zones.delivery-feeses.weight-to') </th>
                            <th> @lang('admin.delivery.domestic-zones.delivery-feeses.delivery-fees') </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deliveryFeeses as $deliveryFees)
                            <tr>
                                <td> {{ $deliveryFees->weight_from }} @lang('translation.kilo') </td>
                                <td> {{ $deliveryFees->weight_to }} @lang('translation.kilo') </td>
                                <td> {{ $deliveryFees->delivery_fees }} @lang('translation.sar') </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $deliveryFeeses->links() }}
            @endif
        </div>
    </div>
@endsection
