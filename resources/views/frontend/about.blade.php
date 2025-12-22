@extends('frontend.layout.app')

@section('title', 'Về Chúng Tôi')

@section('content')
    <section class="py-5 my-4">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h1 class="display-4 mb-3">Về Chúng Tôi</h1>
                    <p class="lead text-muted">Thư viện số hiện đại, nơi tri thức được chia sẻ</p>
                </div>
            </div>

            <!-- Giới thiệu chính -->
            <div class="row mb-5">
                <div class="col-md-6 mb-4">
                    <div class="about-content">
                        <h2 class="h3 mb-4">Sứ mệnh của chúng tôi</h2>
                        <p class="text-muted mb-3">
                            Chúng tôi cam kết mang đến một nền tảng thư viện số hiện đại, nơi mọi người có thể dễ dàng 
                            tiếp cận với kho tàng tri thức phong phú. Với sứ mệnh phổ biến văn hóa đọc và nâng cao 
                            kiến thức cho cộng đồng, chúng tôi không ngừng nỗ lực để mang đến những trải nghiệm tốt nhất.
                        </p>
                        <p class="text-muted">
                            Thư viện của chúng tôi không chỉ là nơi lưu trữ sách, mà còn là không gian kết nối 
                            những người yêu sách, chia sẻ tri thức và cùng nhau phát triển.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="about-image">
                        <div class="image-placeholder bg-light rounded shadow-sm d-flex align-items-center justify-content-center" 
                             style="height: 400px;">
                            <div class="text-center text-muted">
                                <i class="icon icon-book" style="font-size: 64px;"></i>
                                <p class="mt-3">Hình ảnh về thư viện</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Giá trị cốt lõi -->
            <div class="row mb-5">
                <div class="col-12">
                    <h2 class="h3 text-center mb-5">Giá trị cốt lõi</h2>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="value-card text-center p-4 h-100 border rounded shadow-sm">
                        <div class="value-icon mb-3">
                            <i class="icon icon-book" style="font-size: 48px; color: #007bff;"></i>
                        </div>
                        <h4 class="h5 mb-3">Đa dạng sách</h4>
                        <p class="text-muted">
                            Kho sách phong phú với hàng nghìn đầu sách thuộc nhiều thể loại khác nhau, 
                            đáp ứng mọi nhu cầu đọc của bạn.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="value-card text-center p-4 h-100 border rounded shadow-sm">
                        <div class="value-icon mb-3">
                            <i class="icon icon-clock" style="font-size: 48px; color: #28a745;"></i>
                        </div>
                        <h4 class="h5 mb-3">Tiện lợi 24/7</h4>
                        <p class="text-muted">
                            Truy cập và đọc sách mọi lúc, mọi nơi. Không cần đến thư viện, 
                            bạn vẫn có thể tận hưởng kho tàng tri thức.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="value-card text-center p-4 h-100 border rounded shadow-sm">
                        <div class="value-icon mb-3">
                            <i class="icon icon-heart" style="font-size: 48px; color: #dc3545;"></i>
                        </div>
                        <h4 class="h5 mb-3">Dịch vụ tận tâm</h4>
                        <p class="text-muted">
                            Đội ngũ nhân viên chuyên nghiệp, luôn sẵn sàng hỗ trợ và phục vụ 
                            bạn với tất cả sự nhiệt tình và tận tâm.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Thống kê -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="stats-section bg-light p-5 rounded">
                        <h2 class="h3 text-center mb-5">Thống kê</h2>
                        <div class="row text-center">
                            <div class="col-md-3 mb-4">
                                <div class="stat-item">
                                    <div class="stat-number display-4 text-primary mb-2">1000+</div>
                                    <div class="stat-label text-muted">Đầu sách</div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="stat-item">
                                    <div class="stat-number display-4 text-success mb-2">5000+</div>
                                    <div class="stat-label text-muted">Thành viên</div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="stat-item">
                                    <div class="stat-number display-4 text-info mb-2">10000+</div>
                                    <div class="stat-label text-muted">Lượt mượn</div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="stat-item">
                                    <div class="stat-number display-4 text-warning mb-2">50+</div>
                                    <div class="stat-label text-muted">Danh mục</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lịch sử -->
            <div class="row">
                <div class="col-12">
                    <h2 class="h3 text-center mb-4">Lịch sử phát triển</h2>
                    <div class="timeline">
                        <div class="timeline-item mb-4">
                            <div class="row">
                                <div class="col-md-2 text-center">
                                    <div class="timeline-year bg-primary text-white rounded p-3">
                                        <strong>2020</strong>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="timeline-content p-3 bg-light rounded">
                                        <h5 class="mb-2">Thành lập</h5>
                                        <p class="text-muted mb-0">
                                            Thư viện được thành lập với mục tiêu phổ biến văn hóa đọc 
                                            và mang tri thức đến với mọi người.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item mb-4">
                            <div class="row">
                                <div class="col-md-2 text-center">
                                    <div class="timeline-year bg-success text-white rounded p-3">
                                        <strong>2022</strong>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="timeline-content p-3 bg-light rounded">
                                        <h5 class="mb-2">Mở rộng</h5>
                                        <p class="text-muted mb-0">
                                            Mở rộng kho sách và nâng cấp hệ thống, phục vụ tốt hơn 
                                            nhu cầu của độc giả.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item mb-4">
                            <div class="row">
                                <div class="col-md-2 text-center">
                                    <div class="timeline-year bg-info text-white rounded p-3">
                                        <strong>2024</strong>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="timeline-content p-3 bg-light rounded">
                                        <h5 class="mb-2">Hiện đại hóa</h5>
                                        <p class="text-muted mb-0">
                                            Chuyển đổi số hoàn toàn, mang đến trải nghiệm đọc sách 
                                            trực tuyến hiện đại và tiện lợi.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .value-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .value-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
        }

        .stat-item {
            padding: 20px;
        }

        .timeline-year {
            font-size: 1.2rem;
            min-width: 80px;
        }

        .timeline-content {
            border-left: 3px solid #007bff;
        }
    </style>
@endsection

