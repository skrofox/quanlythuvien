@extends('frontend.layout.app')

@section('title', 'Thanh Toán - ' . $payment->rental->book->name)

@section('content')
    <div class="payment-process-page py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white text-center">
                            <h4 class="mb-0"><i class="icon icon-credit-card"></i> Xác Nhận Thanh Toán</h4>
                        </div>
                        <div class="card-body">
                            <!-- Payment Info -->
                            <div class="payment-info mb-4">
                                <h5 class="mb-3">Thông tin thanh toán:</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Sách:</th>
                                        <td>{{ $payment->rental->book->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Thời gian mượn:</th>
                                        <td>{{ $payment->rental->rentalPricing->name }} ({{ $payment->rental->rentalPricing->period_days }} ngày)</td>
                                    </tr>
                                    <tr>
                                        <th>Phương thức thanh toán:</th>
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
                                        <th>Số tiền:</th>
                                        <td class="text-primary fw-bold">
                                            {{ number_format($payment->amount, 0, ',', '.') }} đ
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái:</th>
                                        <td>
                                            @if ($payment->status == 'pending')
                                                <span class="badge bg-warning">Chờ thanh toán</span>
                                            @elseif ($payment->status == 'paid')
                                                <span class="badge bg-success">Đã thanh toán</span>
                                            @elseif ($payment->status == 'failed')
                                                <span class="badge bg-danger">Thất bại</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Payment Instructions -->
                            <div class="payment-instructions mb-4 p-3 bg-light rounded">
                                <h6 class="mb-2">Hướng dẫn thanh toán:</h6>
                                <p class="mb-1 small">
                                    <strong>Lưu ý:</strong> Đây là trang demo. Trong thực tế, bạn sẽ được chuyển đến
                                    trang thanh toán của gateway.
                                </p>
                                <p class="mb-0 small">
                                    Sau khi thanh toán thành công, hệ thống sẽ tự động cập nhật trạng thái và bạn có thể
                                    đọc sách ngay.
                                </p>
                            </div>

                            <!-- Action Buttons -->
                            @if ($payment->status == 'pending')
                                <form action="{{ route('book.rental.payment.callback', $payment->id) }}" method="POST">
                                    @csrf
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="icon icon-check"></i> Xác nhận thanh toán (Demo)
                                        </button>
                                        <a href="{{ route('book.rental.create', $payment->rental->book->slug) }}"
                                            class="btn btn-outline-secondary">
                                            <i class="icon icon-arrow-left"></i> Quay lại
                                        </a>
                                    </div>
                                </form>
                            @else
                                <div class="d-grid gap-2">
                                    <a href="{{ route('book.rental.success', $payment->id) }}"
                                        class="btn btn-success btn-lg">
                                        <i class="icon icon-check"></i> Xem chi tiết
                                    </a>
                                    <a href="{{ route('book.detail', $payment->rental->book->slug) }}"
                                        class="btn btn-outline-secondary">
                                        <i class="icon icon-arrow-left"></i> Quay lại
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

