@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        <ul class="flex items-center space-x-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-3 py-1 rounded-md bg-gray-100 text-gray-400 cursor-not-allowed">
                        &laquo;
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" 
                       class="px-3 py-1 rounded-md bg-orange-100 text-orange-600 hover:bg-orange-200 transition-colors">
                        &laquo;
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span class="px-3 py-1 rounded-md bg-gray-100 text-gray-600">
                            {{ $element }}
                        </span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="px-3 py-1 rounded-md bg-orange-500 text-white">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" 
                                   class="px-3 py-1 rounded-md bg-orange-100 text-orange-600 hover:bg-orange-200 transition-colors">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" 
                       class="px-3 py-1 rounded-md bg-orange-100 text-orange-600 hover:bg-orange-200 transition-colors">
                        &raquo;
                    </a>
                </li>
            @else
                <li>
                    <span class="px-3 py-1 rounded-md bg-gray-100 text-gray-400 cursor-not-allowed">
                        &raquo;
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif