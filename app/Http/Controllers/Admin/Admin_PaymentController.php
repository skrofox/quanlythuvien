<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use App\Models\Rentals;
use Illuminate\Http\Request;

class Admin_PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with(['user', 'rental.book'])->orderBy('id', 'desc')->get();
        return view('admin.payments.list', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $rentals = Rentals::with('book')->orderBy('id', 'desc')->get();
        return view('admin.payments.create', compact('users', 'rentals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'rental_id' => 'required|exists:rentals,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string|in:momo,paypal,credit_card,bank_transfer,cash',
            'status' => 'required|string|in:pending,paid,failed,refunded',
        ]);

        Payment::create([
            'user_id' => $request->user_id,
            'rental_id' => $request->rental_id,
            'amount' => $request->amount,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.payments.list')->with('success', 'Thêm thanh toán thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment = Payment::findOrFail($id);
        $users = User::orderBy('name')->get();
        $rentals = Rentals::with('book')->orderBy('id', 'desc')->get();
        return view('admin.payments.edit', compact('payment', 'users', 'rentals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payment = Payment::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'rental_id' => 'required|exists:rentals,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string|in:momo,paypal,credit_card,bank_transfer,cash',
            'status' => 'required|string|in:pending,paid,failed,refunded',
        ]);

        $payment->update([
            'user_id' => $request->user_id,
            'rental_id' => $request->rental_id,
            'amount' => $request->amount,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.payments.list')->with('success', 'Cập nhật thanh toán thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->route('admin.payments.list')->with('success', 'Xóa thanh toán thành công!');
    }
}
