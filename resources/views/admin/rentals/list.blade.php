@extends('admin.app')

@section('title', 'Quản lý thuê sách')
@section('page-title', 'Danh sách thuê sách')

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-bold">Danh sách thuê sách</h3>
        </div>

        <div class="card-body p-0">
            <table id="rentals-table" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Người thuê</th>
                        <th>Sách</th>
                        <th>Ngày thuê</th>
                        <th>Ngày hạn trả</th>
                        <th>Ngày trả thực tế</th>
                        <th>Trạng thái</th>
                        <th width="150">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rentals as $rental)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $rental->user->name }}</td>
                            <td>{{ $rental->book->title }}</td>
                            <td>{{ $rental->rented_at }}</td>
                            <td>{{ $rental->due_at }}</td>
                            <td>{{ $rental->returned_at }}</td>
                            <td>{{ $rental->status }}</td>
                            <td>
                                <a href="" class="btn btn-primary btn-sm"><i
                                        class="fas fa-edit"></i></a>
                                <form action="" method="POST"
                                    class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
