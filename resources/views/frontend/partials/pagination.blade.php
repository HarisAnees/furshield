@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="fs-pagination-container">
        {{-- Results Counter / Summary --}}
        <div class="fs-pagination-summary">
            Showing <span>{{ $paginator->firstItem() }}</span> to <span>{{ $paginator->lastItem() }}</span> of <span>{{ $paginator->total() }}</span> results
        </div>

        {{-- Controls Deck --}}
        <div class="fs-pagination-deck">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="fs-page-btn fs-page-nav fs-page-disabled" aria-disabled="true" aria-label="Previous Page">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="fs-page-icon"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    <span class="fs-page-label">Previous</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="fs-page-btn fs-page-nav" rel="prev" aria-label="Previous Page">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="fs-page-icon"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    <span class="fs-page-label">Previous</span>
                </a>
            @endif

            {{-- Numeric Page Links --}}
            <div class="fs-pagination-numbers">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="fs-page-dots" aria-disabled="true">{{ $element }}</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="fs-page-num active" aria-current="page">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="fs-page-num" aria-label="Go to page {{ $page }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="fs-page-btn fs-page-nav" rel="next" aria-label="Next Page">
                    <span class="fs-page-label">Next</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="fs-page-icon"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
            @else
                <span class="fs-page-btn fs-page-nav fs-page-disabled" aria-disabled="true" aria-label="Next Page">
                    <span class="fs-page-label">Next</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="fs-page-icon"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </span>
            @endif
        </div>
    </nav>
@endif
