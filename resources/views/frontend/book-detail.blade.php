@extends('frontend.layout.app')

@section('title', 'Đọc Sách - ' . $book->name)

@section('content')
    @php
        use Illuminate\Support\Facades\Storage;
    @endphp

    <div class="book-detail-page py-5">
        <div class="container">
            <div class="row">
                <!-- Left Panel: Book Cover and Actions -->
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="book-cover-section">
                        <!-- Book Cover -->
                        <div class="book-cover-wrapper mb-3">
                            <img src="{{ Storage::url($book->images->first()->url ?? '') }}" alt="{{ $book->name }}"
                                class="img-fluid rounded shadow-sm" style="max-width: 100%; height: auto;">
                        </div>

                        <!-- Preview Button -->
                        {{-- <button class="btn btn-primary w-100 mb-3" style="background-color: #0066cc;">
                            <i class="icon icon-book"></i> Xem trước
                        </button> --}}

                        <!-- Status Buttons -->
                        <div class="status-buttons mb-3">
                            @php
                                $rental = $book->rentals()
                                    ->where('user_id', Auth::id())
                                    ->where('status', 'active')
                                    ->where('due_at', '>=', now())
                                    ->with('payments')
                                    ->first();

                                $hasPaid = $rental && $rental->payments()->where('status', 'paid')->exists();
                            @endphp

                            @if ($rental && $hasPaid)
                                <a href="{{ route('book.read', $book->slug) }}" class="btn btn-primary w-100">
                                    <i class="icon icon-book"></i> Đọc sách
                                </a>
                                <small class="text-muted d-block mt-2 text-center">
                                    Hạn trả: {{ \Carbon\Carbon::parse($rental->due_at)->format('d/m/Y') }}
                                </small>
                            @elseif ($rental && !$hasPaid)
                                <button class="btn btn-warning w-100" disabled>
                                    <i class="icon icon-clock"></i> Chờ thanh toán
                                </button>
                            @else
                                <form action="{{ route('book.rental.create', $book->slug) }}" method="GET">
                                    <button class="btn btn-primary w-100" type="submit">
                                        <i class="icon icon-cart"></i> Mượn sách
                                    </button>
                                </form>
                            @endif
                        </div>

                        <!-- User Rating -->
                        <div class="user-rating mb-3">
                            <label class="form-label">Đánh giá của bạn:</label>
                            <div class="star-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="star" data-rating="{{ $i }}"
                                        style="font-size: 24px; color: #ddd; cursor: pointer;">★</span>
                                @endfor
                            </div>
                        </div>

                        <!-- Action Icons -->
                        <div class="action-icons">
                            <div class="d-flex flex-column gap-2">
                                {{-- <button class="btn btn-outline-secondary btn-sm">
                                    <i class="icon icon-pencil"></i> Đánh giá
                                </button> --}}
                                {{-- <button class="btn btn-outline-secondary btn-sm">
                                    <i class="icon icon-note"></i> Ghi chú
                                </button> --}}
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="icon icon-share"></i> Chia sẻ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Panel: Book Information -->
                <div class="col-md-8 col-lg-9">
                    <!-- Navigation Tabs -->
                    <ul class="nav nav-tabs mb-4" id="bookDetailTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab"
                                data-bs-target="#overview" type="button" role="tab">
                                Tổng quan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                                type="button" role="tab">
                                Chi tiết
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                                type="button" role="tab">
                                Đánh giá ({{ $book->reviews->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="related-tab" data-bs-toggle="tab" data-bs-target="#related"
                                type="button" role="tab">
                                Sách liên quan
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="bookDetailTabContent">
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            <!-- Book Title and Author -->
                            <div class="book-header mb-4">
                                <h1 class="book-title mb-2">{{ $book->name }}</h1>
                                <p class="book-author mb-3">
                                    bởi <a href="#" class="text-decoration-none">{{ $book->author }}</a>
                                </p>

                                <!-- Rating and Engagement -->
                                <div class="rating-section mb-3">
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <div class="rating-stars">
                                            @php
                                                $fullStars = floor($avgRating);
                                                $halfStar = $avgRating - $fullStars >= 0.5;
                                            @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $fullStars)
                                                    <span style="color: #ffc107; font-size: 20px;">★</span>
                                                @elseif($i == $fullStars + 1 && $halfStar)
                                                    <span style="color: #ffc107; font-size: 20px;">☆</span>
                                                @else
                                                    <span style="color: #ddd; font-size: 20px;">★</span>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="rating-text">
                                            <strong>{{ number_format($avgRating, 1) }}</strong>
                                            ({{ $ratingCount }} đánh giá)
                                        </span>
                                    </div>
                                    <div class="engagement-stats text-muted">
                                        <span>({{ $book->rentals->count() }}) Đã mượn</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="book-description mb-4">
                                <h3 class="h5 mb-3">Mô tả</h3>
                                <p class="text-muted">
                                    {{ $book->summary ?? 'Chưa có mô tả cho cuốn sách này.' }}
                                </p>
                                @if (strlen($book->summary ?? '') > 300)
                                    <a href="#" class="read-more-link">Đọc thêm</a>
                                @endif
                            </div>

                            <!-- Publication Details -->
                            <div class="publication-details mb-4">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <div class="detail-box p-3 border rounded">
                                            <div class="detail-label text-muted small mb-1">Ngày xuất bản</div>
                                            <div class="detail-value">{{ $book->year ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="detail-box p-3 border rounded">
                                            <div class="detail-label text-muted small mb-1">Nhà xuất bản</div>
                                            <div class="detail-value">
                                                <a href="#"
                                                    class="text-decoration-none">{{ $book->publisher ?? 'N/A' }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="detail-box p-3 border rounded">
                                            <div class="detail-label text-muted small mb-1">Ngôn ngữ</div>
                                            <div class="detail-value">
                                                <a href="#" class="text-decoration-none">Tiếng Việt</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="detail-box p-3 border rounded">
                                            <div class="detail-label text-muted small mb-1">Trạng thái</div>
                                            <div class="detail-value">
                                                @if ($book->rentals->where('status', 'active')->count() > 0)
                                                    <span class="badge bg-warning">Đang mượn</span>
                                                @elseif($book->file)
                                                    <span class="badge bg-success">Có sẵn</span>
                                                @elseif(!$book->file)
                                                    <span class="badge bg-danger">Không có sách</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Categories -->
                            @if ($book->categories->count() > 0)
                                <div class="book-categories mb-4">
                                    <h3 class="h6 mb-2 text-black">Danh mục:</h3>
                                    <div class="category-tags">
                                        @foreach ($book->categories as $category)
                                            <a href="#" class="badge bg-secondary text-muted me-2 mb-2">
                                                {{ $category->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Details Tab -->
                        <div class="tab-pane fade" id="details" role="tabpanel">
                            <div class="book-details">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th width="200">Tên sách</th>
                                            <td>{{ $book->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tác giả</th>
                                            <td>{{ $book->author }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nhà xuất bản</th>
                                            <td>{{ $book->publisher ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Năm xuất bản</th>
                                            <td>{{ $book->year ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Danh mục</th>
                                            <td>
                                                @foreach ($book->categories as $category)
                                                    <span
                                                        class="badge bg-secondary text-muted me-1">{{ $category->name }}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Số lượt mượn</th>
                                            <td>{{ $book->rentals->count() }}</td>
                                        </tr>
                                        <tr>
                                            <th>Số đánh giá</th>
                                            <td>{{ $book->reviews->count() }}</td>
                                        </tr>
                                        <tr>
                                            <th>Đánh giá trung bình</th>
                                            <td>{{ number_format($avgRating, 1) }}/5.0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="reviews-section">
                                @if ($book->reviews->count() > 0)
                                    @foreach ($book->reviews as $review)
                                        <div class="review-item border-bottom pb-3 mb-3">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <strong>{{ $review->user->name ?? 'Người dùng' }}</strong>
                                                    <div class="review-rating">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $review->rating)
                                                                <span style="color: #ffc107; font-size: 14px;">★</span>
                                                            @else
                                                                <span style="color: #ddd; font-size: 14px;">★</span>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                </div>
                                                <small
                                                    class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                            </div>
                                            @if ($review->comment)
                                                <p class="mb-0">{{ $review->comment }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-muted">Chưa có đánh giá nào cho cuốn sách này.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Related Books Tab -->
                        <div class="tab-pane fade" id="related" role="tabpanel">
                            <div class="related-books">
                                @foreach ($relatedBooks as $relatedBook)
                                    <div class="related-book col-md-3">
                                        <a href="{{ route('book.detail', $relatedBook->slug) }}">
                                            <img src="{{ Storage::url($relatedBook->images->first()->url ?? '') }}"
                                                alt="{{ $relatedBook->name }}" class="img-fluid rounded shadow-sm">
                                        </a>
                                        <h3>{{ $relatedBook->name }}</h3>
                                        <p>Tác giả: {{ $relatedBook->author }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .book-detail-page {
                background-color: #f8f9fa;
                min-height: 100vh;
            }

            .book-cover-wrapper img {
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .book-title {
                font-size: 2.5rem;
                font-weight: bold;
                color: #333;
            }

            .book-author {
                font-size: 1.2rem;
                color: #666;
            }

            .nav-tabs .nav-link {
                color: #666;
                border: none;
                border-bottom: 2px solid transparent;
            }

            .nav-tabs .nav-link.active {
                color: #0066cc;
                border-bottom: 2px solid #0066cc;
                background: none;
            }

            .detail-box {
                background: white;
                transition: transform 0.2s;
            }

            .detail-box:hover {
                transform: translateY(-2px);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .star-rating .star:hover {
                color: #ffc107;
            }

            .star-rating .star.active {
                color: #ffc107;
            }

            .read-more-link {
                color: #0066cc;
                text-decoration: none;
            }

            .read-more-link:hover {
                text-decoration: underline;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Star rating interaction
            document.querySelectorAll('.star-rating .star').forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.getAttribute('data-rating');
                    const stars = this.parentElement.querySelectorAll('.star');

                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.classList.add('active');
                            s.style.color = '#ffc107';
                        } else {
                            s.classList.remove('active');
                            s.style.color = '#ddd';
                        }
                    });

                    // Here you can add AJAX call to save rating
                    console.log('Rating:', rating);
                });

                star.addEventListener('mouseenter', function() {
                    const rating = this.getAttribute('data-rating');
                    const stars = this.parentElement.querySelectorAll('.star');

                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.style.color = '#ffc107';
                        }
                    });
                });

                star.addEventListener('mouseleave', function() {
                    const stars = this.parentElement.querySelectorAll('.star');
                    stars.forEach(s => {
                        if (!s.classList.contains('active')) {
                            s.style.color = '#ddd';
                        }
                    });
                });
            });
        </script>
    @endpush

@endsection
