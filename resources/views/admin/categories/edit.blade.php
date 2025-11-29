@extends('adminlte::page')

@section('title', 'Sửa danh mục')

@section('content_header')
    <h1>Sửa danh mục</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="form-group mb-3">
                <label>Tên danh mục</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name', $category->name) }}">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group mb-3">
                <label>Mô tả danh mục</label>
                <input type="text" name="description" class="form-control"
                       value="{{ old('description', $category->description) }}">
                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.categories.list') }}" class="btn btn-secondary">Quay lại</a>
        </form>

    </div>
</div>
@stop
