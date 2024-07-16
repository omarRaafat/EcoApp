@extends('admin.layouts.master')
@section('title')
    @lang("admin.recipes.show")
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="card-header  border-0">
            <div class="d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">
                    @lang("admin.recipes.show"):
                </h5>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xxl-5">
            <div class="card">
                <div class="row g-0">
                    <div class="col-lg-12">
                        <div class="card-body border-end">

                            <b>@lang("admin.recipes.image_for_show")</b>
                            @if (!empty($recipe->media))
                            <a href="{{ $recipe->image_url }}" target="_blanck">
                                <a href="{{ $recipe->getFirstMediaUrl('recipes', 'cover') }}" target="_blanck">
                                    <img src="{{ $recipe->getFirstMediaUrl('recipes', 'thumb') }}" alt="{{ $recipe->name }}">
                                </a>
                            @else
                                <img src="{{ url("images/noimage.png") }}" alt="{{ $recipe->name }}" width="160" height="100">
                            @endif

                            <div class="row">
                                @foreach(config('app.locales') AS $locale)
                                <div class="card-body border-end">
                                    <b>@lang("admin.recipes.title")-@lang('language.'.$locale)</b> {{ $recipe->getTranslation('title', $locale)}}
                                </div>

                                <div class="card-body border-end">
                                    <b>@lang("admin.recipes.short_desc")-@lang('language.'.$locale)</b> {{ $recipe->getTranslation('short_desc', $locale)}}
                                </div>

                                <div class="card-body border-end">
                                    <b>@lang("admin.recipes.body")-@lang('language.'.$locale)</b> {{ $recipe->getTranslation('body', $locale)}}
                                </div>


                                @endforeach
                            </div>



                            {{-- <b>@lang("admin.recipes.image_for_show")</b>
                            @if (!empty($recipe->media))
                            <a href="{{ $recipe->image_url }}" target="_blanck">
                                <a href="{{ $recipe->getFirstMediaUrl('recipes', 'cover') }}" target="_blanck">
                                    <img src="{{ $recipe->getFirstMediaUrl('recipes', 'thumb') }}" alt="{{ $recipe->name }}">
                                </a>
                            @else
                                <img src="{{ url("images/noimage.png") }}" alt="{{ $recipe->name }}" width="160" height="100">
                            @endif
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.recipes.title_ar")</b> {{ $recipe->getTranslation('title', 'ar') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.recipes.title_en")</b> {{ $recipe->getTranslation('title', 'en') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.recipes.short_desc_ar")</b> {{ $recipe->getTranslation('short_desc', 'ar') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.recipes.short_desc_en")</b> {{ $recipe->getTranslation('short_desc', 'en') }}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.recipes.body_ar")</b> {!! $recipe->getTranslation('body', 'ar') !!}
                        </div>
                        <div class="card-body border-end">
                            <b>@lang("admin.recipes.body_en")</b> {!! $recipe->getTranslation('body', 'en') !!}

                        </div> --}}





                        <div class="card-body border-end">
                            <b>@lang("admin.recipes.most_visited")</b>
                            <span class="{{ \App\Enums\CategoryIsActiveStatus::getStatusWithClass($recipe->most_visited)["class"] }}">
                                {{ \App\Enums\CategoryIsActiveStatus::getStatusWithClass($recipe->most_visited)["name"] }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('assets/js/pages/ecommerce-order.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2_customer').select2({
                placeholder: "Select",
                allowClear: true
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select2_is_active').select2({
                placeholder: "Select",
                allowClear: true
            });

        });
    </script>
@endsection
