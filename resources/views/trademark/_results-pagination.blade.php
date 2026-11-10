@php
    $current = $trademarks->currentPage();
    $last = $trademarks->lastPage();
    $pages = collect([1, $current - 1, $current, $current + 1, $last])
        ->filter(fn ($page) => $page >= 1 && $page <= $last)->unique()->sort()->values();
    $previousPageNumber = null;
@endphp
<div class="tm-results-pagination" data-results-pagination>
    <span class="tm-results-count">{{ number_format($trademarks->total()) }} results</span>
    <nav class="tm-results-pages" aria-label="Results pages {{ $position }}">
        @if($trademarks->onFirstPage())
            <span class="tm-page-disabled" aria-disabled="true" aria-label="Previous page">‹</span>
        @else
            <a href="{{ $trademarks->previousPageUrl() }}" data-results-page aria-label="Previous page">‹</a>
        @endif
        @foreach($pages as $page)
            @if($previousPageNumber !== null && $page > $previousPageNumber + 1)<span class="tm-page-gap" aria-hidden="true">…</span>@endif
            @if($page === $current)
                <span class="is-current" aria-current="page" aria-label="Page {{ $page }}">{{ $page }}</span>
            @else
                <a href="{{ $trademarks->url($page) }}" data-results-page aria-label="Page {{ $page }}">{{ $page }}</a>
            @endif
            @php($previousPageNumber = $page)
        @endforeach
        @if($current === $last)
            <a href="{{ $trademarks->url(1) }}" data-results-page>First</a>
        @else
            <a href="{{ $trademarks->url($last) }}" data-results-page>Last</a>
        @endif
        @if($trademarks->hasMorePages())
            <a href="{{ $trademarks->nextPageUrl() }}" data-results-page aria-label="Next page">›</a>
        @else
            <span class="tm-page-disabled" aria-disabled="true" aria-label="Next page">›</span>
        @endif
    </nav>
    <label class="tm-results-page-size">Show
        <select data-results-page-size aria-label="Results per page {{ $position }}">
            @foreach([25, 50, 100] as $size)
                <option value="{{ $size }}" @selected($trademarks->perPage() === $size)>{{ $size }}</option>
            @endforeach
        </select>
    </label>
</div>
