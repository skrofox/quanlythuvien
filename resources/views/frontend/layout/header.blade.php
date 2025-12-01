<div id="header-wrap">

    <div class="top-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="social-links">
                        <ul>
                            <li>
                                <a href="#"><i class="icon icon-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="icon icon-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="icon icon-youtube-play"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="icon icon-behance-square"></i></a>
                            </li>
                        </ul>
                    </div><!--social-links-->
                </div>
                <div class="col-md-8">
                    <div class="right-element">
                        <p class="text-end">Xin chào, <u> {{ Auth::user()->name ?? 'Bạn thân mến' }}!</u></p>
                        <a href="{{ route('account') }}" class="user-account for-buy"><i
                                class="icon icon-user"></i><span>Tài Khoản</span></a>
                        <a href="" class="cart for-buy"><i class="icon icon-clipboard"></i><span>Yêu
                                Thích:(0)</span></a>

                        <div class="action-menu">

                            <div class="search-bar">
                                <a href="#" class="search-button search-toggle" data-selector="#header-wrap">
                                    <i class="icon icon-search"></i>
                                </a>
                                <form role="search" method="get" class="search-box">
                                    <input class="search-field text search-input" placeholder="Search" type="search">
                                </form>
                            </div>
                        </div>

                    </div><!--top-right-->
                </div>

            </div>
        </div>
    </div><!--top-content-->

    <header id="header">
        <div class="container">
            <div class="row">

                <div class="col-md-2">
                    <div class="main-logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('assets/frontend/images/main-logo.png') }}"
                                alt="logo"></a>
                    </div>

                </div>

                <div class="col-md-10">

                    <nav id="navbar">
                        <div class="main-menu stellarnav">
                            <ul class="menu-list">
                                <li class="menu-item active"><a href="{{ route('home') }}">Trang chủ</a></li>
                                <li class="menu-item has-sub">
                                    <a href="#pages" class="nav-link">Trang</a>

                                    <ul>
                                        <li class="active"><a href="index.html">Trang chủ</a></li>
                                        <li><a href="index.html">Về Chúng Tôi</a></li>
                                        <li><a href="index.html">Blog</a></li>
                                        <li><a href="index.html">Liên Hệ</a></li>
                                        <li><a href="index.html">Cảm Ơn</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item"><a href="#latest-blog" class="nav-link">Bài Viết</a></li>
                                <li class="menu-item">
                                    <a href="#pages" class="nav-link">Cá Nhân Hóa</a>

                                    <ul>
                                        <li><a href="{{ route('account') }}">Tài Khoản</a></li>
                                        <li><a href="#">Yêu Thích</a></li>
                                        <li><a href="#">Lịch Sử Đọc</a></li>
                                        @if (!Auth::check())
                                            <li>
                                                <form action="{{ route('login') }}" method="get">
                                                    <button type="submit" class="btn btn-primary m-2"
                                                        style="width: 200px">Đăng
                                                        Nhập</button>
                                                </form>
                                            </li>
                                        @else
                                            <li>
                                                <form action="{{ route('logout') }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger m-2"
                                                        style="width: 200px">Đăng
                                                        Xuất</button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            </ul>

                            <div class="hamburger">
                                <span class="bar"></span>
                                <span class="bar"></span>
                                <span class="bar"></span>
                            </div>

                        </div>
                    </nav>

                </div>

            </div>
        </div>
    </header>

</div><!--header-wrap-->
