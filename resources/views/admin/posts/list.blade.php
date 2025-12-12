@extends('admin.app')

@section('title', 'Quản lý bài viết')
@section('page-title', 'Danh sách bài viết')

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-bold">Danh sách bài viết</h3>

            <a class="btn btn-primary btn-sm" href="{{ route('admin.posts.create') }}">
                <i class="fas fa-plus"></i> Thêm bài viết
            </a>
        </div>

        <div class="card-body p-0">
            <table id="posts-table" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Tác giả</th>
                        <th>Trạng thái</th>
                        <th>Lượt xem</th>
                        <th>Ngày tạo</th>
                        <th width="150">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($post->image)
                                    <img style="width: 80px; height: 60px; object-fit: cover;"
                                         src="{{ asset('storage/'.$post->image) }}"
                                         alt="{{ $post->title }}">
                                @else
                                    <span class="text-muted">Không có ảnh</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($post->title, 50) }}</td>
                            <td>{{ $post->user->name ?? 'N/A' }}</td>
                            <td>
                                @if($post->status == 'published')
                                    <span class="badge badge-success">Đã xuất bản</span>
                                @else
                                    <span class="badge badge-warning">Bản nháp</span>
                                @endif
                            </td>
                            <td>{{ $post->views }}</td>
                            <td>{{ $post->created_at->format('d/m/Y') }}</td>

                            <td>
                                <a class="btn btn-sm btn-info" href="{{ route('admin.posts.edit', $post->id) }}">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form class="d-inline" method="POST"
                                    action="{{ route('admin.posts.destroy', $post->id) }}">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Xóa bài viết này?')" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(function() {
            $('#posts-table').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "responsive": true,
                "autoWidth": false
            });
        });
    </script>
@stop

