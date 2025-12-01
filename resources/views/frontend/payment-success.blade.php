@extends('frontend.layout.app')

@section('title', 'Thanh Toán Thành Công')

@section('content')
    <div class="payment-success-page py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white text-center">
                            <h4 class="mb-0"><i class="icon icon-check"></i> Thanh Toán Thành Công!</h4>
                        </div>
                        <div class="card-body text-center">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Success Icon -->
                            <div class="mb-4">
                                <div class="success-icon mx-auto mb-3"
                                    style="width: 80px; height: 80px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="icon icon-check" style="font-size: 40px; color: white;"></i>
                                </div>
                                <h5 class="text-success">Cảm ơn bạn đã thanh toán!</h5>
                            </div>

                            <!-- Payment Details -->
                            <div class="payment-details mb-4">
                                <h6 class="mb-3">Chi tiết giao dịch:</h6>
                                <table class="table table-bordered text-start">
                                    <tr>
                                        <th width="40%">Mã thanh toán:</th>
                                        <td>#{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sách:</th>
                                        <td>{{ $payment->rental->book->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Thời gian mượn:</th>
                                        <td>
                                            {{ $payment->rental->rentalPricing->name }}
                                            ({{ $payment->rental->rentalPricing->period_days }} ngày)
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ngày mượn:</th>
                                        <td>{{ \Carbon\Carbon::parse($payment->rental->rented_at)->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Hạn trả:</th>
                                        <td>{{ \Carbon\Carbon::parse($payment->rental->due_at)->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Số tiền:</th>
                                        <td class="text-primary fw-bold">
                                            {{ number_format($payment->amount, 0, ',', '.') }} đ
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Phương thức:</th>
                                        <td>
                                            @if ($payment->method == 'momo')
                                                MoMo
                                            @elseif ($payment->method == 'paypal')
                                                PayPal
                                            @elseif ($payment->method == 'credit_card')
                                                Thẻ tín dụng
                                            @elseif ($payment->method == 'bank_transfer')
                                                Chuyển khoản
                                            @endif
                                        </td>
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
                                <a href="{{ route('book.detail', $payment->rental->book->slug) }}"
                                    class="btn btn-primary btn-lg">
                                    <i class="icon icon-book"></i> Đọc sách ngay
                                </a>
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                    <i class="icon icon-home"></i> Về trang chủ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

