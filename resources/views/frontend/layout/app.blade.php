<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        @yield('title', 'BookSaw - Library')
    </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <!-- Google Fonts - Hỗ trợ tiếng Việt -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Serif:wght@400;600;700&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/normalize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/icomoon/icomoon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/style.css') }}">

    <!-- Custom Font Styles for Vietnamese -->
    <style>
        :root {
            --body-font: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            --heading-font: "Noto Serif", "Times New Roman", Times, serif;
            --secondary-font: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            font-family: var(--body-font);
            font-feature-settings: "liga" 1, "kern" 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6 {
            font-family: var(--heading-font);
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        .display-1,
        .display-2,
        .display-3,
        .display-4,
        .display-5,
        .display-6 {
            font-family: var(--heading-font);
        }

        /* Đảm bảo tiếng Việt hiển thị tốt */
        * {
            text-rendering: optimizeLegibility;
        }

        /* Style cho thông báo */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4CAF50;
            /* Màu xanh cho thông báo thành công */
            color: white;
            padding: 15px;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.5s ease-in-out, visibility 0.5s ease-in-out;
            z-index: 9999;
        }

        /* Hiển thị thông báo khi có nội dung */
        .notification.show {
            opacity: 1;
            visibility: visible;
        }
    </style>

    @stack('styles')

</head>

<body data-bs-spy="scroll" data-bs-target="#header" tabindex="0">

    @include('frontend.layout.header')

    <main class="container">
        <div id="notification" class="notification">
            <span id="notification-message"></span>
        </div>
        @yield('content')
    </main>

    @include('frontend.layout.footer')

    <script src="{{ asset('assets/frontend/js/jquery-1.11.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="{{ asset('assets/frontend/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/script.js') }}"></script>

    <script>
        window.onload = function() {
            // Kiểm tra xem có thông báo nào trong session không
            var message = "{{ session('success') }}"; // Lấy thông báo từ Laravel session

            if (message) {
                // Nếu có thông báo, hiển thị thông báo
                var notification = document.getElementById('notification');
                var notificationMessage = document.getElementById('notification-message');

                notificationMessage.textContent = message; // Gán nội dung thông báo

                // Thêm class để hiển thị thông báo
                notification.classList.add('show');

                // Tự động ẩn thông báo sau 3 giây
                setTimeout(function() {
                    notification.classList.remove('show');
                }, 3000); // Thời gian hiển thị là 3 giây
            }
        };
    </script>

    @stack('scripts')
</body>

</html>
