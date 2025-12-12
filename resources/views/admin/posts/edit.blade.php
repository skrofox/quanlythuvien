@extends('admin.app')

@section('title', 'Sửa bài viết')
@section('page-title', 'Sửa bài viết')

@section('content')

    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" id="postForm">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title">Tiêu đề <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title', $post->title) }}" required>
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="summary">Tóm tắt</label>
                    <textarea name="summary" id="summary" class="form-control @error('summary') is-invalid @enderror" 
                              rows="3">{{ old('summary', $post->summary) }}</textarea>
                    @error('summary')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="content">Nội dung <span class="text-danger">*</span></label>
                    <textarea name="content" id="content" class="form-control" rows="10">{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div id="content-error" class="text-danger" style="display: none;">Vui lòng nhập nội dung bài viết</div>
                </div>

                <div class="mb-3">
                    <label for="status">Trạng thái <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                        <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                    </select>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Chọn danh mục -->
                <div class="mb-3">
                    <label>Danh mục</label>
                    <div class="d-flex flex-wrap">
                        @foreach($categories as $cat)
                            <div class="form-check me-3" style="margin-right: 12px">
                                <input class="form-check-input" type="checkbox"
                                       name="categories[]" value="{{ $cat->id }}" id="cat{{ $cat->id }}"
                                       {{ in_array($cat->id, $post->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cat{{ $cat->id }}">
                                    {{ $cat->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Upload ảnh mới -->
                <div class="mb-3">
                    <label for="postImage">Ảnh bài viết mới</label>
                    <input type="file" name="image" id="postImage" class="form-control @error('image') is-invalid @enderror" 
                           accept="image/jpeg,image/jpg,image/png">
                    <small class="text-muted">Chỉ chấp nhận file ảnh (JPG, PNG), tối đa 2MB</small>
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Hiển thị ảnh hiện tại -->
                @if($post->image)
                    <div class="mb-3">
                        <label>Ảnh hiện tại</label>
                        <div>
                            <img src="{{ asset('storage/'.$post->image) }}" class="img-thumbnail" style="max-width:300px;" alt="Ảnh bài viết">
                        </div>
                    </div>
                @endif

                <!-- Preview ảnh mới chọn -->
                <div id="preview" class="mb-3"></div>

                <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> Cập nhật bài viết
                </button>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        let editor;
        
        // CKEditor
        ClassicEditor
            .create(document.querySelector('#content'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', '|', 'undo', 'redo'],
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                    ]
                }
            })
            .then(editorInstance => {
                editor = editorInstance;
            })
            .catch(error => {
                console.error(error);
            });

        // Đảm bảo CKEditor sync dữ liệu và validate trước khi submit
        document.getElementById('postForm').addEventListener('submit', function(e) {
            if (editor) {
                // Sync dữ liệu từ CKEditor vào textarea
                editor.updateSourceElement();
                
                // Validate nội dung
                const content = editor.getData().trim();
                const contentError = document.getElementById('content-error');
                
                if (!content || content === '') {
                    e.preventDefault();
                    contentError.style.display = 'block';
                    // Scroll đến phần nội dung
                    document.getElementById('content').scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return false;
                } else {
                    contentError.style.display = 'none';
                }
            } else {
                // Nếu CKEditor chưa load, validate textarea thông thường
                const content = document.getElementById('content').value.trim();
                const contentError = document.getElementById('content-error');
                
                if (!content || content === '') {
                    e.preventDefault();
                    contentError.style.display = 'block';
                    document.getElementById('content').scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return false;
                } else {
                    contentError.style.display = 'none';
                }
            }
        });

        // Preview ảnh
        const inputFile = document.getElementById('postImage');
        const preview = document.getElementById('preview');

        inputFile.addEventListener('change', function(event) {
            preview.innerHTML = "";
            const file = event.target.files[0];

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail');
                    img.style.maxWidth = '300px';
                    img.style.marginTop = '10px';
                    preview.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@stop

