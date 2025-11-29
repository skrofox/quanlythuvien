@extends('admin.app')

@section('title', 'Quản lý sách')
@section('page-title', 'Danh sách sách')

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-bold">Danh sách sách</h3>

            <a class="btn btn-primary btn-sm" href="{{ route('admin.books.create') }}">
                <i class="fas fa-plus"></i> Thêm sách
            </a>
        </div>

        <div class="card-body p-0">
            <table id="books-table" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Ảnh</th>
                        <th>Tên sách</th>
                        <th>Tác giả</th>
                        <th>Nhà xuất bản</th>
                        <th>Năm xuất bản</th>
                        <th width="150">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img style="width: 52px; height: 100%" src="{{ Storage::url($book->images->first()->url ?? "") }}" alt="{{ $book->name }}">
                            </td>
                            <td>{{ $book->name }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->publisher }}</td>
                            <td>{{ $book->year }}</td>

                            <td>
                                <a class="btn btn-sm btn-info" href="{{ route('admin.books.edit', $book->id) }}">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form class="d-inline" method="POST"
                                    action="{{ route('admin.books.destroy', $book->id) }}">
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

@endsection

@section('js')
    <script>
        $(function() {
            $('#books-table').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "responsive": true,
                "autoWidth": false
            });
        });
    </script>
@stop
