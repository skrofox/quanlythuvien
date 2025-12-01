@extends('admin.app')

@section('title', 'Quản lý mức giá mượn sách')
@section('page-title', 'Danh sách mức giá mượn sách')

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-bold">Danh sách mức giá mượn sách</h3>

            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-create">
                <i class="fas fa-plus"></i> Thêm mức giá
            </button>
        </div>

        <div class="card-body p-0">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <table id="rental-pricings-table" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên gói</th>
                        <th>Số ngày</th>
                        <th>Giá (VNĐ)</th>
                        <th>Mô tả</th>
                        <th>Trạng thái</th>
                        <th width="150">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rentalPricings as $pricing)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $pricing->name }}</strong></td>
                            <td>{{ $pricing->period_days }} ngày</td>
                            <td class="text-primary font-weight-bold">
                                {{ number_format($pricing->price, 0, ',', '.') }} đ
                            </td>
                            <td>{{ $pricing->description ?? '-' }}</td>
                            <td>
                                @if ($pricing->is_active)
                                    <span class="badge badge-success">Hoạt động</span>
                                @else
                                    <span class="badge badge-secondary">Tạm khóa</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-sm btn-info"
                                    href="{{ route('admin.rental-pricings.edit', $pricing->id) }}">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form class="d-inline" method="POST"
                                    action="{{ route('admin.rental-pricings.destroy', $pricing->id) }}">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Bạn có chắc muốn xóa mức giá này?')"
                                        class="btn btn-sm btn-danger">
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

                <form method="POST" action="{{ route('admin.rental-pricings.store') }}">
                    @csrf

                    <div class="modal-header">
                        <h4 class="modal-title">Thêm mức giá mượn sách</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tên gói <span class="text-danger">*</span></label>
                            <input name="name" class="form-control" placeholder="VD: 7 ngày, 14 ngày, 1 tháng..."
                                required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Số ngày mượn <span class="text-danger">*</span></label>
                            <input type="number" name="period_days" class="form-control" min="1"
                                placeholder="VD: 7, 14, 30, 365" required>
                            @error('period_days')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Giá (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control" min="0" step="1000"
                                placeholder="VD: 50000" required>
                            @error('price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea name="description" class="form-control" rows="2"
                                placeholder="Mô tả về gói mượn sách"></textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                                    checked>
                                <label class="form-check-label" for="is_active">
                                    Kích hoạt
                                </label>
                            </div>
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
            $('#rental-pricings-table').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "responsive": true,
                "autoWidth": false,
                "order": [[2, "asc"]] // Sắp xếp theo số ngày
            });
        });
    </script>
@stop

