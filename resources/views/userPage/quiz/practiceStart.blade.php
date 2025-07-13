@extends("userPage.layout.layout")
@section("title", "thi thử bằng $lastWordA")

@section("main")
    <!-- About Start -->
    <style>
        .question-item {
            font-size: 11px;
            /* padding: 7px 7px; */
            width: 35px;
            height: 35px;
            /* line-height: 50%; */
            /* align-items: center; */
            margin: auto;
            border: 1px solid rgb(97, 149, 248);
        }


        .question-btn.active .question-item {
            background-color: rgb(156, 179, 213);
            color: white !important;

        }

        /* modal */

        .fa {
            color: #0d6efd;
            font-size: 90px;
            padding: 30px 0px;
        }

        .b1 {
            background-color: #0d6efd;
            box-shadow: 0px 4px #0d6efd;
            font-size: 17px;
        }

        .r3 {
            color: rgb(20, 17, 17);
            font-weight: 500;
        }

        a,
        a:hover {
            text-decoration: none;
        }

        .selected-question {
            background-color: #DCFCE7;
            color: black !important;
            border-color: #4ade80;
        }

        .correct {
            background-color: #DCFCE7;
            /* xanh lá */
            color: black;
            border-radius: 50%;
        }

        .inCorrect {
            background-color: #fee2e2;
            /* đỏ */
            color: black;
            border-radius: 50%;
        }

        .hidden-question {
            display: none !important;
        }

        #explanation-container {
            border: 2px solid #ccc;
            border-radius: 8px;
            padding: 12px 16px;
            margin-top: 16px;
            background-color: #F6FEF9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size: 13px;
            color: #333;
            line-height: 1.5;
        }

        .answer-item {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 8px;
            background-color: #fafafa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .answer-item p {
            font-size: 13px;
        }



        .correct-answer {
            border: 2px solid #D4EDDA;
            background-color: #DCFCE7;
            border-radius: 5px;
            padding: 5px;
        }

        .wrong-answer {
            border: 2px solid #F8D7DA;
            background-color: #fee2e2 !important;
            border-radius: 5px;
            padding: 5px;
        }

        .answer-correct {
            background-color: #d4edda;
            color: #155724;
            padding: 5px;
            border-radius: 5px;
        }

        .answer-wrong {
            background-color: #f8d7da;
            color: #721c24;
            padding: 5px;
            border-radius: 5px;
        }

        .service-item img {
            display: block;
            margin: 0 auto;
            min-width: 100px;
            min-height: 100px;
            max-width: 100%;
            object-fit: contain;
        }

        .select-answer {
            background-color: #d4edda;
        }

        .scroll-wrapper {
            max-height: 250px;
            overflow-y: auto;
            padding-right: 15px;
        }

        .scroll-wrapper::-webkit-scrollbar {
            width: 6px;
        }

        .scroll-wrapper::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 3px;
        }

        #modalResults .modal-content {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        #modalResults .modal-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            padding: 2rem 1.5rem;
        }

        #modalResults .modal-header i {
            color: #fff;
            opacity: 0.9;
        }

        #modalResults .modal-title {
            color: #fff;
            font-size: 1.5rem;
        }

        #modalResults .card {
            transition: transform 0.2s ease;
            border-radius: 12px;
        }

        #modalResults .card:hover {
            transform: translateY(-2px);
        }

        #modalResults .badge {
            font-size: 1rem;
            padding: 0.5rem 0.75rem;
            border-radius: 20px;
        }

        #modalResults #result-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px solid #dee2e6;
        }

        #modalResults #result-card.success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-color: #28a745;
        }

        #modalResults #result-card.danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border-color: #dc3545;
        }

        #modalResults .btn {
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        #modalResults .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        #endtestModal .modal-content {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        #endtestModal .modal-header {
            background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
            padding: 2rem 1.5rem;
        }

        #endtestModal .modal-header i {
            color: #212529;
            opacity: 0.8;
        }

        #endtestModal .modal-title {
            color: #212529;
            font-size: 1.5rem;
        }

        #endtestModal .alert {
            border-radius: 12px;
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
        }

        #endtestModal .btn {
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        #endtestModal .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        #endtestModal .btn-danger:hover {
            background-color: #c82333;
        }

        #endtestModal .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: #fff;
        }




        /*  */
    </style>


    <!-- About End -->

    <!-- Page Header End -->


    <!-- practice Start -->
    <!-- <div class="text-center mb-4">
                                                                                                                                                                                <button id="start-btn" class="btn btn-success">Bắt đầu làm bài</button>
                                                                                                                                                                            </div> -->

    <div class="container-lg d-none p-4" id="exam-section" style="box-shadow: 0 0 45px rgba(0, 0, 0, .06)">

        <div class="d-flex justify-content-between align-items-center mb-3 px-3" data-wow-delay="0.1s">
            <h3 class="display-7 mb-0 mt-2">Thi lý thuyết xe máy hạng {{ $lastWordA }}</h3>
            <div class="btn display-7 mb-0 mt-3" id="exam-timmer" data-duration="{{ $license->LicenseTypeDuration }}"
                style="background-color:#6Fc7e7">10:00</div>
        </div>
        <hr>
        <div class="row g-4 d-flex align-items-stretch">
            <div class="col-lg-4 col-md-4 h-100 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item position-relative h-100">
                    <div class="service-text rounded p-3">
                        <div class="scroll-wrapper" style="max-height: 300px; overflow-y: auto;">
                            <!-- Chỉ cần 1 container flex-wrap ở ngoài vòng foreach -->
                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                @foreach ($questions as $index => $question)
                                    <div>
                                        <a href="#" style="color:rgb(43, 39, 39); border-color:red" class="question-btn small"
                                            data-question="{{ $index + 1 }}" data-id="{{ $question->QuestionID }}"
                                            data-img="{{ $question->ImageDescription }}"
                                            data-content="{{ $question->QuestionName }}"
                                            data-a-id="{{ $answers['A_ID'] ?? ''  }}" data-b-id="{{ $answers['B_ID'] ?? '' }}"
                                            data-c-id="{{ $answers['C_ID'] ?? ''  }}" data-d-id="{{ $answers['D_ID'] ?? ''  }}"
                                            data-a-name="{{ $answers['A_NAME'] ?? ''  }}"
                                            data-b-name="{{ $answers['B_NAME'] ?? '' }}"
                                            data-c-name="{{ $answers['C_NAME'] ?? ''  }}"
                                            data-d-name="{{ $answers['D_NAME'] ?? ''  }}">

                                            <p class="index-question question-item rounded text-center d-flex align-items-center justify-content-center"
                                                style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                                {{ $index + 1 }}
                                            </p>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                           <button class="btn btn-primary mt-3 w-100" data-bs-toggle="modal" data-bs-target="#endtestModal"
                            id="end-test">Nộp bài</button>
                            <button class="btn btn-primary mt-3 w-100" hidden id="preview">Xem kết quả</button>
                    </div>
                 

                </div>
            </div>
            <div class="col-lg-8 col-md-8 h-100 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item position-relative h-100">
                    <div class="service-text rounded p-3">
                        @foreach($questions as $index => $question)
                            @php
                                $answers = [];
                                foreach ($question->answer_Question as $answer) {
                                    $key = strtoupper($answer->AnswerLabel);
                                    if (in_array($key, haystack: ["A", "B", "C", "D"])) {
                                        $answers[$key . '_ID'] = $answer->AnswerID;
                                        $answers[$key . '_NAME'] = $answer->AnswerName;
                                    }
                                }
                            @endphp
                            <div class="question-block"
                                style="display: none; min-height: 350px; max-height: 600px; overflow-y: auto;  "
                                id="question-block-{{ $question->QuestionID }}" data-question-id="{{ $question->QuestionID }}">
                                <div class="d-flex align-items-center">
                                    <h6 id="question-title" class="me-2 mb-0">Câu {{ $index + 1 }}:
                                        {{ $question->QuestionName }}
                                    </h6>
                                    <!-- <p id="question-content" class="mb-0 mt-1"></p> -->
                                </div>
                                @if($question->ImageDescription)
                                    <div id="div-image" class="mt-2 d-flex align-items-center align-items-start mb-2 answer-item">
                                        <img src="{{ asset("storage/uploads/imageQuestion/$question->ImageDescription") }}"
                                            class="img-fluid d-block mx-auto"
                                            style="max-width: 300px; height: auto; object-fit: contain;" alt="">

                                    </div>
                                @endif
                                <div class="mt-2">
                                    @foreach ($labels as $label)
                                        @if(!empty($answers[$label . "_ID"]))
                                            <div class="d-flex align-items-start mb-2 answer-item answer-label"
                                                data-label="{{ $label }}" data-question-id="{{ $question->QuestionID }}"
                                                data-answer-id="{{ $answers[$label . '_ID'] ?? '' }}"
                                                id="answer-row-{{ $question->QuestionID }}-{{ $label }}">
                                                <p class="mb-0">{{ $label }}: {{ $answers[$label . '_NAME'] ?? '' }}</p>
                                            </div>
                                        @endif
                                    @endforeach
                                    <div id="explanation-container" class="d-none"></div>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-between mt-2">
                            <button class="btn btn-primary" id="prev-btn">← Trước</button>
                            <button class="btn btn-primary" id="next-btn">Sau →</button>
                        </div>


                    </div>

                </div>
            </div>
            <button class="btn btn-primary mt-3 " data-bs-toggle="modal" data-bs-target="#videoModal" id="end-test">Chọn
                đề thi khác</button>
        </div>
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
                                    <!-- <option id="prompt-license" value="" selected disabled>-- Vui lòng chọn --</option> -->
                                    @foreach($licenseTypes as $licenseType)
                                        <option value="{{ $licenseType->LicenseTypeID }}" {{ $licenseType->LicenseTypeID == $license->LicenseTypeID ? "selected" : "" }}> Hạng
                                            {{ $licenseType->LicenseTypeName }}
                                        </option>
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



        <!-- Modal Kết Quả Thi -->
        <div class="modal fade" id="modalResults" tabindex="-1" aria-labelledby="modalResultsLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-primary text-white border-0 position-relative">
                        <div class="w-100 text-center">
                            <i class="fas fa-trophy fs-1 mb-2"></i>
                            <h4 class="modal-title fw-bold mb-0" id="modalResultsLabel">Kết quả thi</h4>
                        </div>
                        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" 
                                data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body py-3">
                                            <div id="modal-correct" class="d-flex align-items-center justify-content-between">
                                                <span class="fw-semibold"><i class="fas fa-check-circle text-success me-2"></i>Câu đúng:</span>
                                                <span class="badge bg-success fs-6" id="correct-count">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body py-3">
                                            <div id="modal-notCorrect" class="d-flex align-items-center justify-content-between">
                                                <span class="fw-semibold"><i class="fas fa-times-circle text-danger me-2"></i>Câu sai:</span>
                                                <span class="badge bg-danger fs-6" id="wrong-count">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card border-0" id="result-card">
                                        <div class="card-body py-3">
                                            <div id="modal-iscritical" class="text-center">
                                                <i class="fas fa-award fs-2 mb-2"></i>
                                                <h5 class="mb-0" id="final-result">Đang tính toán...</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer border-0 justify-content-center pb-4">
                        <a href="{{ route('userpage.home') }}" class="btn btn-outline-primary me-2">
                            <i class="fas fa-home me-2"></i>Trang chủ
                        </a>
                        <button type="button" onclick="location.reload();" class="btn btn-primary">
                            <i class="fas fa-redo me-2"></i>Thi lại
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Xác Nhận Kết Thúc -->
        <div class="modal fade" id="endtestModal" tabindex="-1" aria-labelledby="endtestModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-warning text-dark border-0">
                        <div class="w-100 text-center">
                            <i class="fas fa-exclamation-triangle fs-1 mb-2"></i>
                            <h4 class="modal-title fw-bold mb-0" id="endtestModalLabel">Xác nhận kết thúc</h4>
                        </div>
                    </div>
                    
                    <div class="modal-body p-4 text-center">
                        <div class="mb-4">
                            <p class="fs-5 mb-3 text-muted">Bạn có chắc chắn muốn kết thúc bài thi không?</p>
                            <div class="alert alert-warning border-0 d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                <small>Bài thi sẽ được chấm điểm ngay lập tức sau khi kết thúc</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer border-0 justify-content-center pb-4">
                        <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>Tiếp tục thi
                        </button>
                        <button data-liecenid="{{ $license->LicenseTypeID }}" id="submit-btn" class="btn btn-danger">
                            <i class="fas fa-stop me-2"></i>Kết thúc bài thi
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="container-lg mt-4 mb-5" style="box-shadow: 0 0 45px rgba(0, 0, 0, .06)">
        <div class="row g-0">
            <div class="col-lg-12 wow fadeIn" data-wow-delay="0.5s">
                <div class="bg-white rounded-top p-3">

                    <h5 id="license-name" class="mb-1 fw-bold text-primary">Cấu trúc Đề thi lý thuyết hạng
                        {{ $lastWordA }}</strong></h6>

                        <div class="mb-2">
                            <p class="mb-2">Bài thi lý thuyết hạng {{ $lastWordA }} bao gồm
                                {{ $license->LicenseTypeQuantity }} câu hỏi được phân bố như sau:
                            </p>
                            <h5 id="license-name" class="mb-1 fw-bold text-primary">Cách đánh giá:</strong></h6>
                                <p id="license-name" class="mb-1 ">Điểm số:</strong></p>

                                <ul>
                                    <li>Trả lời đúng mỗi câu sẽ đạt được 1 điểm.</li>
                                    <li>Để đạt yêu cầu kết quả thi phải đạt <strong style="color:#ff0000"
                                            id="quantity-passcount" data-quantity="{{ $license->LicenseTypeQuantity }}"
                                            data-passcount="{{ $license->LicenseTypePassCount }}">
                                            {{ $license->LicenseTypePassCount }}/{{ $license->LicenseTypeQuantity }}
                                        </strong> câu,
                                    </li>
                                    <li>Kết quả sẽ hiển thị ngay sau khi thí sinh thi xong.
                                    </li>
                                </ul>
                        </div>
                        <p class="mb-4">
                            <span id="short-text"><strong style="color:#ff0000">Lưu ý: </strong>Chọn sai <strong
                                    style="color:#ff0000">"CÂU
                                    ĐIỂM LIỆT"</strong> đồng nghĩa với việc <strong style="color:#ff0000">"KHÔNG
                                    ĐẠT"</strong> dù
                                các câu hỏi khác trả lời đúng</span>
                        </p>
                        <div class="text-center">
                            <button id="start-btn" class="btn btn-outline-primary mb-4">Bắt đầu thi</button>

                        </div>
                </div>
            </div>
        </div>
    </div>




    <!-- script -->
    <script>
        function loadExamSet(licenseID) {
            const examSetSelect = document.getElementById("examset")
            examSetSelect.innerText = ""
            fetch(`/practice-test/${licenseID}`)
                .then(response => response.json())
                .then(data => {

                    if (Array.isArray(data) && data.length > 0) {
                        const random = document.createElement("option")
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
                    // console.error('Error fetching exam sets:', error);
                    examSetSelect.innerHTML = '<option disabled>Lỗi khi tải đề thi</option>';
                });

        }
        document.getElementById('licenseType').addEventListener("change", function () {
            const licenseID = this.value
            if (licenseID) {
                loadExamSet(licenseID)
            }
        })


        let currentQuestionIndex = 0;
        let questionButtons = [];
        let endCountdownSeconds = 0;
        let timeFinish = 0;
        let disSelectAnswer = false



        document.addEventListener("DOMContentLoaded", function () {
            questionButtons = Array.from(document.querySelectorAll(".question-btn"));
            const buttons = document.querySelectorAll(".question-btn");
            const title = document.getElementById("question-title");
            const content = document.getElementById("question-content");
            const nextBtn = document.getElementById("next-btn");
            const image = document.getElementById("question-image");
            const divImage = document.getElementById("div-image");
            const startBtn = document.getElementById("start-btn");
            const examSection = document.getElementById("exam-section");
            const timerElement = document.getElementById("exam-timmer");
            const countdownMinutes = parseInt(timerElement.dataset.duration || 0);

            let countdownSeconds = countdownMinutes * 60;
            let timeStart = countdownSeconds;
            let timeInterval;

            let allExplanation = [];

            const licenseID = document.getElementById('licenseType').value
            if (licenseID) {
                loadExamSet(licenseID)
            }

            //xử ly nút trái phải
            document.addEventListener("keydown", function (event) {
                if (event.key === "ArrowRight") {
                    nextQuestionKey();
                } else if (event.key == "ArrowLeft") {
                    previousQuestionKey();
                }
            })
            // 

            // gọi hà
            initStartButton();
            initQuestionButtons();
            initAnswerSelection();
            showFirstQuestion();
            navigationButtons();

        });


        // ============================các hàm xử lý bắt đầu thi - thời gian========================
        // hàm xử lý bắt đầu bài thi
        function initStartButton() {
            const startBtn = document.getElementById("start-btn");
            if (!startBtn) return;

            startBtn.addEventListener("click", function () {
                this.style.display = "none";
                document.getElementById("exam-section").classList.remove("d-none");
                startCountdown();

                const firstQuestionBtn = document.querySelector(".question-btn");
                if (firstQuestionBtn) {
                    firstQuestionBtn.click();
                }
            });
        }

        //hàm bắt đầu đếm ngược
        function startCountdown() {
            const timerElement = document.getElementById("exam-timmer");
            const countdownMinutes = parseInt(timerElement.dataset.duration || 0);
            let countdownSeconds = countdownMinutes * 60;
            let timeStart = countdownSeconds;

            updateTimeDisplay(countdownSeconds);

            const interval = setInterval(() => {
                if (countdownSeconds <= 0) {
                    clearInterval(interval);
                    timerElement.innerText = "00:00";
                    alert("Bài làm đã kết thúc");
                    submit();
                } else {
                    countdownSeconds--;
                    updateTimeDisplay(countdownSeconds);
                    endCountdownSeconds = timeStart - countdownSeconds;
                }
            }, 1000);
            window.timeInterval = interval;
        }

        //đếm ngược thời gian
        function stopCountDown() {
            clearInterval(window.timeInterval);
        }

        // cập nhật thời gian
        function updateTimeDisplay(seconds) {
            const minutes = String(Math.floor(seconds / 60)).padStart(2, "0");
            const secs = String(seconds % 60).padStart(2, "0");
            document.getElementById("exam-timmer").innerText = `${minutes}:${secs}`;
        }

        //==================================end phần set time==========================================


        // =============================các hàm xử lý block question====================================
        function initQuestionButtons() {
            questionButtons = Array.from(document.querySelectorAll(".question-btn"));
            const buttons = document.querySelectorAll(".question-btn");
            buttons.forEach((btn, index) => {
                btn.addEventListener("click", function (e) {
                    e.preventDefault()

                    setActiveButton(this)
                    const questionID = this.dataset.id
                    showQuestionBlock(questionID)
                    selectAnswer(questionID)
                    currentQuestionIndex = index;

                })
            })
        }
        const selectedAnswer = {}
        const selectedLabel = {}
        const allAnswer = {}
        // hàm lưu đáp án
        function initAnswerSelection() {
            document.querySelectorAll(".answer-label").forEach((el) => {
                el.addEventListener("click", function () {
                    const questionID = this.dataset.questionId;
                    const answerID = this.dataset.answerId;
                    const label = this.dataset.label;

                    if (disSelectAnswer == true) {
                        return
                    }
                    // Cập nhật đáp án đã chọn
                    selectedAnswer[questionID] = answerID;
                    //cập nhat label đã chọn
                    selectedLabel[questionID] = label;
                    // Gọi lại hàm tô màu
                    selectAnswer(questionID);
                    selectQuestion(questionID)
                    // console.log(selectedAnswer)


                });
            });
        }
        //hàm show câu hỏi đầu tiên
        function showFirstQuestion() {
            const firstBtn = document.querySelector(".question-btn");
            if (firstBtn) {
                firstBtn.click()
            }
        }

        // gán active cho nút câu hỏi
        function setActiveButton(currentBtn) {
            const buttons = document.querySelectorAll(".question-btn")
            buttons.forEach((b) =>
                b.classList.remove("active")
            )
            currentBtn.classList.add("active")
        }
        //hàm show block question 
        function showQuestionBlock(questionID) {
            document.querySelectorAll(".question-block").forEach((block) => {
                block.style.display = "none"
            })

            const block = document.getElementById("question-block-" + questionID)
            if (block) {
                block.style.display = "block"
            }
        }
        //hàm tô màu câu hỏi khi Chọn
        function selectAnswer(questionID) {
            const selected = selectedLabel[questionID]
            if (selected) {
                document.querySelectorAll(`.answer-label[data-question-id="${questionID}"]`)
                    .forEach((el) => {
                        el.classList.remove("select-answer")
                    })
                const selectedRow = document.getElementById(`answer-row-${questionID}-${selected}`)
                if (selectedRow) {
                    selectedRow.classList.add("select-answer")
                }
            }
        }
        //hàm tô màu index câu hỏi 
        function selectQuestion(questionID) {
            const indexBtn = document.querySelector(`.question-btn[data-id="${questionID}"] .index-question`)
            if (indexBtn) {
                indexBtn.classList.add("selected-question")
            }
        }



        // ==================================end phần block question=====================================

        // ==================================hàm điều hướng câu hỏi======================================
        function navigationButtons() {
            document.getElementById("prev-btn").addEventListener("click", function () {
                if (currentQuestionIndex > 0) {
                    currentQuestionIndex--;
                    questionButtons[currentQuestionIndex].click();
                }
            });

            document.getElementById("next-btn").addEventListener("click", function () {
                if (currentQuestionIndex < questionButtons.length - 1) {
                    currentQuestionIndex++;
                    questionButtons[currentQuestionIndex].click();
                }
            });
        }

        // phím next
        function nextQuestionKey() {
            if (currentQuestionIndex < questionButtons.length - 1) {
                currentQuestionIndex++
                questionButtons[currentQuestionIndex].click()
            }
        }

        //phím previous
        function previousQuestionKey() {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--
                questionButtons[currentQuestionIndex].click()
            }
        }
        // ===============================end hàm điều hướng câu hỏi===========================================

        // ============================== submit ======================================

        //hàm tổng hợp các câu hỏi 
        function totalQuestion() {
            const buttons = document.querySelectorAll(".question-btn")
            buttons.forEach((btn) => {
                const questionID = btn.dataset.id
                if (selectedAnswer[questionID]) {
                    allAnswer[questionID] = selectedAnswer[questionID]
                } else {
                    allAnswer[questionID] = null
                }
            })
        }
        //hàm submit
        function submit() {

            stopCountDown()
            totalQuestion()
            disSelectAnswer = true
            timeFinish = startCountdown - endCountdownSeconds
            const buttons = document.querySelectorAll("question-btn");

            const submitBtnElement = document.getElementById("submit-btn");
            const licenseTypeID = submitBtnElement.dataset.liecenid;
            ModalOnSubmit()
            fetch(`/quiz-practice/finish/${licenseTypeID}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-token": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({
                    answers: allAnswer,
                    timeFinish: endCountdownSeconds,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    // console.log(JSON.stringify(data))
                    displayResultModal(data)
                    data.result.forEach(result => {
                        AnswerafterSubmit(result);
                        QuestionIndexAfterSubmit(result)
                        showExplanation(result)
                    });
                })
        }
        const submitBtn = document.getElementById("submit-btn")
        if (submitBtn) {
            submitBtn.addEventListener("click", function (e) {
                e.preventDefault()
                submit(this)
            })
        }

        //thiết lập modal 
        function ModalOnSubmit() {
            const previewBtn = document.getElementById("preview");
            const endTtestBtn = document.getElementById("end-test");
            const modalElement = document.getElementById("endtestModal");
            const modal = bootstrap.Modal.getInstance(modalElement);
            endTtestBtn.hidden = true;
            previewBtn.hidden = false;
            if (modal) modal.hide();
            $("#modalResults").modal("show");
            previewBtn.addEventListener("click", function () {
                $("#modalResults").modal("show");
            });
        }
        //hiển thị kết quả modal
        function displayResultModal(data) {
            const correctElemnt = document.getElementById("correct-count");
            const wrongCountElement = document.getElementById("wrong-count");
            const finalResultElement = document.getElementById("final-result");
            const resultCard = document.getElementById("result-card");

            const correctCount = data.correctCount;
            const sumQuestion = data.result[0]?.sumQuestion ?? 0;
            const notcorrect = sumQuestion - correctCount;
            const iscritical = data.iscriticalWrong;

            const quantity = document.getElementById("quantity-passcount").dataset.quantity;
            const passCount = document.getElementById("quantity-passcount").dataset.passcount;

            // Cập nhật số liệu
            correctElemnt.textContent = correctCount;
            wrongCountElement.textContent = notcorrect;

            // Xác định kết quả và styling
            if (iscritical) {
                finalResultElement.innerHTML = `<i class="fas fa-times-circle text-danger me-2"></i>Không đạt - Sai câu điểm liệt`;
                resultCard.className = "card border-0 danger";
            } else if (correctCount < passCount) {
                finalResultElement.innerHTML = `<i class="fas fa-times-circle text-danger me-2"></i>Không đạt<br><small class="text-muted">Yêu cầu tối thiểu ${passCount}/${quantity} câu</small>`;
                resultCard.className = "card border-0 danger";
            } else {
                finalResultElement.innerHTML = `<i class="fas fa-check-circle text-success me-2"></i>Chúc mừng! Bạn đã đạt`;
                resultCard.className = "card border-0 success";
            }
        }

        //đổi màu đáp án sau khi submit
        function AnswerafterSubmit(result) {
            const questionID = result.QuestionID;
            const selectedID = result.AnswerID;
            const correctID = result.answerCorrect;

            // Xóa class cũ
            document.querySelectorAll(`.answer-label[data-question-id="${questionID}"]`).forEach((el) => {
                el.classList.remove("correct-answer", "wrong-answer");
            });
            // Nếu đáp án đúng
            if (selectedID) {
                const selectedEl = document.querySelector(`.answer-label[data-question-id="${questionID}"][data-answer-id="${selectedID}"]`);
                if (selectedEl && !result.isCorrect) {
                    selectedEl.classList.add("wrong-answer");
                }
            }
            // nếu đáp án sai
            const correctEl = document.querySelector(`.answer-label[data-question-id="${questionID}"][data-answer-id="${correctID}"]`);
            if (correctEl) {
                correctEl.classList.add("correct-answer");
            }
        }
        //hàm đổi màu index quesiton
        function QuestionIndexAfterSubmit(result) {
            const questionID = result.QuestionID;
            const isCorrect = result.isCorrect;
            const indexQuestion = document.querySelector(`.question-btn[data-id="${questionID}"] .index-question`)
            if (indexQuestion) {
                indexQuestion.classList.remove("correct", "inCorrect");
                if (isCorrect) {
                    indexQuestion.classList.add("correct");
                } else {
                    indexQuestion.classList.add("inCorrect");
                }
            }

        }
        //hàm hiển thị giải thích 
        function showExplanation(result) {
            const questionID = result.QuestionID
            const explanation = result.explanation
            const container = document.querySelector(`#question-block-${questionID} #explanation-container`)
            if (container) {
                container.classList.remove("d-none")
                container.innerHTML = `<strong style = "color:#ff0000">Giải thích: </strong>${explanation}`
            }
        }



        //==================================end hàm submit=================================
    </script>





@endsection