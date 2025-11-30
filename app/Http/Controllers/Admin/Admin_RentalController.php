<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rentals;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;

class Admin_RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rentals = Rentals::with(['user', 'book'])->orderBy('id', 'desc')->get();
        return view('admin.rentals.list', compact('rentals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $books = Book::orderBy('name')->get();
        return view('admin.rentals.create', compact('users', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'rented_at' => 'required|date',
            'due_at' => 'required|date|after:rented_at',
            'returned_at' => 'nullable|date',
            'status' => 'required|string|in:active,rented,returned,overdue',
        ]);

        Rentals::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'rented_at' => $request->rented_at,
            'due_at' => $request->due_at,
            'returned_at' => $request->returned_at,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.rentals.list')->with('success', 'Thêm thuê sách thành công!');
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
        $rental = Rentals::findOrFail($id);
        $users = User::orderBy('name')->get();
        $books = Book::orderBy('name')->get();
        return view('admin.rentals.edit', compact('rental', 'users', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rental = Rentals::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'rented_at' => 'required|date',
            'due_at' => 'required|date|after:rented_at',
            'returned_at' => 'nullable|date',
            'status' => 'required|string|in:active,rented,returned,overdue',
        ]);

        $rental->update([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'rented_at' => $request->rented_at,
            'due_at' => $request->due_at,
            'returned_at' => $request->returned_at,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.rentals.list')->with('success', 'Cập nhật thuê sách thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rental = Rentals::findOrFail($id);
        $rental->delete();

        return redirect()->route('admin.rentals.list')->with('success', 'Xóa thuê sách thành công!');
    }
}
