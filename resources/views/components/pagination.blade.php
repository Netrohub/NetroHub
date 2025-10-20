<!-- NXO Pagination Component - Exact Design Specifications -->
@if ($paginator->hasPages())
    <nav class="flex items-center justify-between border-t border-border px-4 sm:px-0 mt-8">
        <div class="-mt-px flex w-0 flex-1">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-muted-foreground cursor-not-allowed">
                    <svg class="mr-3 h-5 w-5 text-muted-foreground" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('Previous') }}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-muted-foreground hover:text-primary hover:border-primary transition-colors">
                    <svg class="mr-3 h-5 w-5 text-muted-foreground" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('Previous') }}
                </a>
            @endif
        </div>

        <div class="hidden md:-mt-px md:flex">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-muted-foreground">
                        {{ $element }}
                    </span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="inline-flex items-center border-t-2 border-primary px-4 pt-4 text-sm font-medium text-primary">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-muted-foreground hover:text-primary hover:border-primary transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        <div class="-mt-px flex w-0 flex-1 justify-end">
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center border-t-2 border-transparent pt-4 pl-1 text-sm font-medium text-muted-foreground hover:text-primary hover:border-primary transition-colors">
                    {{ __('Next') }}
                    <svg class="ml-3 h-5 w-5 text-muted-foreground" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                </a>
            @else
                <span class="inline-flex items-center border-t-2 border-transparent pt-4 pl-1 text-sm font-medium text-muted-foreground cursor-not-allowed">
                    {{ __('Next') }}
                    <svg class="ml-3 h-5 w-5 text-muted-foreground" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif
