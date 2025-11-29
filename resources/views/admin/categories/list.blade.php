@extends('admin.app')

@section('title', 'Quản lý danh mục')
@section('page-title', 'Danh sách danh mục')

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-bold">Danh sách danh mục</h3>

            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-create">
                <i class="fas fa-plus"></i> Thêm danh mục
            </button>
        </div>

        <div class="card-body p-0">
            <table id="categories-table" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên danh mục</th>
                        <th>Mô tả ngắn</th>
                        <th>Slug</th>
                        <th width="150">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                <span class="badge badge-info">{{ $category->slug }}</span>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-info" href="{{ route('admin.categories.edit', $category->id) }}">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form class="d-inline" method="POST"
                                    action="{{ route('admin.categories.destroy', $category->id) }}">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Xóa?')" class="btn btn-sm btn-danger">
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


    {{-- Modal tạo mới --}}
    <div class="modal fade" id="modal-create">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf

                    <div class="modal-header">
                        <h4 class="modal-title">Thêm danh mục</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tên danh mục</label>
                            <input name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Mô tả ngắn</label>
                            <input name="description" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(function() {
            $('#categories-table').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "responsive": true,
                "autoWidth": false
            });
        });
    </script>
@stop
