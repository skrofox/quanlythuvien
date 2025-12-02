@extends('frontend.layout.app')

@section('title', $success ? 'Thanh Toán Thành Công' : 'Thanh Toán Thất Bại')

@section('content')
    <div class="payment-result-page py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-sm">
                        @if ($success)
                            <div class="card-header bg-success text-white text-center">
                                <h4 class="mb-0"><i class="icon icon-check"></i> Thanh Toán Thành Công!</h4>
                            </div>
                            <div class="card-body text-center">
                                <!-- Success Icon -->
                                <div class="mb-4">
                                    <div class="success-icon mx-auto mb-3"
                                        style="width: 80px; height: 80px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="icon icon-check" style="font-size: 40px; color: white;"></i>
                                    </div>
                                    <h5 class="text-success">{{ $message }}</h5>
                                </div>

                                <!-- Payment Details -->
                                @if (isset($rental))
                                    <div class="payment-details mb-4">
                                        <h6 class="mb-3">Chi tiết giao dịch:</h6>
                                        <table class="table table-bordered text-start">
                                            <tr>
                                                <th width="40%">Mã đơn hàng:</th>
                                                <td>#{{ $order_id }}</td>
                                            </tr>
                                            @if (isset($transaction_no))
                                                <tr>
                                                    <th>Mã giao dịch VNPay:</th>
                                                    <td>{{ $transaction_no }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th>Sách:</th>
                                                <td>{{ $rental->book->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Thời gian mượn:</th>
                                                <td>
                                                    {{ $rental->rentalPricing->name }}
                                                    ({{ $rental->rentalPricing->period_days }} ngày)
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Ngày mượn:</th>
                                                <td>{{ \Carbon\Carbon::parse($rental->rented_at)->format('d/m/Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Hạn trả:</th>
                                                <td>{{ \Carbon\Carbon::parse($rental->due_at)->format('d/m/Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Số tiền:</th>
                                                <td class="text-primary fw-bold">
                                                    {{ number_format($amount, 0, ',', '.') }} đ
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Phương thức:</th>
                                                <td>VNPay</td>
                                            </tr>
                                            <tr>
                                                <th>Trạng thái:</th>
                                                <td><span class="badge bg-success">Đã thanh toán</span></td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Next Steps -->
                                    <div class="next-steps mb-4 p-3 bg-light rounded text-start">
                                        <h6 class="mb-2">Bước tiếp theo:</h6>
                                        <ul class="mb-0 small">
                                            <li>Sách đã được chuyển sang trạng thái <strong>"đọc"</strong></li>
                                            <li>Bạn có thể đọc sách ngay bây giờ</li>
                                            <li>Vui lòng trả sách trước ngày hết hạn để tránh phí phạt</li>
                                        </ul>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('book.detail', $rental->book->slug) }}"
                                            class="btn btn-primary btn-lg">
                                            <i class="icon icon-book"></i> Đọc sách ngay
                                        </a>
                                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                            <i class="icon icon-home"></i> Về trang chủ
                                        </a>
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        <p class="mb-0">{{ $message }}</p>
                                        <p class="mb-0 small mt-2">Mã đơn hàng: <strong>#{{ $order_id }}</strong></p>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('home') }}" class="btn btn-primary">
                                            <i class="icon icon-home"></i> Về trang chủ
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="card-header bg-danger text-white text-center">
                                <h4 class="mb-0"><i class="icon icon-close"></i> Thanh Toán Thất Bại</h4>
                            </div>
                            <div class="card-body text-center">
                                <!-- Error Icon -->
                                <div class="mb-4">
                                    <div class="error-icon mx-auto mb-3"
                                        style="width: 80px; height: 80px; background: #dc3545; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="icon icon-close" style="font-size: 40px; color: white;"></i>
                                    </div>
                                    <h5 class="text-danger">{{ $message }}</h5>
                                </div>

                                <!-- Error Details -->
                                <div class="error-details mb-4">
                                    <div class="alert alert-warning">
                                        <p class="mb-0"><strong>Mã đơn hàng:</strong> #{{ $order_id }}</p>
                                        @if (isset($response_code))
                                            <p class="mb-0 mt-2"><strong>Mã lỗi:</strong> {{ $response_code }}</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-grid gap-2">
                                    <a href="{{ route('home') }}" class="btn btn-primary">
                                        <i class="icon icon-home"></i> Về trang chủ
                                    </a>
                                    <button onclick="window.history.back()" class="btn btn-outline-secondary">
                                        <i class="icon icon-arrow-left"></i> Thử lại
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

