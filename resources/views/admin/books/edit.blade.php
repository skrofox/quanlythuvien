@extends('admin.app')

@section('title', 'Edit Book')
@section('page-title', 'Sửa Sách')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <x-adminlte-input name="name" label="Tên Sách" value="{{ old('name', $book->name) }}" />
            <x-adminlte-input name="author" label="Tác giả" value="{{ old('author', $book->author) }}" />
            <x-adminlte-input name="publisher" label="Nhà xuất bản" value="{{ old('publisher', $book->publisher) }}" />
            <x-adminlte-input name="year" label="Năm xuất bản" type="number" value="{{ old('year', $book->year) }}" />

            <div class="p-2">
                <x-adminlte-input-file name="images[]" label="Ảnh sách mới" multiple id="bookImages" />
            </div>

            <!-- Hiển thị ảnh hiện tại -->
            <div class="d-flex flex-wrap gap-2 mb-3">
                @foreach($book->images as $img)
                    <img src="{{ Storage::url($img->url) }}" class="img-thumbnail" style="max-width:200px;">
                @endforeach
            </div>

            <!-- Preview ảnh mới chọn -->
            <div id="preview" class="d-flex flex-wrap gap-2"></div>

            <x-adminlte-button class="btn-primary mt-3" type="submit" label="Cập nhật sách" />
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    document.getElementById('bookImages').addEventListener('change', function (event) {
        const preview = document.getElementById('preview');
        preview.innerHTML = "";
        const files = event.target.files;

        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail');
                    img.style.maxWidth = '150px';
                    img.style.margin = '5px';
                    preview.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
