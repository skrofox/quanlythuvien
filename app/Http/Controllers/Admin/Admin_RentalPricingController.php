<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RentalPricing;
use Illuminate\Http\Request;

class Admin_RentalPricingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rentalPricings = RentalPricing::orderBy('period_days')->get();
        return view('admin.rental-pricings.list', compact('rentalPricings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xử lý checkbox is_active trước (checkbox không checked sẽ không gửi trong request)
        $request->merge([
            'is_active' => $request->has('is_active') ? 1 : 0
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'period_days' => 'required|integer|min:1|unique:rental_pricings,period_days',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        RentalPricing::create([
            'name' => $validated['name'],
            'period_days' => $validated['period_days'],
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'is_active' => (bool) $validated['is_active'],
        ]);

        return back()->with('success', 'Thêm mức giá thành công!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $rentalPricing = RentalPricing::findOrFail($id);
        if (!$rentalPricing) {
            return back();
        }
        return view('admin.rental-pricings.edit', compact('rentalPricing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rentalPricing = RentalPricing::findOrFail($id);
        if (!$rentalPricing) {
            return redirect()->route('admin.rental-pricings.list')
                ->with('error', 'Không tìm thấy mức giá!');
        }

        // Xử lý checkbox is_active trước (checkbox không checked sẽ không gửi trong request)
        $request->merge([
            'is_active' => $request->has('is_active') ? 1 : 0
        ]);

        // Kiểm tra nếu period_days không thay đổi thì không cần unique
        $periodDaysRule = 'required|integer|min:1';
        if ($request->period_days != $rentalPricing->period_days) {
            $periodDaysRule .= "|unique:rental_pricings,period_days,$id";
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'period_days' => $periodDaysRule,
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $rentalPricing->update([
            'name' => $validated['name'],
            'period_days' => (int) $validated['period_days'],
            'price' => (float) $validated['price'],
            'description' => $validated['description'] ?? null,
            'is_active' => (bool) $validated['is_active'],
        ]);

        return redirect()
            ->route('admin.rental-pricings.list')
            ->with('success', 'Cập nhật mức giá thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rentalPricing = RentalPricing::findOrFail($id);

        // Kiểm tra xem có rental nào đang sử dụng mức giá này không
        if ($rentalPricing->rentals()->count() > 0) {
            return back()->with('error', 'Không thể xóa mức giá này vì đang có giao dịch sử dụng!');
        }

        $rentalPricing->delete();

        return back()->with('success', 'Xóa mức giá thành công!');
    }
}
