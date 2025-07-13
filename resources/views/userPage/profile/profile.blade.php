<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Thông tin cá nhân - TrafficBot</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/logo/icon.png') }}" type="image/png">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/bootstrap/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />

    <!-- Libraries Stylesheet -->
    <link href="/assets/userPage/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="/assets/userPage/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="/assets/chatbot/chatbot.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link rel="stylesheet" href="/assets/bootstrap/bootstrap-5.3.0/css/bootstrap.min.css">

    <!-- Template Stylesheet -->
    <link href="/assets/userPage/css/style.css" rel="stylesheet">
    <link href="/assets/izitoast/css/iziToast.min.css" rel="stylesheet" type="text/css">
</head>
<body lang="en">
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
                
            </nav>
        </div>
    </div>
    <!-- Navbar End -->

<style>
    /* Navbar Styles */
    .container-navbar {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

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

    .dropdown-menu {
        min-width: 220px;
        border-radius: 0.5rem;
        padding: 0.5rem 0;
    }

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

    /* Profile Page Styles - Simple & Clean */
    .profile-container {
        background-color: #f8f9fa;
        min-height: 100vh;
        padding: 2rem 0;
    }

    .profile-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .profile-subtitle {
        font-size: 1rem;
        color: #6c757d;
        margin-bottom: 2rem;
    }

   /* Sidebar - Clean Style */
.custom-sidebar .list-group-item {
    padding: 14px 22px;
    font-weight: 500;
    color: #495057;
    border: none;
    border-left: 4px solid transparent;
    background-color: #fff;
    transition: all 0.3s ease;
    margin-bottom: 4px;
}

.custom-sidebar .list-group-item:hover {
    background-color: #f1f5f9;
    border-left: 4px solid #0d6efd;
    color: #0d6efd;
}

.custom-sidebar .list-group-item.active {
    background-color: #0d6efd;
    color: #fff;
    border-left: 4px solid #084298;
    font-weight: 600;
}

/* Simple Avatar Section */
.avatar-profile-box {
    display: flex;
    align-items: center;
    padding: 1.5rem;
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    gap: 1.5rem;
    border: 1px solid #e9ecef;
    margin-bottom: 1.5rem;
}

.avatar-preview {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #dee2e6;
    transition: border-color 0.3s ease;
}

.avatar-preview:hover {
    border-color: #0d6efd;
}

.avatar-profile-box .media-body h5 {
    margin-bottom: 6px;
    font-weight: 600;
    font-size: 1.25rem;
    color: #2c3e50;
}

.avatar-profile-box .media-body p {
    margin-bottom: 0;
    font-size: 0.95rem;
    color: #6c757d;
}

/* Clean Card Styling */
.card-body h5 {
    font-weight: 600;
    color: #2c3e50;
    font-size: 1.1rem;
    margin-bottom: 1rem;
}

/* Clean Table Styling */
.table {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.table th,
.table td {
    vertical-align: middle;
    font-size: 0.9rem;
    padding: 0.75rem;
    border-color: #e9ecef;
}

.table th {
    background-color: #f8f9fa;
    color: #495057;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

/* Simple Badge Status */
.badge.bg-success {
    background-color: #28a745 !important;
    font-weight: 500;
}

.badge.bg-warning {
    background-color: #ffc107 !important;
    color: #212529 !important;
    font-weight: 500;
}

.badge.bg-info {
    background-color: #17a2b8 !important;
    font-weight: 500;
}

.badge.bg-primary {
    background-color: #007bff !important;
    font-weight: 500;
}

/* Clean Form Styling */
.form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.5rem;
}

.form-control {
    border: 1px solid #ced4da;
    border-radius: 6px;
    padding: 0.6rem 0.75rem;
    font-size: 0.9rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Simple Button Styling */
.btn.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    padding: 0.6rem 1.2rem;
    font-size: 0.9rem;
    font-weight: 500;
    border-radius: 6px;
}

.btn.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

/* Clean Chart Card */
.card.h-100 {
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
}

/* Main Container */
.profile-main-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
    overflow: hidden;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .avatar-profile-box {
        flex-direction: column;
        text-align: center;
    }

    .avatar-preview {
        width: 80px;
        height: 80px;
    }

    .custom-sidebar {
        margin-bottom: 20px;
    }
    #gender-chart {
    width: 100% !important;
    height: auto !important;
    max-width: 100%;
}
}

</style>

