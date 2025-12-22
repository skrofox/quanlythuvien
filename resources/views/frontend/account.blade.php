@extends('frontend.layout.app')

@section('title', 'Tài khoản')

@section('content')
    <section class="py-5 my-4">
    <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="mb-1">Tài khoản của tôi</h2>
                    <p class="text-muted">Quản lý thông tin tài khoản, đơn hàng và sách yêu thích</p>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs mb-4" id="accountTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                        type="button" role="tab">
                        <i class="icon icon-user"></i> Thông tin
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reading-tab" data-bs-toggle="tab" data-bs-target="#reading"
                        type="button" role="tab">
                        <i class="icon icon-book"></i> Đang đọc
                        @if($readingBooks->count() > 0)
                            <span class="badge bg-primary">{{ $readingBooks->count() }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="favorites-tab" data-bs-toggle="tab" data-bs-target="#favorites"
                        type="button" role="tab">
                        <i class="icon icon-heart"></i> Yêu thích
                        @if($favorites->count() > 0)
                            <span class="badge bg-danger">{{ $favorites->count() }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="rentals-tab" data-bs-toggle="tab" data-bs-target="#rentals"
                        type="button" role="tab">
                        <i class="icon icon-clipboard"></i> Đơn hàng
                        @if($allRentals->count() > 0)
                            <span class="badge bg-info">{{ $allRentals->count() }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments"
                        type="button" role="tab">
                        <i class="icon icon-credit-card"></i> Thanh toán
                    </button>
                </li>
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content" id="accountTabsContent">
                <!-- Tab 1: Thông tin tài khoản -->
                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Thông tin tài khoản</h5>
                        </div>
                        <div class="card-body">
                            <!-- Thông tin hiển thị -->
                            <div id="profile-info">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th width="150">Họ tên:</th>
                                                <td id="display-name">{{ $user->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email:</th>
                                                <td id="display-email">{{ $user->email }}</td>
                                            </tr>
                                            {{-- <tr>
                                                <th>Vai trò:</th>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $user->role ?? 'user' }}</span>
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <th>Ngày đăng ký:</th>
                                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="stats-box">
                                            <h6>Thống kê</h6>
                                            <div class="row text-center">
                                                <div class="col-6 mb-3">
                                                    <div class="stat-item">
                                                        <div class="stat-number">{{ $allRentals->count() }}</div>
                                                        <div class="stat-label">Tổng đơn hàng</div>
                                                    </div>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <div class="stat-item">
                                                        <div class="stat-number">{{ $favorites->count() }}</div>
                                                        <div class="stat-label">Sách yêu thích</div>
                                                    </div>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <div class="stat-item">
                                                        <div class="stat-number">{{ $activeRentals->count() }}</div>
                                                        <div class="stat-label">Đang mượn</div>
                                                    </div>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <div class="stat-item">
                                                        <div class="stat-number">{{ $returnedRentals->count() }}</div>
                                                        <div class="stat-label">Đã trả</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="button" class="btn btn-primary" id="btn-edit-profile">
                                        <i class="icon icon-edit"></i> Chỉnh sửa thông tin
                                    </button>
                                </div>
                            </div>

                            <!-- Form chỉnh sửa -->
                            <div id="profile-edit-form" style="display: none;">
                                <form action="{{ route('profile.update') }}" method="POST" id="update-profile-form">
                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               id="name"
                                               name="name"
                                               value="{{ old('name', $user->name) }}"
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               id="email"
                                               name="email"
                                               value="{{ old('email', $user->email) }}"
                                               required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- <div class="mb-3">
                                        <label class="form-label">Vai trò</label>
                                        <div>
                                            <span class="badge bg-secondary">{{ $user->role ?? 'user' }}</span>
                                            <small class="text-muted d-block">Vai trò không thể thay đổi</small>
                                        </div>
                                    </div> --}}

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="icon icon-check"></i> Lưu thay đổi
                                        </button>
                                        <button type="button" class="btn btn-secondary" id="btn-cancel-edit">
                                            <i class="icon icon-close"></i> Hủy
                                        </button>
                                    </div>
                                </form>
                            </div>

                            @if(session('status') === 'profile-updated')
                                <div class="alert alert-success mt-3" id="update-success-message">
                                    <i class="icon icon-check"></i> Thông tin đã được cập nhật thành công!
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Đang đọc -->
                <div class="tab-pane fade" id="reading" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Sách đang đọc</h5>
                        </div>
                        <div class="card-body">
                            @if($readingBooks->isEmpty())
                                <div class="text-center py-5">
                                    <i class="icon icon-book" style="font-size: 48px; color: #ccc;"></i>
                                    <h5 class="mt-3">Bạn chưa có sách nào đang đọc</h5>
                                    <p class="text-muted">Hãy mượn sách để bắt đầu đọc ngay!</p>
                                    <a href="{{ route('home') }}" class="btn btn-primary">Khám phá sách</a>
                                </div>
                            @else
                                <div class="row">
                                    @foreach($readingBooks as $rental)
                                        @php
                                            $book = $rental->book;
                                            $daysRemaining = round(\Carbon\Carbon::now()->diffInDays($rental->due_at, false));
                                        @endphp
                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100">
                                                <div class="position-relative">
                                                    <a href="{{ route('book.detail', $book->slug) }}">
                                                        <img src="{{ Storage::url($book->images->first()->url ?? '') }}"
                                                            class="card-img-top" alt="{{ $book->name }}"
                                                            style="height: 300px; object-fit: cover;">
                                                    </a>
                                                    @if($daysRemaining < 3 && $daysRemaining >= 0)
                                                        <span class="badge bg-warning position-absolute top-0 end-0 m-2">
                                                            Sắp hết hạn
                                                        </span>
                                                    @elseif($daysRemaining < 0)
                                                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                                            Quá hạn
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $book->name }}</h6>
                                                    <p class="text-muted small mb-2">{{ $book->author }}</p>
                                                    <div class="rental-info mb-3">
                                                        <div class="small">
                                                            <strong>Hạn trả:</strong>
                                                            {{ \Carbon\Carbon::parse($rental->due_at)->format('d/m/Y') }}
                                                        </div>
                                                        <div class="small">
                                                            @if($daysRemaining >= 0)
                                                                <span class="text-success">
                                                                    Còn {{ $daysRemaining }} ngày
                                                                </span>
                                                            @else
                                                                <span class="text-danger">
                                                                    Quá hạn {{ abs($daysRemaining) }} ngày
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if($daysRemaining < 0)
                                                        <a href="{{ route('book.rental.create', $book->slug) }}" class="btn btn-warning btn-sm w-100 mb-2">
                                                            <i class="icon icon-refresh"></i> Thuê lại
                                                        </a>
                                                    @endif
                                                    @if($rental->status == 'active' && $book->file)
                                                        <a href="{{ route('book.read', $book->slug) }}" class="btn btn-primary btn-sm w-100">
                                                            <i class="icon icon-book"></i> Tiếp tục đọc
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Yêu thích -->
                <div class="tab-pane fade" id="favorites" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Sách yêu thích</h5>
                        </div>
                        <div class="card-body">
                            @if($favorites->isEmpty())
                                <div class="text-center py-5">
                                    <i class="icon icon-heart" style="font-size: 48px; color: #ccc;"></i>
                                    <h5 class="mt-3">Bạn chưa có sách yêu thích nào</h5>
                                    <p class="text-muted">Hãy khám phá thư viện và thêm những cuốn sách bạn yêu thích.</p>
                                    <a href="{{ route('home') }}" class="btn btn-primary">Khám phá sách</a>
                                </div>
                            @else
                                <div class="row">
                                    @foreach($favorites as $favorite)
                                        @php
                                            $book = $favorite->book;
                                        @endphp
                                        @if($book)
                                            <div class="col-md-3 mb-4">
                                                <div class="product-item h-100 d-flex flex-column">
                                                    <figure class="product-style">
                                                        <a href="{{ route('book.detail', $book->slug) }}">
                                                            <img src="{{ Storage::url($book->images->first()->url ?? '') }}"
                                                                alt="{{ $book->name }}" class="product-item">
                                                        </a>
                                                        <form action="{{ route('book.favorite.store', $book->id) }}" method="post">
                                                            @csrf
                                                            <button type="submit"
                                                                class="add-to-cart btn btn-sm btn-outline-danger"
                                                                data-product-tile="add-to-cart">
                                                                Bỏ yêu thích
                                                            </button>
                                                        </form>
                                                    </figure>
                                                    <figcaption class="mt-auto">
                                                        <h3 class="h6 mb-1">{{ $book->name }}</h3>
                                                        <span class="text-muted d-block mb-2">{{ $book->author }}</span>
                                                        <div class="item-price">
                                                            <a href="{{ route('book.detail', $book->slug) }}">Xem chi tiết</a>
                                                        </div>
                                                    </figcaption>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tab 4: Đơn hàng -->
                <div class="tab-pane fade" id="rentals" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Đơn hàng đã thuê</h5>
                        </div>
                        <div class="card-body">
                            @if($allRentals->isEmpty())
                                <div class="text-center py-5">
                                    <i class="icon icon-clipboard" style="font-size: 48px; color: #ccc;"></i>
                                    <h5 class="mt-3">Bạn chưa có đơn hàng nào</h5>
                                    <a href="{{ route('home') }}" class="btn btn-primary">Mượn sách ngay</a>
                                </div>
                            @else
                                <!-- Filter buttons -->
                                <div class="mb-3">
                                    <button class="btn btn-sm btn-outline-primary filter-btn active" data-status="all">
                                        Tất cả ({{ $allRentals->count() }})
                                    </button>
                                    <button class="btn btn-sm btn-outline-success filter-btn" data-status="active">
                                        Đang mượn ({{ $activeRentals->count() }})
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning filter-btn" data-status="pending">
                                        Chờ xử lý ({{ $pendingRentals->count() }})
                                    </button>
                                    <button class="btn btn-sm btn-outline-info filter-btn" data-status="returned">
                                        Đã trả ({{ $returnedRentals->count() }})
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger filter-btn" data-status="late">
                                        Quá hạn ({{ $lateRentals->count() }})
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Sách</th>
                                                <th>Ngày mượn</th>
                                                <th>Hạn trả</th>
                                                <th>Trạng thái</th>
                                                <th>Thanh toán</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($allRentals as $rental)
                                                @php
                                                    $book = $rental->book;
                                                    $payment = $rental->payments->first();
                                                    $statusClass = [
                                                        'pending' => 'warning',
                                                        'active' => 'success',
                                                        'returned' => 'info',
                                                        'late' => 'danger'
                                                    ][$rental->status] ?? 'secondary';
                                                @endphp
                                                <tr class="rental-row" data-status="{{ $rental->status }}">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ Storage::url($book->images->first()->url ?? '') }}"
                                                                alt="{{ $book->name }}" class="me-2"
                                                                style="width: 50px; height: 70px; object-fit: cover;">
                                                            <div>
                                                                <strong>{{ $book->name }}</strong><br>
                                                                <small class="text-muted">{{ $book->author }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($rental->rented_at)->format('d/m/Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($rental->due_at)->format('d/m/Y') }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $statusClass }}">
                                                            @if($rental->status == 'pending')
                                                                Chờ xử lý
                                                            @elseif($rental->status == 'active')
                                                                Đang mượn
                                                            @elseif($rental->status == 'returned')
                                                                Đã trả
                                                            @elseif($rental->status == 'late')
                                                                Quá hạn
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($payment)
                                                            @if($payment->status == 'paid')
                                                                <span class="badge bg-success">Đã thanh toán</span>
                                                            @elseif($payment->status == 'pending')
                                                                <span class="badge bg-warning">Chờ thanh toán</span>
                                                            @else
                                                                <span class="badge bg-danger">{{ ucfirst($payment->status) }}</span>
                                                            @endif
                                                        @else
                                                            <span class="badge bg-secondary">Chưa thanh toán</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($rental->status == 'active' && $book->file && $payment && $payment->status == 'paid')
                                                            <a href="{{ route('book.read', $book->slug) }}" class="btn btn-sm btn-primary">
                                                                Đọc
                                                            </a>
                                                        @endif
                                                        @if($rental->status == 'late')
                                                            <a href="{{ route('book.rental.create', $book->slug) }}" class="btn btn-sm btn-warning">
                                                                <i class="icon icon-refresh"></i> Thuê lại
                                                            </a>
                                                        @endif
                                                        <a href="{{ route('book.detail', $book->slug) }}" class="btn btn-sm btn-outline-secondary">
                                                            Chi tiết
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tab 5: Lịch sử thanh toán -->
                <div class="tab-pane fade" id="payments" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Lịch sử thanh toán</h5>
                        </div>
                        <div class="card-body">
                            @if($payments->isEmpty())
                                <div class="text-center py-5">
                                    <i class="icon icon-credit-card" style="font-size: 48px; color: #ccc;"></i>
                                    <h5 class="mt-3">Chưa có giao dịch thanh toán nào</h5>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Mã đơn</th>
                                                <th>Sách</th>
                                                <th>Số tiền</th>
                                                <th>Phương thức</th>
                                                <th>Trạng thái</th>
                                                <th>Ngày thanh toán</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($payments as $payment)
                                                @php
                                                    $book = $payment->rental->book ?? null;
                                                    $statusClass = [
                                                        'pending' => 'warning',
                                                        'paid' => 'success',
                                                        'failed' => 'danger',
                                                        'refunded' => 'info'
                                                    ][$payment->status] ?? 'secondary';
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <strong>#{{ $payment->order_code ?? $payment->id }}</strong>
                                                    </td>
                                                    <td>
                                                        @if($book)
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ Storage::url($book->images->first()->url ?? '') }}"
                                                                    alt="{{ $book->name }}" class="me-2"
                                                                    style="width: 40px; height: 60px; object-fit: cover;">
                                                                <div>
                                                                    <strong>{{ $book->name }}</strong>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong>{{ number_format($payment->amount, 0, ',', '.') }} đ</strong>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-secondary">{{ strtoupper($payment->method) }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-{{ $statusClass }}">
                                                            @if($payment->status == 'pending')
                                                                Chờ thanh toán
                                                            @elseif($payment->status == 'paid')
                                                                Đã thanh toán
                                                            @elseif($payment->status == 'failed')
                                                                Thất bại
                                                            @elseif($payment->status == 'refunded')
                                                                Đã hoàn tiền
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ $payment->created_at->format('d/m/Y H:i') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>

    <style>
        .stats-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }

        .stat-item {
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-number {
            font-size: 28px;
            font-weight: bold;
            color: #007bff;
        }

        .stat-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .nav-tabs .nav-link {
            color: #666;
        }

        .nav-tabs .nav-link.active {
            color: #007bff;
            font-weight: 600;
        }

        .filter-btn.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .rental-row {
            display: table-row;
        }

        .rental-row.hidden {
            display: none;
        }

        #profile-edit-form {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #update-success-message {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        // Filter rentals by status
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Update active button
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const status = this.dataset.status;
                const rows = document.querySelectorAll('.rental-row');

                rows.forEach(row => {
                    if (status === 'all' || row.dataset.status === status) {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });
            });
        });

        // Toggle edit profile form
        const btnEditProfile = document.getElementById('btn-edit-profile');
        const btnCancelEdit = document.getElementById('btn-cancel-edit');
        const profileInfo = document.getElementById('profile-info');
        const profileEditForm = document.getElementById('profile-edit-form');
        const updateSuccessMessage = document.getElementById('update-success-message');

        if (btnEditProfile) {
            btnEditProfile.addEventListener('click', function() {
                profileInfo.style.display = 'none';
                profileEditForm.style.display = 'block';
                // Scroll to form
                profileEditForm.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            });
        }

        if (btnCancelEdit) {
            btnCancelEdit.addEventListener('click', function() {
                profileInfo.style.display = 'block';
                profileEditForm.style.display = 'none';
                // Reset form if needed
                document.getElementById('update-profile-form').reset();
            });
        }

        // Auto hide success message after 5 seconds
        if (updateSuccessMessage) {
            setTimeout(function() {
                updateSuccessMessage.style.transition = 'opacity 0.5s';
                updateSuccessMessage.style.opacity = '0';
                setTimeout(function() {
                    updateSuccessMessage.remove();
                }, 500);
            }, 5000);
        }

        // Handle form submission success - update displayed values
        const updateForm = document.getElementById('update-profile-form');
        if (updateForm) {
            updateForm.addEventListener('submit', function(e) {
                // Form will submit normally, page will reload with updated data
                // The success message will be shown via session flash
            });
        }
    </script>
@endsection
