<!DOCTYPE html>

<body lang="en">

    <head>
        <meta charset="utf-8">
        <title>@yield("title")</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&family=Roboto:wght@500;700&display=swap"
            rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/assets/bootstrap/bootstrap-icons/font/bootstrap-icons.min.css">
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />

        <!-- Libraries Stylesheet -->
        <!-- <link href="/assets/userPage/lib/animate/animate.min.css" rel="stylesheet"> -->
        <link href="/assets/userPage/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="/assets/userPage/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
        <link href="/assets/chatbot/chatbot.css" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link rel="stylesheet" href="/assets/bootstrap/bootstrap-5.3.0/css/bootstrap.min.css">

        <!-- Template Stylesheet -->
        <link href="/assets/userPage/css/style.css" rel="stylesheet">
    </head>
    <style>
        /* Hiệu ứng fade cho dropdown */
        .animated.fadeIn {
            animation: fadeIn 0.3s ease-in-out;
        }

        .ms-auto .nav-link {
            color: white;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Căn chỉnh dropdown */
        .dropdown-menu {
            min-width: 220px;
            border-radius: 0.5rem;
            padding: 0.5rem 0;
        }

        /* Hover item đẹp hơn */
        .dropdown-item {
            padding: 0.6rem 1rem;
            transition: background-color 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f0f0f0;
        }


        .dropdown-item.text-danger:hover {
            background-color: #ffe5e5;
        }

        .container-navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
    </style>
</body>
<!-- Spinner Start -->
<div id="spinner"
    class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
</div>
<!-- Spinner End -->


<!-- Topbar Start -->
<div class="container-fluid bg-primary text-white d-none d-lg-flex">
    <div class="container py-3">
        <div class="d-flex align-items-center">
            <a href="{{route("userpage.home")}}">
                <h4 class="text-white fw-bold m-0">Trafficbot</h4>
            </a>
            <div class="ms-auto d-flex align-items-center">
                <div class="ms-3 d-flex">
                    <a class="btn btn-sm-square btn-light text-primary rounded-circle ms-2" href=""><i
                            class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-sm-square btn-light text-primary rounded-circle ms-2" href=""><i
                            class="fab fa-twitter"></i></a>
                    <a class="btn btn-sm-square btn-light text-primary rounded-circle ms-2" href=""><i
                            class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->


<!-- Navbar Start -->
<div class="container-fluid bg-white sticky-top container-navbar">
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-white navbar-light p-lg-0">
            <a href="{{ route("userpage.home") }}" class="navbar-brand d-lg-none">
                <h4 class="fw-bold m-0">TrafficBot</h4>
            </a>
            <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav">
                    <a href="{{ route("userpage.home") }}" class="nav-item nav-link">Trang
                        chủ</a>
                    <!-- <div class="nav-item dropdown">

                        <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Thi lý thuyết xe máy</a>
                        <div class="dropdown-menu bg-light rounded-0 rounded-bottom m-0 ">
                            @isset($licenses)
                                @foreach ($licenses as $license)
                                    @if($license->LicenseTypeName == "A1" || $license->LicenseTypeName == "A2")
                                        <a href="{{ route("userpage.practiceExam", $license->LicenseTypeID) }}"
                                            class="dropdown-item">Hạng {{ $license->LicenseTypeName }}</a>
                                    @endif
                                @endforeach
                            @endisset

                        </div>
                    </div> -->
                    <a href="{{ route("userpage.practice.test")}}" class="nav-item nav-link">Thi thử lý thuyết</a>
                    <div class="nav-item dropdown">
                        <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Ôn tập lý thuyết</a>
                        <div class="dropdown-menu bg-light rounded-0 rounded-bottom m-0">

                            <a href="{{ route("userpage.chapters", ["ID" => $chapter->CategoryID]) }}"
                                class="dropdown-item">Ôn tập nhanh với 600 câu</a>

                            <a href="{{ route("userpage.collectionA", ["ID" => $chapter->CategoryID]) }}"
                                class="dropdown-item">Ôn tập nhanh 250 câu lý
                                thuyết - A1,A</a>
                            <a href="{{ route("userpage.collectionBone", ["ID" => $chapter->CategoryID]) }}"
                                class="dropdown-item">Ôn tập nhanh 300 câu lý
                                thuyết - B1</a>

                        </div>
                    </div>

                    <div class="nav-item dropdown">
                        <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Học biển báo</a>
                        <div class="dropdown-menu bg-light rounded-0 rounded-bottom m-0">
                            @foreach($SignageType as $signage)
                                <a href="{{ route("userpage.signages", parameters: $signage->SignageTypeID) }}"
                                    class="dropdown-item">{{ $signage->SignagesTypeName }}</a>
                            @endforeach
                        </div>
                    </div>
                    <!-- <a href="service.html" class="nav-item nav-link">chatbot</a> -->
                </div>

                @if(Auth::check())
                    <div class="ms-auto">
                        <a href="#" class=" account nav-link dropdown-toggle btn btn-primary rounded-pill py-2 px-3"
                            id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow animated fadeIn"
                            aria-labelledby="accountDropdown">
                            <li><a class="dropdown-item" href="account-info.html">Thông tin tài khoản</a></li>
                            <li><a class="dropdown-item" href="change-password.html">Đổi mật khẩu</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route("logout.post") }}" method="post">
                                    @csrf
                                    <button class="dropdown-item text-danger" href="{{ route("logout.post") }}">Đăng
                                        xuất</button>
                            </li>
                            </form>
                        </ul>
                    </div>
                @else
                    <div class="ms-auto">
                        <a href="{{ route("login") }}" class=" account btn btn-primary rounded-pill py-2 px-3"
                            id="accountDropdown">
                            Đăng nhập
                        </a>
                    </div>
                @endif

            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->
