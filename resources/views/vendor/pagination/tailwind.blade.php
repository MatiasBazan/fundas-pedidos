@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">

        {{-- Mobile: prev / next only --}}
        <div class="flex gap-2 items-center justify-between sm:hidden py-4 px-2">

            @if ($paginator->onFirstPage())
                <span class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-300 cursor-not-allowed">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-600 hover:border-[#FF2D6B] hover:text-[#FF2D6B] transition">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                   class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-600 hover:border-[#FF2D6B] hover:text-[#FF2D6B] transition">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-300 cursor-not-allowed">
                    {!! __('pagination.next') !!}
                </span>
            @endif

        </div>

        {{-- Desktop --}}
        <div class="hidden sm:flex sm:items-center sm:justify-between py-4 px-2">

            <p class="text-sm text-gray-400">
                {!! __('Showing') !!}
                @if ($paginator->firstItem())
                    <span class="font-medium text-gray-600">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="font-medium text-gray-600">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                {!! __('of') !!}
                <span class="font-medium text-gray-600">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>

            <div class="flex items-center gap-1">

                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                        <span class="inline-flex items-center border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-300 cursor-not-allowed" aria-hidden="true">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                       class="inline-flex items-center border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-600 hover:border-[#FF2D6B] hover:text-[#FF2D6B] transition"
                       aria-label="{{ __('pagination.previous') }}">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @endif

                {{-- Page numbers --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-400 cursor-default">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page"
                                      class="inline-flex items-center bg-[#FF2D6B] text-white border border-[#FF2D6B] rounded-lg px-3 py-1.5 text-sm font-medium cursor-default">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                   class="inline-flex items-center border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-600 hover:border-[#FF2D6B] hover:text-[#FF2D6B] transition"
                                   aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                       class="inline-flex items-center border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-600 hover:border-[#FF2D6B] hover:text-[#FF2D6B] transition"
                       aria-label="{{ __('pagination.next') }}">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @else
                    <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                        <span class="inline-flex items-center border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-300 cursor-not-allowed" aria-hidden="true">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </span>
                @endif

            </div>
        </div>
    </nav>
@endif