<body>
    @php
        $activeTab = session('active_tab', 'account-general'); 
    @endphp
    
    <!-- Profile Container -->
    <div class="profile-container">
        <div class="container">
            <h4 class="profile-title">
                <i class="fas fa-user-circle me-2"></i>
                Thông tin cá nhân
            </h4>
            <p class="profile-subtitle">Quản lý thông tin và theo dõi kết quả học tập của bạn</p>
            
            <div class="profile-main-card">
                <div class="row g-0" style="min-height: 600px;">
                    <div class="col-lg-3 col-md-4 pt-0">
                        <div class="list-group list-group-flush account-settings-links custom-sidebar h-100">
                            <a class="list-group-item list-group-item-action {{ $activeTab === 'account-general' ? 'active' : '' }}"
                                data-toggle="list" href="#account-general">
                                <i class="fas fa-chart-pie me-2"></i>
                                Tổng quan
                            </a>
                            <a class="list-group-item list-group-item-action {{ $activeTab === 'account-change-password' ? 'active' : '' }}"
                                data-toggle="list" href="#account-change-password">
                                <i class="fas fa-lock me-2"></i>
                                Thay đổi mật khẩu
                            </a>
                            <a class="list-group-item list-group-item-action" href="{{ route("userpage.home") }}">
                                <i class="fas fa-home me-2"></i>
                                Quay lại trang chủ
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-9 col-md-8">
                        <div class="tab-content p-4">
                            <div class="tab-pane fade {{ $activeTab === "account-general" ? "active show" : '' }}"
                                id="account-general">
                                
                                <!-- Avatar Section -->
                                <div class="avatar-profile-box">
                                    @if(!empty($information->avatar))
                                        <img src="{{ asset("storage/uploads/avatar/$information->avatar") }}" alt="Avatar"
                                            class="avatar-preview">
                                    @else
                                        <img src="/assets/avatar_default/avatar_default.png" alt="Avatar"
                                            class="avatar-preview">
                                    @endif

                                    <div class="media-body">
                                        <h5 class="mb-1">{{ $information->name }}</h5>
                                        <p class="mb-2">{{ $information->email }}</p>
                                        <div class="mt-2">
                                            <span class="badge bg-primary me-2">
                                                <i class="fas fa-star me-1"></i>
                                                Thành viên
                                            </span>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>
                                                Đã xác thực
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Chart Section -->
                                    <div class="col-12 col-xl-5 mb-4">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <i class="fas fa-chart-donut me-2"></i>
                                                    Thống kê kết quả
                                                </h5>
                                                <div id="gender-chart" class="apex-charts" data-colors="#28a745,#ffc107">
                                                </div>

                                                <div class="row mt-3 text-center">
                                                    <div class="col-6">
                                                        <div class="p-3 bg-light rounded">
                                                            <i class="fas fa-trophy text-success fs-4 mb-2"></i>
                                                            <p class="text-muted mb-1 fw-semibold">Đạt</p>
                                                            <h4 class="mb-0 text-success">{{ $passed }}</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="p-3 bg-light rounded">
                                                            <i class="fas fa-times-circle text-warning fs-4 mb-2"></i>
                                                            <p class="text-muted mb-1 fw-semibold">Không đạt</p>
                                                            <h4 class="mb-0 text-warning">{{ $failed }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Results Table -->
                                    <div class="col-12 col-xl-7 mb-4">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title mb-3">
                                                    <i class="fas fa-list-alt me-2"></i>
                                                    Kết quả thi
                                                </h5>
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Giấy phép</th>
                                                                <th>Ngày thi</th>
                                                                <th>Điểm</th>
                                                                <th>Trạng thái</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(!empty($resultExam))
                                                                @php
                                                                    $index = 1;
                                                                @endphp
                                                                @foreach ($resultExam as $result)
                                                                    <tr>
                                                                        <td>{{ $index++ }}</td>
                                                                        <td>
                                                                            <span class="badge bg-info">
                                                                                Hạng {{ optional($result->licenseType_Result)->LicenseTypeName ?? "" }}
                                                                            </span>
                                                                        </td>
                                                                        <td>{{ $result->created_at->format('d/m/Y') }}</td>
                                                                        <td>
                                                                            <strong>{{ $result->score }}</strong>/{{ optional($result->licenseType_Result)->LicenseTypeQuantity ?? "" }}
                                                                        </td>
                                                                        @if($result->passed == true | $result->passed == 1)
                                                                            <td><span class="badge bg-success">Đạt</span></td>
                                                                        @else
                                                                            <td><span class="badge bg-warning">Không đạt</span></td>
                                                                        @endif
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan="5" class="text-center py-4">
                                                                        <i class="fas fa-inbox fs-1 text-muted mb-3"></i>
                                                                        <p class="text-muted">Chưa có kết quả thi nào</p>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade {{ $activeTab === "account-change-password" ? "active show" : '' }}"
                                id="account-change-password">
                                
                                @if($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger">{{ $error }}</div>
                                    @endforeach
                                @endif
                                
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-4">
                                            <div class="bg-primary rounded-circle p-3 me-3">
                                                <i class="fas fa-shield-alt text-white"></i>
                                            </div>
                                            <div>
                                                <h5 class="mb-1">Bảo mật tài khoản</h5>
                                                <p class="text-muted mb-0">Thay đổi mật khẩu để bảo vệ tài khoản của bạn</p>
                                            </div>
                                        </div>

                                        <form action="{{ route("password.change", ["ID" => $information->userID]) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label">Mật khẩu hiện tại</label>
                                                <input name="currentPassword" type="password" class="form-control" 
                                                       placeholder="Nhập mật khẩu hiện tại" required>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Mật khẩu mới</label>
                                                    <input name="newPassword" type="password" class="form-control" 
                                                           placeholder="Nhập mật khẩu mới" required>
                                                    <small class="text-muted">Mật khẩu tối thiểu 8 ký tự</small>
                                                </div>
                                                
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Xác nhận mật khẩu mới</label>
                                                    <input name="newPasswordConfirm" type="password" class="form-control" 
                                                           placeholder="Xác nhận mật khẩu mới" required>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex justify-content-end mt-4">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save me-2"></i>
                                                    Cập nhật mật khẩu
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark footer mt-5 py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex pt-3">
                        <a class="btn btn-square btn-light rounded-circle me-2" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-light rounded-circle me-2" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-light rounded-circle me-2" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-light rounded-circle me-2" href=""><i class="fab fa-linkedin-in"></i></a>
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
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top & Chatbot -->
    <div class="d-flex">
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
                        <svg class="chatbot-logo" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 1024 1024">
                            <path d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z" />
                        </svg>
                        <h2 class="logo-text">TrafficBot</h2>
                    </div>
                    <button id="close-chatbot" class="material-symbols-rounded">keyboard_arrow_down</button>
                </div>
                <!-- Chatbot Body -->
                <div class="chat-body">
                    <div class="message bot-message">
                        <svg class="bot-avatar" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 1024 1024">
                            <path d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z" />
                        </svg>
                        <!-- prettier-ignore -->
                        <div class="message-text">Chào bạn <br /> Mình có thể giúp gì cho bạn ?</div>
                    </div>
                </div>
                <!-- Chatbot Footer -->
                <div class="chat-footer">
                    <form action="#" class="chat-form">
                        <textarea placeholder="Tin nhắn..." class="message-input" name="message" required></textarea>
                        <div class="chat-controls">
                            <button type="button" id="emoji-picker" class="material-symbols-outlined">sentiment_satisfied</button>
                            <button type="submit" id="send-message" class="material-symbols-rounded">arrow_upward</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
    <script src="/assets/izitoast/js/iziToast.min.js"></script>
    <!-- Charts js -->
    <script src="/assets/userPage/lib/apexcharts/apexcharts.min.js"></script>
    <script src="/assets/userPage/js/dashboard-profile.js"></script>
    
    <!-- Emoji Mart script for emoji picker -->
    <script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>

</body>

<script>
    // Data for charts
    var passed = @json($passed);
    var failed = @json($failed);
    
    // Tab switching functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabLinks = document.querySelectorAll('[data-toggle="list"]');
        const tabPanes = document.querySelectorAll('.tab-pane');
        
        tabLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all links and panes
                tabLinks.forEach(l => l.classList.remove('active'));
                tabPanes.forEach(p => p.classList.remove('active', 'show'));
                
                // Add active class to clicked link
                this.classList.add('active');
                
                // Show corresponding tab pane
                const target = this.getAttribute('href');
                const targetPane = document.querySelector(target);
                if (targetPane) {
                    targetPane.classList.add('active', 'show');
                }
            });
        });
        
        // Spinner hide
        setTimeout(function() {
            const spinner = document.getElementById('spinner');
            if (spinner) {
                spinner.classList.remove('show');
            }
        }, 1000);
    });
    
    // Success/Error notifications
    @if(session("change_succes"))
        iziToast.success({
            message: "{{ session("change_succes") }}",
            position: "topRight"
        });
    @endif

    @if(session("change_fails"))
        iziToast.warning({
            message: "{{ session("change_fails") }}",
            position: "topRight"
        });
    @endif
</script>

</html>