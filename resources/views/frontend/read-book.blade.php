@extends('frontend.layout.app')

@section('title', 'Đọc Sách - ' . $book->name)

@section('content')
    <div class="read-book-page py-4">
        <div class="container-fluid">
            <!-- Header -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-1">{{ $book->name }}</h2>
                            <p class="text-muted mb-0">
                                <small>Tác giả: {{ $book->author }}</small>
                                @if ($rental)
                                    <span class="ms-3">
                                        <small>Hạn trả:
                                            {{ \Carbon\Carbon::parse($rental->due_at)->format('d/m/Y') }}</small>
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('book.detail', $book->slug) }}" class="btn btn-outline-secondary">
                                <i class="icon icon-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PDF Viewer -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <div id="pdf-viewer-container" style="height: calc(100vh - 200px); min-height: 400px;">
                                @if ($book->file)
                                    <iframe
                                        src="{{ asset('pdfjs/web/viewer.html') }}?file={{ urlencode(Storage::url("book_files/pdf/" . $book->file->original_name)) }}"
                                        style="width: 100%; height: 100vh; border: none;">
                                    </iframe>
                                @else
                                    <div class="alert alert-warning m-4">
                                        <p>Sách này chưa có file PDF.</p>
                                    </div>
                                @endif

                                <div>
                                    <button id="btn-fullscreen" class="btn btn-primary"
                                        style="position: absolute; bottom: 10px; right: 10px;">
                                        <i class="icon icon-maximize"></i> Toàn màn hình
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Khi vào fullscreen, iframe phải chiếm toàn bộ */
        #pdf-viewer-container:fullscreen iframe {
            width: 100% !important;
            height: 100% !important;
        }

        /* Vendor prefixes (hỗ trợ Safari, Firefox...) */
        #pdf-viewer-container:-webkit-full-screen iframe {
            width: 100% !important;
            height: 100% !important;
        }

        #pdf-viewer-container:-moz-full-screen iframe {
            width: 100% !important;
            height: 100% !important;
        }

        #pdf-viewer-container:-ms-fullscreen iframe {
            width: 100% !important;
            height: 100% !important;
        }
    </style>
@endpush

@push('scripts')
<script>
    $(function(){
        $('#download').hide();
    });
    </script>
    <script>
        document.getElementById("btn-fullscreen").addEventListener("click", function() {
            let elem = document.getElementById("pdf-viewer-container");

            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.webkitRequestFullscreen) {
                elem.webkitRequestFullscreen();
            } else if (elem.mozRequestFullScreen) {
                elem.mozRequestFullScreen();
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            }
        });
    </script>
@endpush

{{-- PDFJS Viewer --}}
