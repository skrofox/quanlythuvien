@extends('admin.app')

@section('title', 'Books List')
@section('page-title', 'Thêm Sách')

@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.books.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <x-adminlte-input name="name" label="Tên Sách" placeholder="Nhập tên sách" />
                <x-adminlte-input name="author" label="Tác giả" placeholder="Tên tác giả" />
                <x-adminlte-input name="publisher" label="Nhà xuất bản" placeholder="Nhà xuất bản" />
                <x-adminlte-input name="year" label="Năm xuất bản" type="number" placeholder="Năm xuất bản" />


                <!-- Chọn danh mục -->
                <div class="mb-3">
                    <label>Danh mục</label>
                    <div class="d-flex flex-wrap">
                        @foreach ($categories as $cat)
                            <div class="form-check me-3" style="margin-right: 12px">
                                <input class="form-check-input" type="checkbox" name="categories[]"
                                    value="{{ $cat->id }}" id="cat{{ $cat->id }}">
                                <label class="form-check-label" for="cat{{ $cat->id }}">
                                    {{ $cat->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>


                <div class="p-2">
                    <x-adminlte-input-file name="images[]" label="Ảnh sách" multiple id="bookImages" />
                </div>

                <!-- Preview zone -->
                <div id="preview" class="d-flex flex-wrap gap-2"></div>


                <x-adminlte-button class="btn-primary mt-3" type="submit" label="Lưu sách" />
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script>
        document.getElementById('bookImages').addEventListener('change', function(event) {
            const preview = document.getElementById('preview');
            preview.innerHTML = ""; // clear old previews
            const files = event.target.files;

            Array.from(files).forEach(file => {
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
        });
    </script>
@endsection
