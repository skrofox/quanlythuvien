@extends('admin.app')

@section('title', 'Thêm thuê sách')
@section('page-title', 'Thêm thuê sách')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.rentals.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="user_id">Người thuê <span class="text-danger">*</span></label>
                    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                        <option value="">-- Chọn người dùng --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="book_id">Sách <span class="text-danger">*</span></label>
                    <select name="book_id" id="book_id" class="form-control @error('book_id') is-invalid @enderror" required>
                        <option value="">-- Chọn sách --</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                {{ $book->name }} - {{ $book->author }}
                            </option>
                        @endforeach
                    </select>
                    @error('book_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="rented_at">Ngày thuê <span class="text-danger">*</span></label>
                    <input type="date" name="rented_at" id="rented_at" 
                           class="form-control @error('rented_at') is-invalid @enderror" 
                           value="{{ old('rented_at', date('Y-m-d')) }}" required>
                    @error('rented_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="due_at">Ngày hạn trả <span class="text-danger">*</span></label>
                    <input type="date" name="due_at" id="due_at" 
                           class="form-control @error('due_at') is-invalid @enderror" 
                           value="{{ old('due_at') }}" required>
                    @error('due_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="returned_at">Ngày trả thực tế</label>
                    <input type="date" name="returned_at" id="returned_at" 
                           class="form-control @error('returned_at') is-invalid @enderror" 
                           value="{{ old('returned_at') }}">
                    @error('returned_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Trạng thái <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="">-- Chọn trạng thái --</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Đang thuê</option>
                        <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Đã thuê</option>
                        <option value="returned" {{ old('status') == 'returned' ? 'selected' : '' }}>Đã trả</option>
                        <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>Quá hạn</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <a href="{{ route('admin.rentals.list') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Đảm bảo ngày hạn trả phải sau ngày thuê
        document.getElementById('rented_at').addEventListener('change', function() {
            const rentedAt = new Date(this.value);
            const dueAtInput = document.getElementById('due_at');
            if (this.value && dueAtInput.value) {
                const dueAt = new Date(dueAtInput.value);
                if (dueAt <= rentedAt) {
                    dueAtInput.value = '';
                    alert('Ngày hạn trả phải sau ngày thuê!');
                }
            }
        });
    </script>
@endsection

