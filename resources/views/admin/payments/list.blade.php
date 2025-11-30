@extends('admin.app')

@section('title', 'Quản lý thanh toán')
@section('page-title', 'Danh sách thanh toán')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-bold">Danh sách thanh toán</h3>
            <a href="{{ route('admin.payments.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Thêm thanh toán
            </a>
        </div>

        <div class="card-body p-0">
            <table id="payments-table" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Người thanh toán</th>
                        <th>Mã thuê sách</th>
                        <th>Sách</th>
                        <th>Số tiền</th>
                        <th>Phương thức</th>
                        <th>Trạng thái</th>
                        <th width="150">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $payment->user->name ?? 'N/A' }}</td>
                            <td>#{{ $payment->rental_id }}</td>
                            <td>{{ $payment->rental->book->name ?? 'N/A' }}</td>
                            <td>{{ number_format($payment->amount, 0, ',', '.') }} đ</td>
                            <td>
                                <span class="badge badge-info">{{ $payment->method }}</span>
                            </td>
                            <td>
                                @if($payment->status == 'paid')
                                    <span class="badge badge-success">Đã thanh toán</span>
                                @elseif($payment->status == 'pending')
                                    <span class="badge badge-warning">Chờ thanh toán</span>
                                @elseif($payment->status == 'failed')
                                    <span class="badge badge-danger">Thất bại</span>
                                @elseif($payment->status == 'refunded')
                                    <span class="badge badge-secondary">Đã hoàn tiền</span>
                                @else
                                    <span class="badge badge-secondary">{{ $payment->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.payments.edit', $payment->id) }}" class="btn btn-primary btn-sm"><i
                                        class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa?')" class="btn btn-danger btn-sm"><i
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

@section('js')
    <script>
        $(function() {
            $('#payments-table').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "responsive": true,
                "autoWidth": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json"
                }
            });
        });
    </script>
@stop

