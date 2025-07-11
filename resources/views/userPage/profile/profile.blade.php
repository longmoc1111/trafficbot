<!--Website: wwww.codingdung.com-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <link rel="stylesheet" href="assets/userPage/css/profile.css">
    <link rel="stylesheet" href="/assets/bootstrap/bootstrap-5.3.0/css/bootstrap.min.css">
    <link href="/assets/izitoast/css/iziToast.min.css" rel="stylesheet" type="text/css">

</head>
<style>
   /* Sidebar */
.custom-sidebar .list-group-item {
    padding: 14px 22px;
    font-weight: 500;
    color: #444;
    border: none;
    border-left: 4px solid transparent;
    background-color: #fff;
    transition: all 0.3s ease;
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

/* Avatar Section */
.avatar-profile-box {
    display: flex;
    align-items: center;
    padding: 1.25rem;
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
    gap: 1.5rem;
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
    font-weight: 700;
    font-size: 1.25rem;
    color: #333;
}

.avatar-profile-box .media-body p {
    margin-bottom: 0;
    font-size: 0.95rem;
    color: #6c757d;
}

/* Card Title */
.card-body h5 {
    font-weight: 600;
    color: #333;
}

/* Table Styling */
.table th,
.table td {
    vertical-align: middle;
    font-size: 0.95rem;
}

.table th {
    background-color: #f8f9fa;
    color: #333;
    font-weight: 600;
}

/* Badge Status */
.badge.bg-success {
    background-color: #28a745 !important;
}

.badge.bg-warning {
    background-color: #ffc107 !important;
    color: #212529 !important;
}

/* Form */
.form-label {
    font-weight: 500;
    color: #495057;
}

.form-control {
    border-radius: 6px;
}

/* Update Button */
.btn.btn-primary {
    padding: 0.5rem 1.25rem;
    font-size: 0.95rem;
    font-weight: 500;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.btn.btn-primary:hover {
    background-color: #084298;
}

/* Chart Card */
.card.h-100 {
    border-radius: 12px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
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
    <div class="p-4 light-style flex-grow-1 container-p-y ">
        <h4 class="font-weight-bold py-3 mb-4">
            Thông tin cá nhân
        </h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light" style="min-height: 600px;">
                <div class="col-md-2 pt-0">
                    <div class="list-group list-group-flush account-settings-links custom-sidebar"
                        style="height: 100%;">
                        <a class="list-group-item list-group-item-action {{ $activeTab === 'account-general' ? 'active' : '' }}"
                            data-toggle="list" href="#account-general">
                            Tổng quan
                        </a>
                        <a class="list-group-item list-group-item-action {{ $activeTab === 'account-change-password' ? 'active' : '' }}"
                            data-toggle="list" href="#account-change-password">
                            Thay đổi mật khẩu
                        </a>
                        <a class="list-group-item list-group-item-action" href="{{ route("userpage.home") }}">
                            Quay lại trang chủ
                        </a>
                    </div>
                </div>



                <div class="col-md-10">
                    <div class="tab-content">
                        <div class="tab-pane fade {{ $activeTab === "account-general" ? "active show" : '' }}"
                            id="account-general">
                            <div class="card-body media align-items-center avatar-profile-box">
                                @if(!empty($information->avatar))
                                    <img src="{{ asset("storage/uploads/avatar/$information->avatar") }}" alt="Avatar"
                                        class="avatar-preview">
                                @else
                                    <img src="{{ asset("storage/uploads/avatar/avatar_default.jpg") }}" alt="Avatar"
                                        class="avatar-preview">
                                @endif

                                <div class="media-body ml-4">
                                    <h5 class="mb-1">{{ $information->name }}</h5>
                                    <p class="text-muted mb-2">{{ $information->email }}</p>
                                    <!-- <label class="btn btn-outline-primary btn-sm">
                                        thay đổi thông tin
                                        <input type="file" class="account-settings-fileinput" hidden>
                                    </label> -->
                                </div>
                            </div>
                            <div class="row">
                                <!-- Cột bên trái: Biểu đồ Gender -->
                                <div class="col-12 col-xl-5 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div id="gender-chart" class="apex-charts" data-colors="#6ac75a,#fa5c7c">
                                            </div>

                                            <div class="row mt-3 d-flex justify-content-center">
                                                <div class="col-sm-4 text-center">
                                                    <p class="text-muted mb-1">Đạt</p>
                                                    <h4 class="mb-2">
                                                        <span class="ti ti-man text-primary"></span>{{ $passed }}
                                                    </h4>

                                                </div>
                                                <div class="col-sm-4 text-center">
                                                    <p class="text-muted mb-1">Không đạt</p>
                                                    <h4 class="mb-2">
                                                        <span class="ti ti-woman text-success"></span>{{ $failed }}
                                                    </h4>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cột bên phải: Bảng kết quả thi -->
                                <div class="col-12 col-xl-7 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="mb-3 font-weight-bold">Kết quả thi</h5>
                                            <table class="table table-bordered table-striped table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>giấy phép</th>
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
                                                                <td>Hạng
                                                                    {{ optional($result->licenseType_Result)->LicenseTypeName ?? "" }}
                                                                </td>
                                                                <td>{{ $result->created_at->format('d/m/Y') }}</td>
                                                                <td>{{ $result->score }}/{{ optional($result->licenseType_Result)->LicenseTypeQuantity ?? "" }}
                                                                </td>
                                                                @if($result->passed == true | $result->passed == 1)
                                                                    <td><span class="badge bg-success">Đạt</span></td>

                                                                @else
                                                                    <td><span class="badge bg-warning text-dark">Không đạt</span>
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
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
                            <form action="{{ route("password.change", ["ID" => $information->userID]) }}" method="POST">
                                @csrf
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Mật khẩu hiện tại</label>
                                        <input name="currentPassword" type="password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Mật khẩu mới</label>
                                        <input name="newPassword" type="password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Xác nhận mật khẩu mới</label>
                                        <input name="newPasswordConfirm" type="password" class="form-control">
                                    </div>
                                </div>
                                <div class="text-right mb-3" style="margin-left: 15px;">
                                    <button type="submit" class="btn btn-primary">cập nhật</button>
                                </div>
                            </form>

                        </div>
                        <div class="tab-pane fade" id="account-connections">
                            <div class="card-body">
                                <button type="button" class="btn btn-twitter">Connect to
                                    <strong>Twitter</strong></button>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <h5 class="mb-2">
                                    <a href="javascript:void(0)" class="float-right text-muted text-tiny"><i
                                            class="ion ion-md-close"></i> Remove</a>
                                    <i class="ion ion-logo-google text-google"></i>
                                    You are connected to Google:
                                </h5>
                                <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                    data-cfemail="f9979498818e9c9595b994989095d79a9694">[email&#160;protected]</a>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <button type="button" class="btn btn-facebook">Connect to
                                    <strong>Facebook</strong></button>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <button type="button" class="btn btn-instagram">Connect to
                                    <strong>Instagram</strong></button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-notifications">
                            <div class="card-body pb-2">
                                <h6 class="mb-4">Activity</h6>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Email me when someone comments on my article</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Email me when someone answers on my forum
                                            thread</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input">
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Email me when someone follows me</span>
                                    </label>
                                </div>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body pb-2">
                                <h6 class="mb-4">Application</h6>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">News and announcements</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input">
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Weekly product updates</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Weekly blog digest</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

  

    <script>
        passed = @json($passed);
        failed = @json($failed)
    </script>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/izitoast/js/iziToast.min.js"></script>
    <!-- Charts js -->
    <script src="/assets/userPage/lib/apexcharts/apexcharts.min.js"></script>
    <script type="text/javascript"></script>
    <script src="/assets/userPage/js/dashboard-profile.js"></script>

</body>
<script>
    @if(session("change_succes"))
        iziToast.success({
            message: "{{ session("change_succes") }}",
            position: "topRight"
        })
    @endif

    @if(session("change_fails"))
        iziToast.warning({
            message: "{{ session("change_fails") }}",
            position: "topRight"
        })
    @endif
</script>

</html>