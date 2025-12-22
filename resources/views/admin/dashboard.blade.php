@extends('admin.app')

@section('title', 'Dashboard')

@section('page-title', 'Trang quản trị - Dashboard')

@push('styles')
<style>
    .info-box {
        cursor: pointer;
        transition: transform 0.2s;
    }
    .info-box:hover {
        transform: translateY(-5px);
    }
</style>
@endpush

@section('content')

<!-- Info boxes -->
<div class="row">
    <!-- Tổng số sách -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-book"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Tổng số sách</span>
                <span class="info-box-number">{{ number_format($totalBooks) }}</span>
            </div>
        </div>
    </div>

    <!-- Tổng số người dùng -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Tổng số người dùng</span>
                <span class="info-box-number">{{ number_format($totalUsers) }}</span>
            </div>
        </div>
    </div>

    <!-- Tổng số đơn mượn -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Tổng số đơn mượn</span>
                <span class="info-box-number">{{ number_format($totalRentals) }}</span>
            </div>
        </div>
    </div>

    <!-- Tổng doanh thu -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill-wave"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Tổng doanh thu</span>
                <span class="info-box-number">{{ number_format($totalRevenue, 0, ',', '.') }} đ</span>
            </div>
        </div>
    </div>
</div>

<!-- Thống kê tháng này -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Thống kê tháng này</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>Chỉ số</th>
                                <th>Giá trị</th>
                                <th>Thay đổi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Đơn mượn</td>
                                <td><strong>{{ number_format($thisMonthRentals) }}</strong></td>
                                <td>
                                    @if($rentalsChange > 0)
                                        <span class="badge badge-success">+{{ $rentalsChange }}%</span>
                                    @elseif($rentalsChange < 0)
                                        <span class="badge badge-danger">{{ $rentalsChange }}%</span>
                                    @else
                                        <span class="badge badge-secondary">0%</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Doanh thu</td>
                                <td><strong>{{ number_format($thisMonthRevenue, 0, ',', '.') }} đ</strong></td>
                                <td>
                                    @if($revenueChange > 0)
                                        <span class="badge badge-success">+{{ $revenueChange }}%</span>
                                    @elseif($revenueChange < 0)
                                        <span class="badge badge-danger">{{ $revenueChange }}%</span>
                                    @else
                                        <span class="badge badge-secondary">0%</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Đơn mượn theo trạng thái -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Đơn mượn theo trạng thái</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>Trạng thái</th>
                                <th>Số lượng</th>
                                <th>Tỷ lệ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge badge-primary">Đang mượn</span></td>
                                <td><strong>{{ number_format($activeRentals) }}</strong></td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-primary" style="width: {{ $totalRentals > 0 ? ($activeRentals / $totalRentals * 100) : 0 }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="badge badge-success">Đã trả</span></td>
                                <td><strong>{{ number_format($returnedRentals) }}</strong></td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-success" style="width: {{ $totalRentals > 0 ? ($returnedRentals / $totalRentals * 100) : 0 }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="badge badge-warning">Quá hạn</span></td>
                                <td><strong>{{ number_format($overdueRentals) }}</strong></td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-warning" style="width: {{ $totalRentals > 0 ? ($overdueRentals / $totalRentals * 100) : 0 }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="badge badge-secondary">Chờ xử lý</span></td>
                                <td><strong>{{ number_format($pendingRentals) }}</strong></td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-secondary" style="width: {{ $totalRentals > 0 ? ($pendingRentals / $totalRentals * 100) : 0 }}%"></div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Biểu đồ thống kê -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Biểu đồ thống kê 12 tháng gần nhất</h3>
            </div>
            <div class="card-body">
                <canvas id="statisticsChart" style="height: 250px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Đơn mượn sắp đến hạn và Top sách -->
<div class="row">
    <!-- Đơn mượn sắp đến hạn -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Đơn mượn sắp đến hạn (7 ngày tới)</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.rentals.list') }}" class="btn btn-sm btn-primary">
                        Xem tất cả
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if($upcomingDueRentals->count() > 0)
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Người mượn</th>
                                    <th>Sách</th>
                                    <th>Hạn trả</th>
                                    <th>Còn lại</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcomingDueRentals as $rental)
                                    @php
                                        $daysLeft = now()->diffInDays(\Carbon\Carbon::parse($rental->due_at), false);
                                    @endphp
                                    <tr>
                                        <td>{{ $rental->user->name }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($rental->book->name, 30) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($rental->due_at)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($daysLeft < 0)
                                                <span class="badge badge-danger">Quá hạn {{ abs($daysLeft) }} ngày</span>
                                            @elseif($daysLeft == 0)
                                                <span class="badge badge-warning">Hôm nay</span>
                                            @else
                                                <span class="badge badge-info">{{ $daysLeft }} ngày</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-3 text-center text-muted">
                        Không có đơn mượn nào sắp đến hạn
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Top sách được mượn nhiều nhất -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Top 5 sách được mượn nhiều nhất</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.books.list') }}" class="btn btn-sm btn-primary">
                        Xem tất cả
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if($topRentedBooks->count() > 0)
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên sách</th>
                                    <th>Số lượt mượn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topRentedBooks as $index => $book)
                                    <tr>
                                        <td><strong>#{{ $index + 1 }}</strong></td>
                                        <td>{{ \Illuminate\Support\Str::limit($book->name, 40) }}</td>
                                        <td>
                                            <span class="badge badge-primary">{{ $book->rentals_count }} lượt</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-3 text-center text-muted">
                        Chưa có dữ liệu
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Top sách đánh giá cao nhất -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Top 5 sách được đánh giá cao nhất</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.books.list') }}" class="btn btn-sm btn-primary">
                        Xem tất cả
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if($topRatedBooks->count() > 0)
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên sách</th>
                                    <th>Tác giả</th>
                                    <th>Đánh giá trung bình</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topRatedBooks as $index => $book)
                                    <tr>
                                        <td><strong>#{{ $index + 1 }}</strong></td>
                                        <td>{{ $book->name }}</td>
                                        <td>{{ $book->author }}</td>
                                        <td>
                                            <span class="badge badge-warning">
                                                <i class="fas fa-star"></i> {{ number_format($book->reviews_avg_rating, 1) }}/5
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-3 text-center text-muted">
                        Chưa có sách nào được đánh giá
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('statisticsChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [
                    {
                        label: 'Số đơn mượn',
                        data: @json($chartRentalsData),
                        borderColor: 'rgb(54, 162, 235)',
                        backgroundColor: 'rgba(54, 162, 235, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Doanh thu (VNĐ)',
                        data: @json($chartRevenueData),
                        borderColor: 'rgb(255, 99, 132)',
                        backgroundColor: 'rgba(255, 99, 132, 0.1)',
                        tension: 0.4,
                        fill: true,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Số đơn mượn'
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Doanh thu (VNĐ)'
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    });
</script>
@endpush
