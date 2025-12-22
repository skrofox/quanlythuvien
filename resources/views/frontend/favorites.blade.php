@extends('frontend.layout.app')

@section('title', 'Sách yêu thích')

@section('content')
    <section class="py-5 my-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Sách yêu thích</h2>
                <p class="text-muted mb-0">
                    Bạn đang có <strong>{{ $favorites->count() }}</strong> cuốn sách trong danh sách yêu thích.
                </p>
            </div>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                ← Quay về trang chủ
            </a>
        </div>

        @if ($favorites->isEmpty())
            <div class="text-center py-5">
                <h5 class="mb-3">Bạn chưa có sách yêu thích nào.</h5>
                <p class="text-muted mb-4">Hãy khám phá thư viện và thêm những cuốn sách bạn yêu thích.</p>
                <a href="{{ route('home') }}" class="btn btn-primary">Khám phá sách</a>
            </div>
        @else
            <div class="row">
                @foreach ($favorites as $favorite)
                    @php
                        $book = $favorite->book;
                    @endphp
                    @if ($book)
                        <div class="col-md-3 mb-4">
                            <div class="product-item h-100 d-flex flex-column">
                                <figure class="product-style">
                                    <a href="{{ route('book.detail', $book->slug) }}">
                                        <img src="{{ Storage::url($book->images->first()->url ?? '') }}"
                                             alt="{{ $book->name }}" class="product-item">
                                    </a>
                                    <form action="{{ route('book.favorite.store', $book->id) }}" method="post">
                                        @csrf
                                        <button type="submit"
                                                class="add-to-cart btn btn-sm btn-outline-danger"
                                                data-product-tile="add-to-cart">
                                            Bỏ yêu thích
                                        </button>
                                    </form>
                                </figure>
                                <figcaption class="mt-auto">
                                    <h3 class="h6 mb-1">{{ $book->name }}</h3>
                                    <span class="text-muted d-block mb-2">{{ $book->author }}</span>
                                    <div class="item-price">
                                        <a href="{{ route('book.detail', $book->slug) }}">Đọc ngay</a>
                                    </div>
                                </figcaption>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </section>
@endsection


