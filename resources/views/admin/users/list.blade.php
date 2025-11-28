@extends('admin.app')

@section('title', 'Quản lý người dùng')
@section('page-title', 'Danh sách người dùng')

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-bold">Danh sách người dùng</h3>

            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-create">
                <i class="fas fa-plus"></i> Thêm người dùng
            </button>
        </div>

        <div class="card-body p-0">
            <table id="users-table" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th width="150">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge badge-info">{{ $user->role }}</span>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-info" href="{{ route('admin.users.edit', $user->id) }}">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Không cho tự xóa mình --}}
                                @if (Auth::id() != $user->id)
                                    <form class="d-inline" method="POST"
                                        action="{{ route('admin.users.destroy', $user->id) }}">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Xóa?')" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
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

                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <div class="modal-header">
                        <h4 class="modal-title">Thêm người dùng</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Tên</label>
                            <input name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input name="email" type="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Mật khẩu</label>
                            <input name="password" type="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Vai trò</label>
                            <select name="role" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
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
            $('#users-table').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "responsive": true,
                "autoWidth": false
            });
        });
    </script>
@stop
