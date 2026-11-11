@if ($paginator->total() > 0)
    <nav aria-label="Navigasi halaman">
        <ul class="pagination pagination-luxury mb-0">
            {{-- Tombol Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="Sebelumnya">
                    <span class="page-link page-nav-btn" aria-hidden="true">
                        <i class="bi bi-chevron-left"></i>
                        <span class="d-none d-sm-inline">Sebelumnya</span>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link page-nav-btn" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya">
                        <i class="bi bi-chevron-left"></i>
                        <span class="d-none d-sm-inline">Sebelumnya</span>
                    </a>
                </li>
            @endif

            {{-- Nomor Halaman --}}
            @foreach ($elements as $element)
                {{-- Separator Titik Tiga --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Link Nomor Halaman --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol Selanjutnya --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link page-nav-btn" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Selanjutnya">
                        <span class="d-none d-sm-inline">Selanjutnya</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="Selanjutnya">
                    <span class="page-link page-nav-btn" aria-hidden="true">
                        <span class="d-none d-sm-inline">Selanjutnya</span>
                        <i class="bi bi-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
