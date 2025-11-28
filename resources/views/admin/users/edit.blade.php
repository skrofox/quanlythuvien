@extends('adminlte::page')

@section('title', 'Sửa người dùng')

@section('content_header')
    <h1>Sửa người dùng</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="form-group mb-3">
                <label>Họ và tên</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name', $user->name) }}">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Email --}}
            <div class="form-group mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email', $user->email) }}">
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Role --}}
            <div class="form-group mb-3">
                <label>Quyền (Role)</label>
                <select name="role" class="form-control">
                    <option value="user" @if ($user->role == 'user') selected @endif>User</option>
                    <option value="admin" @if ($user->role == 'admin') selected @endif>Admin</option>
                </select>
                @error('role') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Password --}}
            <div class="form-group mb-3">
                <label>Mật khẩu (để trống nếu không đổi)</label>
                <input type="password" name="password" class="form-control">
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.users.list') }}" class="btn btn-secondary">Quay lại</a>
        </form>

    </div>
</div>
@stop
