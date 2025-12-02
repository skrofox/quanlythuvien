@extends('frontend.layout.app')

@section('title', 'Mượn Sách - ' . $book->name)

@section('content')
    @php
        use Illuminate\Support\Facades\Storage;
    @endphp

    <div class="book-rental-page py-5">
        <div class="container">
            <div class="row">
                <!-- Left Panel: Book Info -->
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="book-cover-section">
                        <div class="book-cover-wrapper mb-3">
                            <img src="{{ Storage::url($book->images->first()->url ?? '') }}" alt="{{ $book->name }}"
                                class="rounded shadow-sm" style="max-width: 200px; height: auto;">
                        </div>
                        <h5 class="font-weight-bold">{{ $book->name }}</h5>
                        <p class="text-muted small">{{ $book->author }}</p>
                    </div>
                </div>

                <!-- Right Panel: Rental Form -->
                <div class="col-md-8 col-lg-9">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"><i class="icon icon-book"></i> Mượn Sách Online</h4>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            {{-- form open blank page --}}
                            <form action="{{ route('vnpay.payment.store') }}" method="POST" id="rentalForm">
                                @csrf
                                <input type="hidden" name="book_slug" value="{{ $book->slug }}">
                                <!-- Rental Period Selection -->
                                <div class="mb-4">
                                    <h5 class="mb-3">Chọn thời gian mượn:</h5>
                                    <div class="row g-3">
                                        @foreach ($rentalPricings as $pricing)
                                            <div class="col-md-6 col-lg-3">
                                                <div class="rental-option-card">
                                                    <input type="radio" name="rental_pricing_id" id="pricing_{{ $pricing->id }}"
                                                        value="{{ $pricing->id }}" class="rental-option-input"
                                                        data-price="{{ $pricing->price }}" required>
                                                    <label for="pricing_{{ $pricing->id }}" class="rental-option-label">
                                                        <div class="rental-option-header">
                                                            <strong>{{ $pricing->name }}</strong>
                                                        </div>
                                                        <div class="rental-option-body">
                                                            <div class="rental-period">{{ $pricing->period_days }} ngày</div>
                                                            <div class="rental-price">
                                                                {{ number_format($pricing->price, 0, ',', '.') }} đ
                                                            </div>
                                                            @if ($pricing->description)
                                                                <small class="text-muted">{{ $pricing->description }}</small>
                                                            @endif
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('rental_pricing_id')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Payment Method Selection -->
                                {{-- <div class="mb-4">
                                    <h5 class="mb-3">Chọn phương thức thanh toán:</h5>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="payment-method-card">
                                                <input type="radio" name="payment_method" id="payment_momo" value="momo"
                                                    class="payment-method-input" required>
                                                <label for="payment_momo" class="payment-method-label">
                                                    <i class="icon icon-credit-card"></i>
                                                    <span>MoMo</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="payment-method-card">
                                                <input type="radio" name="payment_method" id="payment_paypal" value="paypal"
                                                    class="payment-method-input" required>
                                                <label for="payment_paypal" class="payment-method-label">
                                                    <i class="icon icon-credit-card"></i>
                                                    <span>PayPal</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="payment-method-card">
                                                <input type="radio" name="payment_method" id="payment_credit_card"
                                                    value="credit_card" class="payment-method-input" required>
                                                <label for="payment_credit_card" class="payment-method-label">
                                                    <i class="icon icon-credit-card"></i>
                                                    <span>Thẻ tín dụng</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="payment-method-card">
                                                <input type="radio" name="payment_method" id="payment_bank_transfer"
                                                    value="bank_transfer" class="payment-method-input" required>
                                                <label for="payment_bank_transfer" class="payment-method-label">
                                                    <i class="icon icon-credit-card"></i>
                                                    <span>Chuyển khoản</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @error('payment_method')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                                <!-- Total Price Display -->
                                <div class="mb-4 p-3 bg-light rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Tổng tiền:</h5>
                                        <h4 class="mb-0 text-primary" id="totalPrice">0 đ</h4>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="icon icon-check"></i> Xác nhận và thanh toán
                                    </button>
                                    <a href="{{ route('book.detail', $book->slug) }}" class="btn btn-outline-secondary">
                                        <i class="icon icon-arrow-left"></i> Quay lại
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .rental-option-card {
            position: relative;
        }

        .rental-option-input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .rental-option-label {
            display: block;
            padding: 20px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .rental-option-label:hover {
            border-color: #0066cc;
            box-shadow: 0 2px 8px rgba(0, 102, 204, 0.1);
        }

        .rental-option-input:checked+.rental-option-label {
            border-color: #0066cc;
            background-color: #e7f3ff;
            box-shadow: 0 4px 12px rgba(0, 102, 204, 0.2);
        }

        .rental-option-header {
            text-align: center;
            margin-bottom: 10px;
            color: #333;
        }

        .rental-option-body {
            text-align: center;
        }

        .rental-period {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }

        .rental-price {
            font-size: 20px;
            font-weight: bold;
            color: #0066cc;
            margin-bottom: 5px;
        }

        .payment-method-card {
            position: relative;
        }

        .payment-method-input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .payment-method-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .payment-method-label:hover {
            border-color: #0066cc;
            box-shadow: 0 2px 8px rgba(0, 102, 204, 0.1);
        }

        .payment-method-input:checked+.payment-method-label {
            border-color: #0066cc;
            background-color: #e7f3ff;
            box-shadow: 0 4px 12px rgba(0, 102, 204, 0.2);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rentalInputs = document.querySelectorAll('.rental-option-input');
            const totalPriceElement = document.getElementById('totalPrice');

            function updateTotalPrice() {
                const selectedPricing = document.querySelector('.rental-option-input:checked');
                if (selectedPricing) {
                    const price = parseFloat(selectedPricing.dataset.price);
                    totalPriceElement.textContent = new Intl.NumberFormat('vi-VN').format(price) + ' đ';
                } else {
                    totalPriceElement.textContent = '0 đ';
                }
            }

            rentalInputs.forEach(input => {
                input.addEventListener('change', updateTotalPrice);
            });

            // Initialize price on page load
            updateTotalPrice();
        });
    </script>
@endsection
