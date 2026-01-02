@extends('frontend.layout.app')

@section('title', 'Liên Hệ')

@section('content')
    <section class="py-5 my-4">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h1 class="display-4 mb-3">Liên Hệ</h1>
                    <p class="lead text-muted">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn</p>
                </div>
            </div>

            <div class="row">
                <!-- Form liên hệ -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h3 class="h5 mb-0">Gửi tin nhắn cho chúng tôi</h3>
                        </div>
                        <div class="card-body">
                            <form id="contact-form" method="POST" action="#">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Họ và tên <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="subject" class="form-label">Chủ đề <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                        id="subject" name="subject" value="{{ old('subject') }}" required>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="message" class="form-label">Nội dung tin nhắn <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5"
                                        required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="icon icon-send"></i> Gửi tin nhắn
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Thông tin liên hệ và bản đồ -->
                <div class="col-md-6 mb-4">
                    <!-- Thông tin liên hệ -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-info text-white">
                            <h3 class="h5 mb-0">Thông tin liên hệ</h3>
                        </div>
                        <div class="card-body">
                            <div class="contact-info-item mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="contact-icon me-3">
                                        <i class="icon icon-location" style="font-size: 24px; color: #007bff;"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-2">Địa chỉ</h5>
                                        <p class="text-muted mb-0">
                                            143 Nguyễn Lương Bằng<br>
                                            Quận Liên Chiểu, TP Đà Nẵng<br>
                                            Việt Nam
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="contact-info-item mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="contact-icon me-3">
                                        <i class="icon icon-phone" style="font-size: 24px; color: #28a745;"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-2">Điện thoại</h5>
                                        <p class="text-muted mb-0">
                                            <a href="tel:+84123456789" class="text-decoration-none">+84 123 456 789</a><br>
                                            <a href="tel:+84987654321" class="text-decoration-none">+84 987 654 321</a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="contact-info-item mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="contact-icon me-3">
                                        <i class="icon icon-envelope" style="font-size: 24px; color: #dc3545;"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-2">Email</h5>
                                        <p class="text-muted mb-0">
                                            <a href="mailto:info@thuvien.com"
                                                class="text-decoration-none">info@thuvien.com</a><br>
                                            <a href="mailto:support@thuvien.com"
                                                class="text-decoration-none">support@thuvien.com</a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="contact-info-item">
                                <div class="d-flex align-items-start">
                                    <div class="contact-icon me-3">
                                        <i class="icon icon-clock" style="font-size: 24px; color: #ffc107;"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-2">Giờ làm việc</h5>
                                        <p class="text-muted mb-0">
                                            Thứ 2 - Thứ 6: 8:00 - 18:00<br>
                                            Thứ 7 - Chủ nhật: 9:00 - 17:00
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Google Maps -->
                    <div class="card shadow-sm">
                        {{-- <div class="card-header bg-success text-white">
                            <h3 class="h5 mb-0">Bản đồ</h3>
                        </div>
                        <div class="card-body p-0">
                            <div id="map" style="height: 400px; width: 100%;"></div>
                        </div> --}}
                        <div class="card-body p-0">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3833.7904401422334!2d108.14582087471645!3d16.076360784604155!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314218d3fea0d5d9%3A0xd900c37924c1fa80!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEtpbmggdOG6vyAtIEvhur8gaG_huqFjaCDEkMOgIE7hurVuZw!5e0!3m2!1sen!2s!4v1767337150139!5m2!1sen!2s"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade" async defer></script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            // Xử lý form submit
            document.getElementById('contact-form').addEventListener('submit', function(e) {
                e.preventDefault();

                // Hiển thị thông báo (có thể thay bằng AJAX call)
                alert('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.');

                // Reset form
                this.reset();
            });
        </script>
    @endpush

    <style>
        .contact-info-item {
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .contact-info-item:last-child {
            border-bottom: none;
        }

        .contact-icon {
            min-width: 40px;
            text-align: center;
        }

        #map {
            border-radius: 0 0 0.375rem 0.375rem;
        }

        .card {
            border: none;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>
@endsection
