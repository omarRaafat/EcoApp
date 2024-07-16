<div class="app-search d-none d-md-block" x-data="{ open: false }">
    <div class="position-relative">
        <input type="text" class="form-control" placeholder="{{ __('translation.search') }}" autocomplete="off"
            wire:model.live.debounce.950ms="search" @input="open = true" @keydown.escape.window="open = false"
            @click.away="open = false">
        <span class="mdi mdi-magnify search-widget-icon"></span>
        <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
            id="search-close-options"></span>

        <div x-show="open" class="card mt-3 shadow search-card" wire:loading.remove>
            <div class="card-body search-card-body" style="overflow-y: scroll; overflow-x:hidden;">
                @if (count($globalSearchResults) > 0)
                    @foreach ($globalSearchResults as $resultTitle => $globalSearchResult)
                        @if (count($globalSearchResult) > 0)
                            <div class="row mb-2 global-search-result-row">
                                <div class="result-header">
                                    <h5 class="title">{{ $resultTitle }}</h5>
                                </div>

                                @foreach ($globalSearchResult as $index => $result)
                                    <div class="result-body">
                                        {!! $result !!}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="d-flex justify-content-center m-auto">
                        <h5 class="text-center">لايوجد نتائج</h5>
                    </div>
                @endif
            </div>
        </div>

        <div class="card mt-3 shadow" wire:loading wire:target='search'
            style="width:500px;height:65px;position: absolute;top: 30px; border-radius: 0.4rem;">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