@yield("main")



<!-- Footer Start -->
<div class="container-fluid bg-dark footer mt-5 py-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <div class="d-flex pt-3">
                    <a class="btn btn-square btn-light rounded-circle me-2" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-square btn-light rounded-circle me-2" href=""><i
                            class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-square btn-light rounded-circle me-2" href=""><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-square btn-light rounded-circle me-2" href=""><i
                            class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-4">Liên kết nhanh</h4>
                <a class="btn btn-link" href="{{ route("userpage.home") }}">Trang chủ</a>
                <a class="btn btn-link" href="">Ôn tập</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-4">Người dùng</h4>
                <a class="btn btn-link" href="{{ route("register") }}">Đăng ký</a>
                <a class="btn btn-link" href="{{ route("login") }}">Đăng nhập</a>
            </div>
            <!-- <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-4">Liên hệ</h4>
                <a class="btn btn-link" href="">Đăng ký</a>
                <a class="btn btn-link" href="">Đăng nhập</a>
            </div> -->
        </div>
    </div>
</div>
<!-- Footer End -->
<!-- Back to Top -->
<div class="d-flex">
    <!-- <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
            class="bi bi-arrow-up"></i></a> -->
    <!-- <div class="chat-bot">
        <section class="chat-window">
            <button class="close">x close</button>
            <div class="chat">

                <div class="model">
                    <p>xin chào, tôi có thể giúp gì cho bạn?</p>

                </div>

            </div>
            <div class="input-area">
                <input placeholder="hỏi bất cứ điều gì....." type="text">
                <button>
                    <img src="/assets/chatbot/icon/send-icon.png" alt="">
                </button>
            </div>
        </section>
        <div class="chat-button">
            <img src="/assets/chatbot/icon/chat-icon.png" alt="">
        </div>
    </div> -->

    <div class="chatbot">
        <!-- Chatbot Toggler -->
        <button id="chatbot-toggler">
            <span class="material-symbols-rounded">mode_comment</span>
            <span class="material-symbols-rounded">close</span>
        </button>
        <div class="chatbot-popup">
            <!-- Chatbot Header -->
            <div class="chat-header">
                <div class="header-info">
                    <svg class="chatbot-logo" xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                        viewBox="0 0 1024 1024">
                        <path
                            d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z" />
                    </svg>
                    <h2 class="logo-text">TrafficBot</h2>
                </div>
                <button id="close-chatbot" class="material-symbols-rounded">keyboard_arrow_down</button>
            </div>
            <!-- Chatbot Body -->
            <div class="chat-body">
                <div class="message bot-message">
                    <svg class="bot-avatar" xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                        viewBox="0 0 1024 1024">
                        <path
                            d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z" />
                    </svg>
                    <!-- prettier-ignore -->
                    <div class="message-text">Chào bạn <br /> Mình có thể giúp gì cho bạn ?
                    </div>
                </div>
            </div>
            <!-- Chatbot Footer -->
            <div class="chat-footer">
                <form action="#" class="chat-form">
                    <textarea placeholder="Tin nhắn..." class="message-input" required></textarea>
                    <div class="chat-controls">
                        <button type="button" id="emoji-picker"
                            class="material-symbols-outlined">sentiment_satisfied</button>
                        <!-- <div class="file-upload-wrapper">
              <input type="file" accept="image/*" id="file-input" hidden />
              <img src="#" />
              <button type="button" id="file-upload" class="material-symbols-rounded">attach_file</button>
              <button type="button" id="file-cancel" class="material-symbols-rounded">close</button>
            </div> -->
                        <button type="submit" id="send-message" class="material-symbols-rounded">arrow_upward</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Linking Emoji Mart script for emoji picker -->
        <script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>
        <!-- Linking custom script -->
        <script type="importmap">
    {
      "imports": {
        "@google/genai": "https://esm.run/@google/genai"
      }
    }
  </script>

    </div>
</div>

<!-- <script type="importmap">
    {
      "imports": {
        "@google/genai": "https://esm.run/@google/genai"
      }
    }
  </script> -->

<script>
    @if(!empty($signagesData))
        window.signagesData = @json($signagesData);
    @else
        window.signagesData =[];

    @endif
    @if(!empty($pdfs))
        window.pdfs = {!! json_encode($pdfs) !!} || null;

    @else
        window.pdfs =[];

    @endif


</script>

<script type="module" src="/assets/chatbot/chatbot.js">
</script>


<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/userPage/lib/wow/wow.min.js"></script>
<script src="/assets/userPage/lib/easing/easing.min.js"></script>
<script src="/assets/userPage/lib/waypoints/waypoints.min.js"></script>
<script src="/assets/userPage/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="/assets/userPage/lib/lightbox/js/lightbox.min.js"></script>

<!-- Template Javascript -->
<script src="/assets/userPage/js/main.js"></script>
<script src="/assets/chatbot/chatbot.js"></script>


</body>

</html>