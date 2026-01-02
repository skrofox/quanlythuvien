@extends('admin.app')

@section('title', 'Chi tiết đánh giá')
@section('page-title', 'Chi tiết đánh giá')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Thông tin đánh giá</h3>
                    <div>
                        <a href="{{ route('admin.reviews.list') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')"
                                    class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Xóa đánh giá
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted mb-3">Thông tin người đánh giá</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Họ tên:</th>
                                    <td>{{ $review->user->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $review->user->email ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>ID người dùng:</th>
                                    <td>#{{ $review->user_id }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted mb-3">Thông tin sách</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Tên sách:</th>
                                    <td>{{ $review->book->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Tác giả:</th>
                                    <td>{{ $review->book->author ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>ID sách:</th>
                                    <td>#{{ $review->book_id }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-4">
                        <h5 class="text-muted mb-3">Đánh giá</h5>
                        <div class="rating-display mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fas fa-star text-warning" style="font-size: 24px;"></i>
                                @else
                                    <i class="far fa-star text-warning" style="font-size: 24px;"></i>
                                @endif
                            @endfor
                            <span class="ml-2" style="font-size: 18px; font-weight: bold;">{{ $review->rating }}/5</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="text-muted mb-3">Bình luận</h5>
                        <div class="comment-box p-3 bg-light rounded">
                            @if($review->comment)
                                <p class="mb-0" style="white-space: pre-wrap;">{{ $review->comment }}</p>
                            @else
                                <p class="text-muted mb-0">Không có bình luận</p>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="mb-4">
                        <h5 class="text-muted mb-3">Thông tin bổ sung</h5>
                        <table class="table table-borderless">
                            <tr>
                                <th width="150">Ngày tạo:</th>
                                <td>{{ $review->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th>Cập nhật lần cuối:</th>
                                <td>{{ $review->updated_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th>ID đánh giá:</th>
                                <td>#{{ $review->id }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

