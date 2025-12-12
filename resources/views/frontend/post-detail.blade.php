@extends('frontend.layout.app')

@section('title', $post->title . ' - BookSaw Library')

@push('styles')
<style>
    .post-detail-page {
        padding: 2rem 0;
        background-color: #fff;
    }

    .post-header {
        margin-bottom: 2rem;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #333;
        text-decoration: none;
        margin-bottom: 1.5rem;
        transition: color 0.3s;
    }

    .back-button:hover {
        color: var(--accent-color, #C5A992);
    }

    .post-title {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 1rem;
        color: #2f2f2f;
    }

    .post-meta {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e0e0e0;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #757575;
        font-size: 0.9rem;
    }

    .meta-item i {
        color: var(--accent-color, #C5A992);
    }

    .post-image {
        width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 2rem;
        object-fit: cover;
    }

    .post-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #333;
        margin-bottom: 3rem;
    }

    .post-content p {
        margin-bottom: 1.5rem;
    }

    .post-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
    }

    .post-content h1,
    .post-content h2,
    .post-content h3 {
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .sidebar-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .sidebar-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--accent-color, #C5A992);
        color: #2f2f2f;
    }

    .related-post-item {
        padding: 1rem 0;
        border-bottom: 1px solid #f0f0f0;
        transition: padding-left 0.3s;
    }

    .related-post-item:last-child {
        border-bottom: none;
    }

    .related-post-item:hover {
        padding-left: 0.5rem;
    }

    .related-post-link {
        color: #333;
        text-decoration: none;
        font-weight: 500;
        line-height: 1.5;
        display: block;
        transition: color 0.3s;
    }

    .related-post-link:hover {
        color: var(--accent-color, #C5A992);
    }

    .related-posts-section {
        margin-top: 4rem;
        padding-top: 3rem;
        border-top: 2px solid #e0e0e0;
        width: 100%;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 2rem;
        color: #2f2f2f;
        text-align: center;
    }

    .related-category-posts {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .related-category-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .related-category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .related-category-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .related-category-content {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .related-category-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }

    .related-category-title a {
        color: #2f2f2f;
        text-decoration: none;
        transition: color 0.3s;
    }

    .related-category-title a:hover {
        color: var(--accent-color, #C5A992);
    }

    .related-category-summary {
        color: #757575;
        font-size: 0.95rem;
        line-height: 1.6;
        flex: 1;
    }

    .related-category-meta {
        margin-top: 1rem;
        font-size: 0.85rem;
        color: #999;
    }

    @media (max-width: 768px) {
        .post-title {
            font-size: 1.8rem;
        }

        .post-content {
            font-size: 1rem;
        }

        .related-category-posts {
            grid-template-columns: 1fr;
        }

        .post-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }
    }

    @media (min-width: 768px) {
        .related-category-posts {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 992px) {
        .related-category-posts {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (min-width: 1200px) {
        .related-category-posts {
            grid-template-columns: repeat(4, 1fr);
        }
    }
</style>
@endpush

@section('content')
<div class="post-detail-page">
    <div class="container">
        <!-- Nút quay lại -->
        <a href="{{ route('home') }}" class="back-button">
            <i class="icon icon-arrow-left"></i>
            <span>Quay lại trang chủ</span>
        </a>

        <div class="row">
            <!-- Nội dung chính -->
            <div class="col-lg-8">
                <article class="post-article">
                    <!-- Header -->
                    <header class="post-header">
                        <h1 class="post-title">{{ $post->title }}</h1>

                        <div class="post-meta">
                            <div class="meta-item">
                                <i class="icon icon-calendar"></i>
                                <span>{{ $post->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="icon icon-user"></i>
                                <span>{{ $post->user->name ?? 'Admin' }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="icon icon-eye"></i>
                                <span>{{ number_format($post->views) }} lượt xem</span>
                            </div>
                        </div>
                    </header>

                    <!-- Ảnh bài viết -->
                    @if($post->image)
                        <img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" class="post-image">
                    @endif

                    <!-- Tóm tắt -->
                    @if($post->summary)
                        <div class="post-summary" style="font-size: 1.15rem; color: #555; font-style: italic; margin-bottom: 2rem; padding: 1rem; background: #f8f8f8; border-left: 4px solid var(--accent-color, #C5A992);">
                            {{ $post->summary }}
                        </div>
                    @endif

                    <!-- Nội dung -->
                    <div class="post-content">
                        {!! $post->content !!}
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <aside class="post-sidebar">
                    <!-- Bài viết liên quan -->
                    @if($relatedPosts->count() > 0)
                        <div class="sidebar-card">
                            <h3 class="sidebar-title">Bài viết liên quan</h3>
                            <div class="related-posts-list">
                                @foreach($relatedPosts as $relatedPost)
                                    <div class="related-post-item">
                                        <a href="{{ route('post.detail', $relatedPost->slug) }}" class="related-post-link">
                                            {{ Str::limit($relatedPost->title, 70) }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Thông tin bài viết -->
                    <div class="sidebar-card">
                        <h3 class="sidebar-title">Thông tin</h3>
                        <div class="post-info">
                            <div class="meta-item" style="margin-bottom: 0.75rem;">
                                <i class="icon icon-calendar"></i>
                                <span>Ngày đăng: {{ $post->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="meta-item" style="margin-bottom: 0.75rem;">
                                <i class="icon icon-eye"></i>
                                <span>Lượt xem: {{ number_format($post->views) }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="icon icon-tag"></i>
                                <span>Trạng thái:
                                    @if($post->status == 'published')
                                        <span class="badge bg-success">Đã xuất bản</span>
                                    @else
                                        <span class="badge bg-warning">Bản nháp</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

        <!-- Danh sách bài viết cùng chuyên đề - Phía dưới cùng -->
        @if($relatedCategoryPosts->count() > 0)
            <section class="related-posts-section">
                <h2 class="section-title">Tin cùng chuyên mục</h2>
                <div class="related-category-posts">
                    @foreach($relatedCategoryPosts as $relatedPost)
                        <div class="related-category-card">
                            @if($relatedPost->image)
                                <img src="{{ asset('storage/'.$relatedPost->image) }}"
                                     alt="{{ $relatedPost->title }}"
                                     class="related-category-image">
                            @else
                                <div class="related-category-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                    <i class="icon icon-book"></i>
                                </div>
                            @endif
                            <div class="related-category-content">
                                <h3 class="related-category-title">
                                    <a href="{{ route('post.detail', $relatedPost->slug) }}">
                                        {{ Str::limit($relatedPost->title, 80) }}
                                    </a>
                                </h3>
                                @if($relatedPost->summary)
                                    <p class="related-category-summary">
                                        {{ Str::limit($relatedPost->summary, 120) }}
                                    </p>
                                @endif
                                <div class="related-category-meta">
                                    <span>{{ $relatedPost->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</div>
@endsection
