@extends('frontend.layout.app')

@section('title', 'Cảm Ơn')

@section('content')
    <section class="py-5 my-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="text-center mb-5">
                        <!-- Icon cảm ơn -->
                        <div class="thanks-icon mb-4">
                            <div class="icon-circle bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 120px; height: 120px;">
                                <i class="icon icon-check" style="font-size: 64px;"></i>
                            </div>
                        </div>

                        <h1 class="display-4 mb-3">Cảm Ơn Bạn!</h1>
                        <p class="lead text-muted mb-4">
                            Chúng tôi rất cảm kích sự quan tâm và ủng hộ của bạn dành cho thư viện của chúng tôi.
                        </p>
                    </div>

                    <!-- Nội dung cảm ơn -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body p-5">
                            <div class="thanks-content text-center">
                                <h3 class="h4 mb-4">Bạn đã làm gì đó tuyệt vời!</h3>
                                <p class="text-muted mb-4">
                                    Dù bạn đã mượn sách, đăng ký thành viên, hay đơn giản là ghé thăm trang web của chúng tôi, 
                                    chúng tôi đều rất biết ơn sự quan tâm của bạn.
                                </p>
                                <p class="text-muted mb-4">
                                    Thư viện của chúng tôi luôn nỗ lực để mang đến những trải nghiệm tốt nhất cho bạn. 
                                    Nếu bạn có bất kỳ câu hỏi hoặc góp ý nào, đừng ngần ngại liên hệ với chúng tôi.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Các hành động tiếp theo -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="action-card text-center p-4 border rounded h-100">
                                <div class="action-icon mb-3">
                                    <i class="icon icon-book" style="font-size: 48px; color: #007bff;"></i>
                                </div>
                                <h5 class="mb-3">Khám phá sách</h5>
                                <p class="text-muted small mb-3">
                                    Khám phá kho sách phong phú của chúng tôi
                                </p>
                                <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm">
                                    Xem sách ngay
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="action-card text-center p-4 border rounded h-100">
                                <div class="action-icon mb-3">
                                    <i class="icon icon-envelope" style="font-size: 48px; color: #28a745;"></i>
                                </div>
                                <h5 class="mb-3">Liên hệ với chúng tôi</h5>
                                <p class="text-muted small mb-3">
                                    Chúng tôi luôn sẵn sàng hỗ trợ bạn
                                </p>
                                <a href="{{ route('contact') }}" class="btn btn-outline-success btn-sm">
                                    Liên hệ ngay
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin bổ sung -->
                    <div class="card bg-light">
                        <div class="card-body p-4">
                            <h5 class="h6 mb-3">Bạn có thể quan tâm:</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="icon icon-arrow-right text-primary me-2"></i>
                                    <a href="{{ route('about') }}" class="text-decoration-none">Tìm hiểu thêm về chúng tôi</a>
                                </li>
                                <li class="mb-2">
                                    <i class="icon icon-arrow-right text-primary me-2"></i>
                                    <a href="{{ route('articles.index') }}" class="text-decoration-none">Đọc các bài viết mới nhất</a>
                                </li>
                                <li class="mb-2">
                                    <i class="icon icon-arrow-right text-primary me-2"></i>
                                    <a href="{{ route('home') }}" class="text-decoration-none">Quay về trang chủ</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Nút quay về trang chủ -->
                    <div class="text-center mt-5">
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                            <i class="icon icon-home"></i> Quay về trang chủ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .thanks-icon {
            animation: scaleIn 0.5s ease-out;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .icon-circle {
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
            }
            50% {
                box-shadow: 0 4px 20px rgba(40, 167, 69, 0.5);
            }
        }

        .action-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .thanks-content {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection

