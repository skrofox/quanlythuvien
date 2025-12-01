@extends('adminlte::page')

@section('title', 'Sửa mức giá mượn sách')

@section('content_header')
    <h1>Sửa mức giá mượn sách</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('admin.rental-pricings.update', $rentalPricing->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="form-group mb-3">
                    <label>Tên gói <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control"
                        value="{{ old('name', $rentalPricing->name) }}" required>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Period Days --}}
                <div class="form-group mb-3">
                    <label>Số ngày mượn <span class="text-danger">*</span></label>
                    <input type="number" name="period_days" class="form-control" min="1"
                        value="{{ old('period_days', $rentalPricing->period_days) }}" required>
                    @error('period_days')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Price --}}
                <div class="form-group mb-3">
                    <label>Giá (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" name="price" class="form-control" min="0" step="1000"
                        value="{{ old('price', $rentalPricing->price) }}" required>
                    @error('price')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                    <small class="form-text text-muted">
                        Giá hiện tại trong DB: <strong class="text-primary">{{ number_format($rentalPricing->price, 0, ',', '.') }}
                            đ</strong>
                    </small>
                </div>

                {{-- Description --}}
                <div class="form-group mb-3">
                    <label>Mô tả</label>
                    <textarea name="description" class="form-control" rows="3"
                        placeholder="Mô tả về gói mượn sách">{{ old('description', $rentalPricing->description) }}</textarea>
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Is Active --}}
                <div class="form-group mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                            {{ old('is_active', $rentalPricing->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Kích hoạt
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('admin.rental-pricings.list') }}" class="btn btn-secondary">Quay lại</a>
            </form>

        </div>
    </div>
@stop

