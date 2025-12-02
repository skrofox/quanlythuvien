@extends('frontend.layout.app')

@section('title', 'Home')

@section('content')

    <section id="billboard">

        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <button class="prev slick-arrow">
                        <i class="icon icon-arrow-left"></i>
                    </button>

                    <div class="main-slider pattern-overlay">
                        @foreach ($sliders as $slider)
                            <div class="slider-item">
                                <div class="banner-content">
                                    <h2 class="banner-title">{{ $slider->name }}</h2>
                                    <p>{{ Str::limit($slider->summary, 200) }}</p>
                                    <div class="btn-wrap">
                                        <a href="{{ route('book.detail', $slider->slug) }}"
                                            class="btn btn-outline-accent btn-accent-arrow">Xem Thêm<i
                                                class="icon icon-ns-arrow-right"></i></a>
                                    </div>
                                </div><!--banner-content-->
                                <img src="{{ Storage::url($slider->images->first()->url ?? '') }}" alt="banner"
                                    class="banner-image">
                            </div><!--slider-item-->
                        @endforeach

                    </div><!--slider-->

                    <button class="next slick-arrow">
                        <i class="icon icon-arrow-right"></i>
                    </button>

                </div>
            </div>
        </div>

    </section>

    <section id="client-holder" data-aos="fade-up">
        <div class="container">
            <div class="row">
                <div class="inner-content">
                    <div class="logo-wrap">
                        <div class="grid">
                            <a href="#"><img src="{{ asset('assets/frontend/images/client-image1.png') }}"
                                    alt="client"></a>
                            <a href="#"><img src="{{ asset('assets/frontend/images/client-image2.png') }}"
                                    alt="client"></a>
                            <a href="#"><img src="{{ asset('assets/frontend/images/client-image3.png') }}"
                                    alt="client"></a>
                            <a href="#"><img src="{{ asset('assets/frontend/images/client-image4.png') }}"
                                    alt="client"></a>
                            <a href="#"><img src="{{ asset('assets/frontend/images/client-image5.png') }}"
                                    alt="client"></a>
                        </div>
                    </div><!--image-holder-->
                </div>
            </div>
        </div>
    </section>

    <section id="featured-books" class="py-5 my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header align-center">
                        <div class="title">
                            <span>Một số cuốn sách chất lượng</span>
                        </div>
                        <h2 class="section-title">Sách Mới</h2>
                    </div>

                    <div class="product-list" data-aos="fade-up">
                        <div class="row">
                            @foreach ($newBooks as $book)
                                <div class="col-md-3">
                                    <div class="product-item">
                                        <a href="{{ route('book.detail', $book->slug) }}">
                                            <figure class="product-style">
                                                <img src="{{ Storage::url($book->images->first()->url ?? '') }}"
                                                    alt="Books" class="product-item">
                                                <button type="button" class="add-to-cart" data-product-tile="add-to-cart">
                                                    Yêu thích</button>
                                            </figure>
                                        </a>
                                        <figcaption>
                                            <h3>{{ $book->name }}</h3>
                                            <span>{{ $book->author }}</span>a
                                            <div class="item-price"><a href="{{ route('book.detail', $book->slug) }}">Đọc
                                                    ngay</a></div>
                                        </figcaption>
                                    </div>
                                </div>
                            @endforeach

                        </div><!--ft-books-slider-->
                    </div><!--grid-->


                </div><!--inner-content-->
            </div>

            <div class="row">
                <div class="col-md-12">

                    <div class="btn-wrap align-right">
                        <a href="#" class="btn-accent-arrow">Xem tất cả sách <i
                                class="icon icon-ns-arrow-right"></i></a>
                    </div>

                </div>
            </div>
        </div>
    </section>


    {{-- <section id="best-selling" class="leaf-pattern-overlay">
        <div class="corner-pattern-overlay"></div>
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-md-8">

                    <div class="row">

                        <div class="col-md-6">
                            <figure class="products-thumb">
                                <img src="images/single-image.jpg" alt="book" class="single-image">
                            </figure>
                        </div>

                        <div class="col-md-6">
                            <div class="product-entry">
                                <h2 class="section-title divider">Best Selling Book</h2>

                                <div class="products-content">
                                    <div class="author-name">By Timbur Hood</div>
                                    <h3 class="item-title">Birds gonna be happy</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eu feugiat amet,
                                        libero ipsum enim pharetra hac.</p>
                                    <div class="item-price">$ 45.00</div>
                                    <div class="btn-wrap">
                                        <a href="#" class="btn-accent-arrow">shop it now <i
                                                class="icon icon-ns-arrow-right"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <!-- / row -->

                </div>

            </div>
        </div>
    </section> --}}

    <section id="popular-books" class="bookshelf py-5 my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header align-center">
                        <div class="title">
                            <span>Một vài cuốn sách tốt</span>
                        </div>
                        <h2 class="section-title">Danh Mục Sách</h2>
                    </div>

                    <ul class="tabs">
                        @foreach ($categories as $index => $category)
                            <li data-tab-target="#{{ $category->slug }}" class="tab {{ $index === 0 ? 'active' : '' }}">
                                {{ $category->name }}</li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach ($categories as $index => $category)
                            <div id="{{ $category->slug }}" data-tab-content class="{{ $index === 0 ? 'active' : '' }}">
                                <div class="row">
                                    @forelse ($category->books as $book)
                                        <div class="col-md-3">
                                            <div class="product-item">
                                                <figure class="product-style">
                                                    <a href="{{ route('book.detail', $book->slug) }}">
                                                        <img src="{{ Storage::url($book->images->first()->url ?? '') }}"
                                                            alt="Books" class="product-item">
                                                    </a>
                                                    <form action="{{ route('book.favorite.store', $book->id) }}"
                                                        method="post">
                                                        @csrf
                                                        <button type="submit" class="add-to-cart"
                                                            data-product-tile="add-to-cart">Yêu thích</button>
                                                    </form>
                                                </figure>
                                                <figcaption>
                                                    <h3>{{ $book->name }}</h3>
                                                    <span>{{ $book->author }}</span>
                                                    <div class="item-price">
                                                        <a href="{{ route('book.detail', $book->slug) }}">Đọc ngay</a>
                                                    </div>
                                                </figcaption>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-md-12">
                                            <p class="text-center">Chưa có sách trong danh mục này.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div><!--inner-tabs-->

            </div>
        </div>
    </section>

    <section id="quotation" class="align-center pb-5 mb-5">
        <div class="inner-content">
            <h2 class="section-title divider">Trích dẫn trong ngày</h2>
            <blockquote data-aos="fade-up">
                <q>
                    “errrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr.”
                </q>
                <div class="author-name">Dr. Seuss</div>
            </blockquote>
        </div>
    </section>

    {{-- <section id="special-offer" class="bookshelf pb-5 mb-5">

        <div class="section-header align-center">
            <div class="title">
                <span>Grab your opportunity</span>
            </div>
            <h2 class="section-title">Books with offer</h2>
        </div>

        <div class="container">
            <div class="row">
                <div class="inner-content">
                    <div class="product-list" data-aos="fade-up">
                        <div class="grid product-grid">
                            <div class="product-item">
                                <figure class="product-style">
                                    <img src="images/product-item5.jpg" alt="Books" class="product-item">
                                    <button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to
                                        Cart</button>
                                </figure>
                                <figcaption>
                                    <h3>Simple way of piece life</h3>
                                    <span>Armor Ramsey</span>
                                    <div class="item-price">
                                        <span class="prev-price">$ 50.00</span>$ 40.00
                                    </div>
                            </div>
                            </figcaption>

                            <div class="product-item">
                                <figure class="product-style">
                                    <img src="images/product-item6.jpg" alt="Books" class="product-item">
                                    <button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to
                                        Cart</button>
                                </figure>
                                <figcaption>
                                    <h3>Great travel at desert</h3>
                                    <span>Sanchit Howdy</span>
                                    <div class="item-price">
                                        <span class="prev-price">$ 30.00</span>$ 38.00
                                    </div>
                            </div>
                            </figcaption>

                            <div class="product-item">
                                <figure class="product-style">
                                    <img src="images/product-item7.jpg" alt="Books" class="product-item">
                                    <button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to
                                        Cart</button>
                                </figure>
                                <figcaption>
                                    <h3>The lady beauty Scarlett</h3>
                                    <span>Arthur Doyle</span>
                                    <div class="item-price">
                                        <span class="prev-price">$ 35.00</span>$ 45.00
                                    </div>
                            </div>
                            </figcaption>

                            <div class="product-item">
                                <figure class="product-style">
                                    <img src="images/product-item8.jpg" alt="Books" class="product-item">
                                    <button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to
                                        Cart</button>
                                </figure>
                                <figcaption>
                                    <h3>Once upon a time</h3>
                                    <span>Klien Marry</span>
                                    <div class="item-price">
                                        <span class="prev-price">$ 25.00</span>$ 35.00
                                    </div>
                            </div>
                            </figcaption>

                            <div class="product-item">
                                <figure class="product-style">
                                    <img src="images/product-item2.jpg" alt="Books" class="product-item">
                                    <button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to
                                        Cart</button>
                                </figure>
                                <figcaption>
                                    <h3>Simple way of piece life</h3>
                                    <span>Armor Ramsey</span>
                                    <div class="item-price">$ 40.00</div>
                                </figcaption>
                            </div>
                        </div><!--grid-->
                    </div>
                </div><!--inner-content-->
            </div>
        </div>
    </section> --}}

    <section id="subscribe">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-md-8">
                    <div class="row">

                        <div class="col-md-6">

                            <div class="title-element">
                                <h2 class="section-title divider">Đăng ký nhận bản tin của chúng tôi</h2>
                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="subscribe-content" data-aos="fade-up">
                                <p>Đăng ký nhận bản tin để nhận thông tin mới nhất từ chúng tôi.</p>
                                <form id="form">
                                    <input type="text" name="email" placeholder="Nhập địa chỉ email của bạn">
                                    <button class="btn-subscribe">
                                        <span>Gửi</span>
                                        <i class="icon icon-send"></i>
                                    </button>
                                </form>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="latest-blog" class="py-5 my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header align-center">
                        <div class="title">
                            <span>ĐỌC BÀI VIẾT CỦA CHÚNG TÔI</span>
                        </div>
                        <h2 class="section-title">BÀI ĐỌC</h2>
                    </div>

                    <div class="row">

                        <div class="col-md-4">

                            <article class="column" data-aos="fade-up">

                                <figure>
                                    <a href="#" class="image-hvr-effect">
                                        <img src="images/post-img1.jpg" alt="post" class="post-image">
                                    </a>
                                </figure>

                                <div class="post-item">
                                    <div class="meta-date">Mar 30, 2021</div>
                                    <h3><a href="#">Reading books always makes the moments happy</a></h3>

                                    <div class="links-element">
                                        <div class="categories">inspiration</div>
                                        <div class="social-links">
                                            <ul>
                                                <li>
                                                    <a href="#"><i class="icon icon-facebook"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="icon icon-twitter"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="icon icon-behance-square"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!--links-element-->

                                </div>
                            </article>

                        </div>
                        <div class="col-md-4">

                            <article class="column" data-aos="fade-up" data-aos-delay="200">
                                <figure>
                                    <a href="#" class="image-hvr-effect">
                                        <img src="images/post-img2.jpg" alt="post" class="post-image">
                                    </a>
                                </figure>
                                <div class="post-item">
                                    <div class="meta-date">Mar 29, 2021</div>
                                    <h3><a href="#">Reading books always makes the moments happy</a></h3>

                                    <div class="links-element">
                                        <div class="categories">inspiration</div>
                                        <div class="social-links">
                                            <ul>
                                                <li>
                                                    <a href="#"><i class="icon icon-facebook"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="icon icon-twitter"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="icon icon-behance-square"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!--links-element-->

                                </div>
                            </article>

                        </div>
                        <div class="col-md-4">

                            <article class="column" data-aos="fade-up" data-aos-delay="400">
                                <figure>
                                    <a href="#" class="image-hvr-effect">
                                        <img src="images/post-img3.jpg" alt="post" class="post-image">
                                    </a>
                                </figure>
                                <div class="post-item">
                                    <div class="meta-date">Feb 27, 2021</div>
                                    <h3><a href="#">Reading books always makes the moments happy</a></h3>

                                    <div class="links-element">
                                        <div class="categories">inspiration</div>
                                        <div class="social-links">
                                            <ul>
                                                <li>
                                                    <a href="#"><i class="icon icon-facebook"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="icon icon-twitter"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="icon icon-behance-square"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!--links-element-->

                                </div>
                            </article>

                        </div>

                    </div>

                    <div class="row">

                        <div class="btn-wrap align-center">
                            <a href="#" class="btn btn-outline-accent btn-accent-arrow" tabindex="0">Read All
                                Articles<i class="icon icon-ns-arrow-right"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        .product-item {
            width: 100%;
            height: 100%;
        }

        .product-style {
            width: 100%;
            height: 350px;
            /* chiều cao cố định cho vùng ảnh */
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .product-style img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* ảnh luôn full khung mà không méo */
            border-radius: 5px;
        }

        .product-item .figcaption,
        figcaption {
            min-height: 120px;
            /* chiều cao cố định phần text nếu muốn đồng đều */
        }
    </style>
@endpush


@push('scripts')
    <script>
        fetch('{{ route('quotes') }}')
            .then(response => response.json())
            .then(data => {
                const quoteText = document.querySelector('#quotation q');
                const authorName = document.querySelector('#quotation .author-name');

                if (Array.isArray(data) && data.length > 0) {
                    quoteText.textContent = data[0].q;
                    authorName.textContent = data[0].a;
                } else {
                    quoteText.textContent = "Hãy cho tôi tình yêu.";
                    authorName.textContent = "Booksaw";
                }
            })
            .catch(error => {
                console.error('Error fetching:', error);
                document.querySelector('#quotation q').textContent = "Không thể tải quote.";
            });
    </script>
@endpush
