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
    .custom-sidebar .list-group-item {
        padding: 12px 20px;
        font-weight: 500;
        color: #495057;
        border: none;
        border-left: 3px solid transparent;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
    }

    .custom-sidebar .list-group-item:hover {
        background-color: #e9ecef;
        border-left: 3px solid #007bff;
        color: #007bff;
    }

    .custom-sidebar .list-group-item.active {
        background-color: #007bff;
        color: #fff;
        border-left: 3px solid #0056b3;
        font-weight: bold;
    }

    .custom-sidebar {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .avatar-profile-box {
        display: flex;
        align-items: center;
        padding: 1rem;
        background-color: #ffffff;
        border-radius: 10px;
        /* border: 1px solid #e0e0e0; */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        gap: 1.5rem;
    }

    .avatar-preview {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #dee2e6;
        transition: border-color 0.3s ease;
    }

    .avatar-preview:hover {
        border-color: #007bff;
    }

    .avatar-profile-box .media-body h5 {
        margin-bottom: 4px;
        font-weight: 600;
    }

    .avatar-profile-box .media-body p {
        margin-bottom: 8px;
        font-size: 0.9rem;
        color: #6c757d;
    }

    .account-settings-fileinput {
        display: none;
    }

    .btn-outline-primary.btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.85rem;
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
    <script src="/assets/userPage/js/dashboard-profile.js"></script>
    <script type="text/javascript">

    </script>
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