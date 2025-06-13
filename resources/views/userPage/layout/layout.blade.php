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

        /* Đăng xuất nổi bật */
        .dropdown-item.text-danger:hover {
            background-color: #ffe5e5;
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
            <a href="index.html">
                <h2 class="text-white fw-bold m-0">Trafficbot</h2>
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
<div class="container-fluid bg-white sticky-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-white navbar-light p-lg-0">
            <a href="index.html" class="navbar-brand d-lg-none">
                <h1 class="fw-bold m-0">TrafficBot</h1>
            </a>
            <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav">
                    <a href="{{ route("userpage.home") }}"
                        class="nav-item nav-link ">Trang
                        chủ</a>
                    <div class="nav-item dropdown">
                   
                        <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Thi lý thuyết xe máy</a>
                        <div class="dropdown-menu bg-light rounded-0 rounded-bottom m-0 ">
                            @isset($licenses)
                                @foreach ($licenses as $license)
                                    @if($license->LicenseTypeName == "Bằng A1" || $license->LicenseTypeName == "Bằng A2")
                                        <a href="{{ route("userpage.practiceExam", $license->LicenseTypeID) }}"
                                            class="dropdown-item">{{ $license->LicenseTypeName }}</a>
                                    @endif
                                @endforeach
                            @endisset

                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Thi sát hạch ô tô</a>
                        <div class="dropdown-menu bg-light rounded-0 rounded-bottom m-0">
                            @foreach ($licenses as $license)
                                @if($license->LicenseTypeName == "Bằng B1" || $license->LicenseTypeName == "Bằng B2")
                                    <a href="{{ route("userpage.practiceExam", ["LicenseTypeID" => $license->LicenseTypeID]) }}"
                                        class="dropdown-item">{{ $license->LicenseTypeName }}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="nav-item dropdown">
                        <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Ôn tập lý thuyết</a>
                        <div class="dropdown-menu bg-light rounded-0 rounded-bottom m-0">
                            @foreach ($chapters as $chapter)
                                <a href="{{ route("userpage.chapters", ["ID" => $chapter->CategoryID]) }}"
                                    class="dropdown-item">{{ $chapter->CategoryName }}</a>
                            @endforeach
                            <a href="{{ route("userpage.collection") }}" class="dropdown-item">Ôn tập nhanh với 600 câu
                                hỏi tổng hợp</a>

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
                <h4 class="text-white mb-4">Quick Links</h4>
                <a class="btn btn-link" href="">About Us</a>
                <a class="btn btn-link" href="">Contact Us</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-4">Quick Links</h4>
                <a class="btn btn-link" href="">About Us</a>
                <a class="btn btn-link" href="">Contact Us</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-4">Newsletter</h4>
                <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                <div class="position-relative w-100">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->
<!-- Back to Top -->
<div class="d-flex">
    <!-- <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
            class="bi bi-arrow-up"></i></a> -->
    <div class="chat-bot">
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
    </div>

</div>

<script type="importmap">
    {
      "imports": {
        "@google/genai": "https://esm.run/@google/genai"
      }
    }
  </script>
<script type="module" src="/assets/chatbot/chatbot.js"></script>


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