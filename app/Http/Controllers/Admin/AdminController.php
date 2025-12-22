<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\Rentals;
use App\Models\Payment;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    //

    public function dashboard(){
        // Tổng số liệu cơ bản
        $totalBooks = Book::count();
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $totalRentals = Rentals::count();
        $totalRevenue = Payment::where('status', 'paid')->sum('amount');
        
        // Đơn mượn theo trạng thái
        $activeRentals = Rentals::whereIn('status', ['active', 'rented'])->count();
        $returnedRentals = Rentals::where('status', 'returned')->count();
        $overdueRentals = Rentals::where('status', 'overdue')->count();
        $pendingRentals = Rentals::where('status', 'pending')->count();
        
        // Thống kê tháng này
        $thisMonthRentals = Rentals::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $thisMonthRevenue = Payment::where('status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');
        
        // Thống kê tháng trước
        $lastMonthRentals = Rentals::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();
        $lastMonthRevenue = Payment::where('status', 'paid')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('amount');
        
        // Tính % thay đổi
        $rentalsChange = $lastMonthRentals > 0 
            ? round((($thisMonthRentals - $lastMonthRentals) / $lastMonthRentals) * 100, 1)
            : ($thisMonthRentals > 0 ? 100 : 0);
        $revenueChange = $lastMonthRevenue > 0
            ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : ($thisMonthRevenue > 0 ? 100 : 0);
        
        // Đơn mượn sắp đến hạn (7 ngày tới)
        $upcomingDueRentals = Rentals::with(['user', 'book'])
            ->whereIn('status', ['active', 'rented'])
            ->whereBetween('due_at', [Carbon::now(), Carbon::now()->addDays(7)])
            ->orderBy('due_at', 'asc')
            ->take(10)
            ->get();
        
        // Top sách được mượn nhiều nhất
        $topRentedBooks = Book::withCount('rentals')
            ->orderBy('rentals_count', 'desc')
            ->take(5)
            ->get();
        
        // Top sách được đánh giá cao nhất
        $topRatedBooks = Book::withAvg('reviews', 'rating')
            ->having('reviews_avg_rating', '>', 0)
            ->orderBy('reviews_avg_rating', 'desc')
            ->take(5)
            ->get();
        
        // Thống kê đơn mượn theo 12 tháng gần nhất
        $rentalsByMonth = Rentals::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        // Thống kê doanh thu theo 12 tháng gần nhất
        $revenueByMonth = Payment::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        // Chuẩn bị dữ liệu cho biểu đồ
        $chartLabels = [];
        $chartRentalsData = [];
        $chartRevenueData = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthLabel = $date->format('m/Y');
            $chartLabels[] = $monthLabel;
            
            $rentalCount = $rentalsByMonth->first(function($item) use ($date) {
                return $item->month == $date->month && $item->year == $date->year;
            });
            $chartRentalsData[] = $rentalCount ? $rentalCount->count : 0;
            
            $revenueTotal = $revenueByMonth->first(function($item) use ($date) {
                return $item->month == $date->month && $item->year == $date->year;
            });
            $chartRevenueData[] = $revenueTotal ? $revenueTotal->total : 0;
        }
        
        return view('admin.dashboard', compact(
            'totalBooks',
            'totalUsers',
            'totalRentals',
            'totalRevenue',
            'activeRentals',
            'returnedRentals',
            'overdueRentals',
            'pendingRentals',
            'thisMonthRentals',
            'thisMonthRevenue',
            'rentalsChange',
            'revenueChange',
            'upcomingDueRentals',
            'topRentedBooks',
            'topRatedBooks',
            'chartLabels',
            'chartRentalsData',
            'chartRevenueData'
        ));
    }

    public function settings(){
        return view('admin.settings');
    }
    public function updateSettings(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::user()->id,
            'password' => 'nullable|min:6',
        ]);

        $user = User::findOrFail(Auth::user()->id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.settings')->with('success', 'Cập nhật cài đặt thành công!');
    }
}
