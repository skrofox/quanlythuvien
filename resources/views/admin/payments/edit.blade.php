@extends('admin.app')

@section('title', 'Sửa thanh toán')
@section('page-title', 'Sửa thanh toán')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="user_id">Người thanh toán <span class="text-danger">*</span></label>
                    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                        <option value="">-- Chọn người dùng --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $payment->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="rental_id">Mã thuê sách <span class="text-danger">*</span></label>
                    <select name="rental_id" id="rental_id" class="form-control @error('rental_id') is-invalid @enderror" required>
                        <option value="">-- Chọn mã thuê sách --</option>
                        @foreach($rentals as $rental)
                            <option value="{{ $rental->id }}" {{ old('rental_id', $payment->rental_id) == $rental->id ? 'selected' : '' }}>
                                #{{ $rental->id }} - {{ $rental->book->name ?? 'N/A' }} ({{ $rental->user->name ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    @error('rental_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="amount">Số tiền (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" name="amount" id="amount" 
                           class="form-control @error('amount') is-invalid @enderror" 
                           value="{{ old('amount', $payment->amount) }}" 
                           min="0" step="1000" required>
                    @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="method">Phương thức thanh toán <span class="text-danger">*</span></label>
                    <select name="method" id="method" class="form-control @error('method') is-invalid @enderror" required>
                        <option value="">-- Chọn phương thức --</option>
                        <option value="momo" {{ old('method', $payment->method) == 'momo' ? 'selected' : '' }}>MoMo</option>
                        <option value="paypal" {{ old('method', $payment->method) == 'paypal' ? 'selected' : '' }}>PayPal</option>
                        <option value="credit_card" {{ old('method', $payment->method) == 'credit_card' ? 'selected' : '' }}>Thẻ tín dụng</option>
                        <option value="bank_transfer" {{ old('method', $payment->method) == 'bank_transfer' ? 'selected' : '' }}>Chuyển khoản</option>
                        <option value="cash" {{ old('method', $payment->method) == 'cash' ? 'selected' : '' }}>Tiền mặt</option>
                    </select>
                    @error('method')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Trạng thái <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="">-- Chọn trạng thái --</option>
                        <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>Chờ thanh toán</option>
                        <option value="paid" {{ old('status', $payment->status) == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                        <option value="failed" {{ old('status', $payment->status) == 'failed' ? 'selected' : '' }}>Thất bại</option>
                        <option value="refunded" {{ old('status', $payment->status) == 'refunded' ? 'selected' : '' }}>Đã hoàn tiền</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('admin.payments.list') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
@endsection

