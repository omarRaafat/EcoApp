@if ($paginator->hasPages())
<ul class="pagination" >
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <li class=" disabled "><span class="page-link">&laquo;</span></li>
    @else
        <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}&search={{request()->get('search')}}&status={{request()->get('status')}}&inspector_id={{request()->get('inspector_id')}}&updated_at={{request()->get('updated_at')}}&region_id={{request()->get('region_id')}}&city_id={{request()->get('city_id')}}" rel="prev">&laquo;</a></li>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <li class="page-item disabled active"><span class="page-link">{{ $element }}</span></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}&search={{request()->get('search')}}&status={{request()->get('status')}}&inspector_id={{request()->get('inspector_id')}}&updated_at={{request()->get('updated_at')}}&region_id={{request()->get('region_id')}}&city_id={{request()->get('city_id')}}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}&search={{request()->get('search')}}&status={{request()->get('status')}}&inspector_id={{request()->get('inspector_id')}}&updated_at={{request()->get('updated_at')}}&region_id={{request()->get('region_id')}}&city_id={{request()->get('city_id')}}" rel="next">&raquo;</a></li>
    @else
        <li class="page-item "><span class="page-link">&raquo;</span></li>
    @endif
</ul>

@endif


