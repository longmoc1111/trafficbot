@extends("userPage.layout.layout")
@section("title", "thi thử bằng ")

@section("main")

    <style>
        .about {
            background: linear-gradient(rgba(0, 0, 0, .1), rgba(0, 0, 0, .1)), url(" {{ asset('assets/userPage/background/background.png') }} ") left center no-repeat;
            background-size: cover;
        }

        .license-btn {
            display: inline-block;
            padding: 8px 11px;
            margin-right: 2px;
            font-size: 11px;
            font-weight: 400;
            color: #fff;
            background: linear-gradient(135deg, #007bff, #6610f2);
            border: none;
            border-radius: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .license-btn:hover {
            background: linear-gradient(135deg, #6610f2, #007bff);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .type-btn {
            border-bottom: 1px solid black;
        }

        .small-text-table td,
        .small-text-table th {
            font-size: 13px;
            /* hoặc 12px tùy bạn */
            padding: 6px 10px;
        }

        /* Làm mờ nền phía sau modal */
        .modal-backdrop.show {
            opacity: 0.6;
            backdrop-filter: blur(2px);
        }

        /* Khung modal chính */
        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            background: #ffffff;
            transition: all 0.3s ease-in-out;
            padding: 0.5rem 0.5rem;
        }

        /* Tiêu đề */
        .modal-header {
            border-bottom: none;
            padding-bottom: 0;
        }

        .modal-title {
            font-size: 22px;
            font-weight: 700;
            color: #0d6efd;
        }

        /* Phần body */
        .modal-body {
            padding-top: 0.5rem;
            font-size: 15px;
        }

        /* Select form */
        .modal-body select.form-select {
            border-radius: 8px;
            font-size: 15px;
            padding: 10px 12px;
        }

        /* Footer (nút) */
        .modal-footer {
            border-top: none;
            display: flex;
            justify-content: space-between;
            padding-top: 0;
        }

        .modal-footer .btn {
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
        }

        /* Nút đóng */
        .btn-close {
            filter: brightness(0) invert(1);
            background-color: #dc3545;
            border-radius: 50%;
            width: 24px;
            height: 24px;
        }

        .score-info-box li,
        .score-info-box p {
            font-size: 13px;
        }

        .table-header th {
            font-size: 13px;
        }

        .table-body td {
            font-size: 13px;
        }
    </style>



    <!-- About Start -->
    <div class="container-xxl about my-5">
        <div class="container">
            <div class="row g-0">
                <div class="col-lg-6">
                    <div class="h-100 d-flex align-items-center justify-content-center" style="min-height: 300px;">
                        <button type="button" class="btn-modal" data-bs-toggle="modal" data-bs-target="#videoModal">
                            <span>Bắt đầu</span>
                        </button>
                    </div>
                </div>

                <div class="col-lg-6 pt-lg-5 wow fadeIn" data-wow-delay="0.5s">
                    <div class="bg-white rounded-top p-4 mt-3">
                        <div class="type-btn mb-2  ">
                            @foreach($licenses as $index => $license)
                                <button class="license-btn mb-2" data-id="{{ $license->LicenseTypeID }}" @if($index == 0)
                                data-first="true" @endif>Hạng {{ $license->LicenseTypeName }}</button>
                            @endforeach
                        </div>

                        <h6 id="license-name" class="mb-1 fw-bold text-primary"></h6>
                        <div class="row g-5 pt-2 mb-2">
                            <div class="table-responsive">
                                <table class=" table-header table table-bordered table-sm align-middle text-center">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col">Chương</th>
                                            <th scope="col" style="width: 80%;">Nội dung</th>
                                            <th scope="col" style="width: 20%;">Số lượng </th>
                                        </tr>
                                    </thead>
                                    <tbody id="categoryTable" class="table-body">
                                        <tr>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="score-info-box p-4 rounded shadow-sm bg-light mb-4">
                            <h6 class="fw-bold text-primary">📌 Cách tính điểm:</h6>
                            <ul class="mb-0 ps-3 small">
                                <li class="mb-2 ">⏱️ Thời gian làm bài: <strong id="duration"></strong> phút</li>
                                <li class="mb-2">✅ Mỗi câu chỉ có duy nhất <strong>1 đáp án đúng</strong></li>
                                <li class="mb-2">🎯 Phải đúng tối thiểu <strong id="passCount"></strong> để đạt</li>
                            </ul>
                            <div class="alert-note p-2 rounded shadow-sm mb-4">
                                <p class="mb-0">
                                    📌 <strong style="color: #dc3545">Lưu ý:</strong> <span class="text-dark">Không được
                                        phép sai câu điểm liệt</span>
                                </p>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Form Modal Start -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Chọn Hạng Bằng Lái</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('userpage.practiceStart')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="licenseType" class="form-label">Chọn hạng bằng lái:</label>
                            <select id="licenseType" class="form-select" name="licenseType" required>
                                <option id="prompt-license" value="" selected disabled>-- Vui lòng chọn --</option>
                                @foreach($licenses as $license)
                                    <option value="{{ $license->LicenseTypeID }}"> Hạng {{ $license->LicenseTypeName }}</option>
                                @endforeach



                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="licenseType" class="form-label">Chọn đề thi:</label>
                            <select class="form-select" id="examset" name="examSetID" required>
                                <option id="prompt-exam" value="" selected disabled>-- Vui lòng chọn --</option>
                            </select>
                        </div>
                        <!-- Bạn có thể thêm các trường khác ở đây -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-bs-dismiss="modal">Đóng</button>

                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Form Modal End -->


    <script>
        document.getElementById('licenseType').addEventListener("change", function () {
            const licenseID = this.value
            const examSetSelect = document.getElementById("examset")
            examSetSelect.innerText = ""
            fetch(`/practice-test/${licenseID}`)
                .then(response => response.json())
                .then(data => {
                    const random = document.createElement("option")
                    if (Array.isArray(data) && data.length > 0) {
                        data.forEach(function (examset) {
                            const option = document.createElement("option")
                            option.value = examset.ExamSetID
                            option.text = examset.ExamSetName
                            examSetSelect.appendChild(option)
                        })
                    }
                    random.value = "random"
                    random.text = "Đề ngẫu nhiên"
                    examSetSelect.appendChild(random)
                })
                .catch(error => {
                    examSetSelect.innerHTML = '<option disabled>Lỗi khi tải đề thi</option>';
                });
        })

        // document.addEventListener("DOMContentLoaded", funciton() {
        //     const firstBtn = document.querySelector("license-btn[data-first='true']")
        //     if(firstBtn){
        //         firstBtn.click()
        //     }
        // })    
        document.addEventListener("DOMContentLoaded", function () {

            const licenseBtn = document.querySelectorAll(".license-btn")
            licenseBtn.forEach(button => {
                button.addEventListener("click", function () {
                    const licenseID = this.dataset.id
                    const tbody = document.getElementById("categoryTable")
                    const duration = document.getElementById("duration")
                    const passcount = document.getElementById("passCount")
                    const licenseName = document.getElementById("license-name")
                    fetch(`/practice-info/${licenseID}"`)
                        .then(response => response.json())
                        .then(data => {
                            licenseName.innerText = `Cấu trúc đề thi Hạng ${data.dataLicense.name}`
                            if (data.dataCategory == 0) {
                                tbody.innerHTML = `<tr><td colspan = "3">Không có dữ liệu</td></tr>`
                            }
                            tbody.innerHTML = ``
                            data.dataCategory.forEach(function (item, index) {
                                tbody.innerHTML += `
                                                        <tr>
                                                            <td>${index + 1}</td>
                                                            <td>${item.name}</td>
                                                            <td>${item.quantity}</td>
                                                        </tr>
                                                    `
                            })
                            duration.innerText = data.dataLicense.duration
                            passcount.innerText = `${data.dataLicense.passcount}/${data.dataLicense.quantity} Câu`
                        })
                })
            })
            const firstBtn = document.querySelector(".license-btn")
            if (firstBtn) {
                firstBtn.click()
            }
        })

    </script>


    <!-- script cho mở rọng thu gọn -->
    <script>
        document.getElementById("toggle-btn").addEventListener("click", function () {
            var fullText = document.getElementById("full-text");
            var shortText = document.getElementById("short-text");
            var btn = this;

            if (fullText.style.display === "none") {
                fullText.style.display = "inline";
                shortText.style.display = "none";
                btn.innerText = "Thu gọn";
            } else {
                fullText.style.display = "none";
                shortText.style.display = "inline";
                btn.innerText = "Xem thêm";
            }
        });
    </script>
    <!-- end script -->

@endsection