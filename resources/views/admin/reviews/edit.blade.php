@extends('admin.app')

@section('title', 'Sửa đánh giá')
@section('page-title', 'Sửa đánh giá')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="user_id">Người đánh giá <span class="text-danger">*</span></label>
                    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                        <option value="">-- Chọn người dùng --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $review->user_id) == $user->id ? 'selected' : '' }}>
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
                            <option value="{{ $book->id }}" {{ old('book_id', $review->book_id) == $book->id ? 'selected' : '' }}>
                                {{ $book->name }} - {{ $book->author }}
                            </option>
                        @endforeach
                    </select>
                    @error('book_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="rating">Đánh giá (sao) <span class="text-danger">*</span></label>
                    <select name="rating" id="rating" class="form-control @error('rating') is-invalid @enderror" required>
                        <option value="">-- Chọn số sao --</option>
                        <option value="1" {{ old('rating', $review->rating) == '1' ? 'selected' : '' }}>1 sao</option>
                        <option value="2" {{ old('rating', $review->rating) == '2' ? 'selected' : '' }}>2 sao</option>
                        <option value="3" {{ old('rating', $review->rating) == '3' ? 'selected' : '' }}>3 sao</option>
                        <option value="4" {{ old('rating', $review->rating) == '4' ? 'selected' : '' }}>4 sao</option>
                        <option value="5" {{ old('rating', $review->rating) == '5' ? 'selected' : '' }}>5 sao</option>
                    </select>
                    @error('rating')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="comment">Bình luận</label>
                    <textarea name="comment" id="comment" rows="5" 
                              class="form-control @error('comment') is-invalid @enderror" 
                              placeholder="Nhập bình luận...">{{ old('comment', $review->comment) }}</textarea>
                    @error('comment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('admin.reviews.list') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
@endsection

