@if ($paginator->hasPages())
<nav aria-label="Pagination" class="mt-4">
    <ul class="pagination justify-content-center">

        {{-- Previous --}}
        <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            <a class="custom-page-link"
               href="{{ $paginator->previousPageUrl() ?? '#' }}">
                &lsaquo;
            </a>
        </li>

        {{-- Pages --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled">
                    <span class="custom-page-link">{{ $element }}</span>
                </li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                        <a class="custom-page-link" href="{{ $url }}">
                            {{ $page }}
                        </a>
                    </li>
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
            <a class="custom-page-link"
               href="{{ $paginator->nextPageUrl() ?? '#' }}">
                &rsaquo;
            </a>
        </li>

    </ul>
</nav>
@endif
@push('css')
<style>
.custom-page-link {
    display: flex;
    align-items: center;
    justify-content: center;

    min-width: 38px;
    height: 38px;
    padding: 0 12px;

    color: #0d6efd;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;

    text-decoration: none;
    cursor: pointer;

    position: relative;
    z-index: 5;
}

.custom-page-link:hover {
    background-color: #e9ecef;
    color: #0a58ca;
}

.page-item.active .custom-page-link {
    background-color: #0d6efd;
    color: #fff;
    border-color: #0d6efd;
    cursor: default;
}

.page-item.disabled .custom-page-link {
    color: #6c757d;
    background-color: #f8f9fa;
    border-color: #dee2e6;
    cursor: not-allowed;
    pointer-events: none;
}
</style>
@endpush
