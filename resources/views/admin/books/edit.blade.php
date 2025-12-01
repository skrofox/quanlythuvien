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
            <x-adminlte-textarea name="summary" label="Tóm tắt" rows="3"> {{ $book->summary }} </x-adminlte-textarea>
            <x-adminlte-input name="publisher" label="Nhà xuất bản" value="{{ old('publisher', $book->publisher) }}" />
            <x-adminlte-input name="year" label="Năm xuất bản" type="number" value="{{ old('year', $book->year) }}" />

            <!-- Chọn danh mục -->
            <div class="mb-3">
                <label>Danh mục</label>
                <div class="d-flex flex-wrap">
                    @foreach($categories as $cat)
                        <div class="form-check me-3" style="margin-right: 12px">
                            <input class="form-check-input" type="checkbox"
                                   name="categories[]" value="{{ $cat->id }}" id="cat{{ $cat->id }}"
                                   {{ in_array($cat->id, $book->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                            <label class="form-check-label" for="cat{{ $cat->id }}">
                                {{ $cat->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Upload ảnh mới -->
            <div class="p-2">
                <x-adminlte-input-file name="images[]" label="Ảnh sách mới" multiple id="bookImages" />
            </div>

            <!-- Hiển thị ảnh hiện tại -->
            <h3>Ảnh cũ</h3>
            <div id="current-images" class="d-flex flex-wrap gap-2 mb-3">
                @foreach($book->images as $img)
                    <img src="{{ asset('storage/'.$img->url) }}" class="img-thumbnail" style="max-width:150px;">
                @endforeach
            </div>

            <!-- Preview ảnh mới chọn -->
            <h3>Ảnh mới</h3>
            <div id="preview" class="d-flex flex-wrap gap-2"></div>

            <x-adminlte-button class="btn-primary mt-3" type="submit" label="Cập nhật sách" />
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    const inputFile = document.getElementById('bookImages');
    const preview = document.getElementById('preview');
    const currentImages = document.getElementById('current-images');

    inputFile.addEventListener('change', function(event) {
        // Nếu chọn ảnh mới thì ẩn ảnh cũ
        if (event.target.files.length > 0) {
            currentImages.style.display = 'none'; // ẩn ảnh cũ
            preview.innerHTML = ""; // clear preview cũ

            Array.from(event.target.files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
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
        } else {
            // Nếu không chọn ảnh mới thì hiển thị lại ảnh cũ
            currentImages.style.display = 'flex';
            preview.innerHTML = "";
        }
    });
</script>
@endsection
