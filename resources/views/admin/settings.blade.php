@extends('admin.app')

@section('title', 'Cài đặt')
@section('page-title', 'Cài đặt')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Cài đặt</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.settings.update', Auth::user()->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Tên</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ auth()->user()->name }}">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                        value="{{ auth()->user()->email }}">
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>

        </div>
    </div>
@endsection
