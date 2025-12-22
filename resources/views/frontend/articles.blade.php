@extends('frontend.layout.app')

@section('title', 'Bài Viết')

@section('content')
    <section id="latest-blog" class="py-5 my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header align-center">
                        <div class="title">
                            <span>ĐỌC BÀI VIẾT CỦA CHÚNG TÔI</span>
                        </div>
                        <h2 class="section-title">BÀI VIẾT</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Sidebar với danh mục -->
                <div class="col-md-3">
                    <div class="sidebar">
                        <h3 class="sidebar-title">Danh Mục</h3>
                        <ul class="category-list">
                            <li>
                                <a href="{{ route('articles.index', request()->only('search')) }}" 
                                   class="{{ !request('category') ? 'active' : '' }}">
                                    Tất Cả
                                </a>
                            </li>
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ route('articles.index', array_merge(request()->only('search'), ['category' => $category->slug])) }}" 
                                       class="{{ request('category') == $category->slug ? 'active' : '' }}">
                                        {{ $category->name }}
                                        <span class="count">({{ $category->posts()->where('status', 'published')->count() }})</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Danh sách bài viết -->
                <div class="col-md-9">
                    <!-- Form tìm kiếm -->
                    <div class="search-form-wrapper mb-4">
                        <form method="get" action="{{ route('articles.index') }}" class="article-search-form">
                            <div class="input-group">
                                <input type="text" 
                                       name="search" 
                                       class="form-control" 
                                       placeholder="Tìm kiếm bài viết..." 
                                       value="{{ request('search') }}">
                                @if(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon icon-search"></i> Tìm kiếm
                                </button>
                                @if(request('search') || request('category'))
                                    <a href="{{ route('articles.index') }}" class="btn btn-secondary">
                                        Xóa bộ lọc
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    @if(request('search'))
                        <div class="search-results mb-4">
                            <p>Kết quả tìm kiếm cho: <strong>"{{ request('search') }}"</strong></p>
                            <p>Tìm thấy <strong>{{ $articles->total() }}</strong> bài viết</p>
                        </div>
                    @endif

                    @if($articles->count() > 0)
                        <div class="row">
                            @foreach ($articles as $article)
                                <div class="col-md-6 mb-4">
                                    <article class="column" data-aos="fade-up">
                                        <figure>
                                            <a href="{{ route('post.detail', $article->slug) }}" class="image-hvr-effect">
                                                <img src="{{ Storage::url($article->image ?? '') }}" alt="post"
                                                    class="post-image" style="width: 100%; height: 250px; object-fit: cover;">
                                            </a>
                                        </figure>

                                        <div class="post-item">
                                            <div class="meta-date">{{ $article->created_at->format('d/m/Y') }}</div>
                                            <h3>
                                                <a href="{{ route('post.detail', $article->slug) }}">
                                                    {{ $article->title }}
                                                </a>
                                            </h3>
                                            
                                            @if($article->summary)
                                                <p class="post-summary">{{ Str::limit($article->summary, 150) }}</p>
                                            @endif

                                            <div class="links-element">
                                                <div class="categories">
                                                    @foreach($article->categories as $category)
                                                        <a href="{{ route('articles.index', array_merge(request()->only('search'), ['category' => $category->slug])) }}" 
                                                           class="category-tag">
                                                            {{ $category->name }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                                <div class="post-meta">
                                                    <span class="author">
                                                        <i class="icon icon-user"></i> {{ $article->user->name ?? 'Admin' }}
                                                    </span>
                                                    <span class="views">
                                                        <i class="icon icon-eye"></i> {{ $article->views ?? 0 }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>

                        <!-- Phân trang -->
                        <div class="pagination-wrapper mt-4">
                            {{ $articles->links() }}
                        </div>
                    @else
                        <div class="no-results text-center py-5">
                            <p class="mb-3">Không tìm thấy bài viết nào.</p>
                            @if(request('search'))
                                <a href="{{ route('articles.index') }}" class="btn btn-outline-accent">
                                    Xem tất cả bài viết
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <style>
        .sidebar {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .sidebar-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ddd;
        }

        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .category-list li {
            margin-bottom: 10px;
        }

        .category-list a {
            display: block;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .category-list a:hover,
        .category-list a.active {
            background: #007bff;
            color: #fff;
        }

        .category-list .count {
            float: right;
            font-size: 0.9em;
            opacity: 0.7;
        }

        .post-summary {
            color: #666;
            margin: 10px 0;
            line-height: 1.6;
        }

        .category-tag {
            display: inline-block;
            padding: 3px 10px;
            background: #e9ecef;
            border-radius: 3px;
            font-size: 0.85em;
            margin-right: 5px;
            margin-bottom: 5px;
            text-decoration: none;
            color: #495057;
        }

        .category-tag:hover {
            background: #007bff;
            color: #fff;
        }

        .post-meta {
            margin-top: 10px;
            font-size: 0.9em;
            color: #666;
        }

        .post-meta span {
            margin-right: 15px;
        }

        .post-meta i {
            margin-right: 5px;
        }

        .search-results {
            padding: 15px;
            background: #e7f3ff;
            border-left: 4px solid #007bff;
            border-radius: 4px;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
        }

        .pagination-wrapper .pagination {
            display: flex;
            list-style: none;
            padding: 0;
        }

        .pagination-wrapper .pagination li {
            margin: 0 5px;
        }

        .pagination-wrapper .pagination a,
        .pagination-wrapper .pagination span {
            display: block;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #007bff;
        }

        .pagination-wrapper .pagination .active span {
            background: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .pagination-wrapper .pagination a:hover {
            background: #f8f9fa;
        }

        .search-form-wrapper {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }

        .article-search-form .input-group {
            display: flex;
            gap: 10px;
        }

        .article-search-form .form-control {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .article-search-form .btn {
            padding: 10px 20px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            white-space: nowrap;
        }

        .article-search-form .btn-primary {
            background: #007bff;
            color: #fff;
        }

        .article-search-form .btn-secondary {
            background: #6c757d;
            color: #fff;
        }

        .article-search-form .btn:hover {
            opacity: 0.9;
        }
    </style>
@endsection
