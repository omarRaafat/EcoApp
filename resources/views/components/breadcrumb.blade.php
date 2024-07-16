<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $li_1 }}</a></li>
                    @if(isset($link_name))
                        <li class="breadcrumb-item"><a href="{{$link}}">{{ $link_name }}</a></li>
                    @endif
                    @if(isset($breadcrumbParent))
                        <li class="breadcrumb-item">
                            <a href="@if(isset($breadcrumbParentUrl)){{$breadcrumbParentUrl}}@endif">
                                {{ __('breadcrumb.'. $breadcrumbParent) }}
                            </a>
                        </li>
                    @endif
                    @if(isset($title))
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    @endif
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
