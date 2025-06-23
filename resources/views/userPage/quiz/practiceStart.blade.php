@extends("userPage.layout.layout")
@section("title", "thi thử bằng $lastWordA")

@section("main")
        <!-- About Start -->
        <style>
      


            .question-item {
                font-size: 11px;
                padding: 7px 7px;
                width: 35px;
                height: 35px;
                line-height: 24px;
                margin: auto;
                border: 1px solid rgb(97, 149, 248);
            }

            .question-btn.active .question-item {
                background-color: rgb(156, 179, 213);
                color: white !important;

            }

            /* modal */
            .modal-content {
                border-radius: 1rem;
            }


            .modal-content:hover {
                box-shadow: 2px 2px 2px black;
            }

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
                font-size: 16px;
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

            .answer-item input {
                transform: scale(1.2);
                margin-right: 10px;
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
                min-width: 150px;
                min-height: 150px;
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


            /*  */
        </style>
      

        <!-- About End -->

        <!-- Page Header End -->


        <!-- practice Start -->
        <!-- <div class="text-center mb-4">
                                                                                                                                                <button id="start-btn" class="btn btn-success">Bắt đầu làm bài</button>
                                                                                                                                            </div> -->

        <div   class="container-lg d-none p-4" id="exam-section" style="box-shadow: 0 0 45px rgba(0, 0, 0, .06)">

            <div class="d-flex justify-content-between align-items-center mb-3 px-3" data-wow-delay="0.1s">
                <h3 class="display-7 mb-0 mt-2">Thi lý thuyết xe máy hạng {{ $lastWordA }} - {{ $examSet->ExamSetName }}</h3>
                <div class="btn display-7 mb-0 mt-3" id="exam-timmer" data-duration="{{ $license->LicenseTypeDuration }}"
                    style="background-color:#6Fc7e7">10:00</div>
            </div>
            <hr>
            <div class="row g-4 d-flex">
                <div class="col-lg-4 col-md-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item position-relative h-100">
                        <div class="service-text rounded p-4">
                            <div class="scroll-wrapper" style="max-height: 400px; overflow-y: auto;">
                            <div class="row g-4 wow fadeInUp p-2  " data-wow-delay="0.1s">
                                <!-- Dùng col-1 để mỗi hàng chứa tối đa 12 thẻ -->
                                <!-- Nếu thêm thẻ thứ 13 trở đi, nó tự xuống hàng -->

                                <!-- Ví dụ: 15 thẻ -->

                                @foreach ($questions as $index => $question)

                                    <!-- @php
                                        $answers = [];

                                        foreach ($question->answer_Question as $answer) {
                                            $key = strtoupper($answer->AnswerLabel); // Đảm bảo là A, B, C, D

                                            if (in_array($key, ["A", "B", "C", "D"])) {
                                                $answers[$key . '_ID'] = $answer->AnswerID;     // Gán ID
                                                $answers[$key . '_NAME'] = $answer->AnswerName; // Hiển thị nội dung nếu cần
                                            }
                                        }
                                    @endphp -->

                                    <div class="col-2 col-sm-1 col-md-3  col-lg-2">
                                        <a href="#" style="color:rgb(43, 39, 39); border-color:red" class="question-btn small"
                                            data-question="{{ $index + 1 }}" data-id={{ $question->QuestionID }}
                                            data-img="{{ $question->ImageDescription }}"
                                            data-content="{{ $question->QuestionName }}" data-a-id="{{ $answers['A_ID'] ?? ''  }}"
                                            data-b-id="{{ $answers['B_ID'] ?? '' }}" data-c-id="{{ $answers['C_ID'] ?? ''  }}"
                                            data-d-id="{{ $answers['D_ID'] ?? ''  }}" data-a-name="{{ $answers['A_NAME'] ?? ''  }}"
                                            data-b-name="{{ $answers['B_NAME'] ?? '' }}"
                                            data-c-name="{{ $answers['C_NAME'] ?? ''  }}"
                                            data-d-name="{{ $answers['D_NAME'] ?? ''  }}">

                                            <p class="index-question question-item rounded text-center"
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
                <div   class="col-lg-8 col-md-8  wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item position-relative h-100">
                        <div class="service-text rounded p-3">
                            @foreach($questions as $index => $question)
                                @php
                                $answers = [];
                                foreach ($question->answer_Question as $answer) {
                                    $key = strtoupper($answer->AnswerLabel);
                                    if (in_array($key, ["A", "B", "C", "D"])) {
                                        $answers[$key . '_ID'] = $answer->AnswerID;
                                        $answers[$key . '_NAME'] = $answer->AnswerName;
                                    }
                                }
                                @endphp
                                <div class="question-block" style="display: none; min-height: 250px; max-height: 350px; overflow-y: auto;" id="question-block-{{ $question->QuestionID }}"
                                    data-question-id="{{ $question->QuestionID }}">
                                    <div class="d-flex align-items-center">
                                        <h5 id="question-title" class="me-2 mb-0">Câu {{ $index + 1 }}:
                                            {{ $question->QuestionName }}
                                        </h5>
                                        <!-- <p id="question-content" class="mb-0 mt-1"></p> -->
                                    </div>
                                    @if($question->ImageDescription)
                                        <div id="div-image"
                                            class="mt-2 d-flex align-items-center align-items-start mb-2 answer-item">
                                            <img src="{{ asset("storage/uploads/imageQuestion/$question->ImageDescription") }}" alt="">
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
                            <div class="d-flex justify-content-between mt-3">
                                <button class="btn btn-primary" id="prev-btn">← Trước</button>
                                <button class="btn btn-primary" id="next-btn">Sau →</button>
                            </div>


                        </div>

                    </div>
                </div>

            </div>
            
            <!-- modal thong báo kết quả -->
            <!-- modal ket quả -->
            <div class="modal fade" id="modalResults" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content py-md-5 px-md-4 p-sm-3 p-4 position-relative">

                        <!-- Nút X góc trên bên phải -->
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                            aria-label="Close"></button>

                        <h3 class="text-center"><strong>Kết quả thi</strong></h3>
                        <hr>
                        <p id="modal-correct" class="r3 px-sm-1"></p>
                        <p id="modal-notCorrect" class="r3 px-sm-1"></p>
                        <p id="modal-iscritical" class="r3 px-sm-1"></p>
                        <hr>
                        <div class="text-center mb-3 d-flex justify-content-center">
                            <a href="{{ route('userpage.home') }}" class="btn btn-primary w-30 mx-2 b1">Trang chủ</a>
                            <a href="{{ route("userpage.practiceStart", ["licenseID" => $license->LicenseTypeID, "examsetID" => $examSet->ExamSetID])}}"
                                class="btn btn-primary w-30 mx-2 b1">Thi lại</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- endmodal -->

            <!-- modal ket thuc thi -->

            <div class="modal fade" id="endtestModal" tabindex="-1" aria-labelledby="formNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content py-md-5 px-md-4 p-sm-3 p-4">
                        <h3 class="text-center">Xác nhận</h3>
                        <p class="text-center">Bạn muốn kết thúc bài thi không ?</p>
                        <div class="text-center mb-3 d-flex justify-content-center">
                            <button data-examsetid="{{ $examSet->ExamSetID }}" data-liecenid="{{ $license->LicenseTypeID }}"
                                id="submit-btn" class="btn btn-danger w-30 mx-2 ">kết thúc</button>
                            <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-primary w-30 mx-2">tiếp tục
                                thi</button>
                        </div>
                    </div>
                </div>
                <!-- end modal -->
            </div>

        </div>
          <div class="container-lg mt-4 mb-5" style="box-shadow: 0 0 45px rgba(0, 0, 0, .06)">
            <div class="row g-0">
                <div class="col-lg-12 wow fadeIn" data-wow-delay="0.5s">
                    <div class="bg-white rounded-top p-5">
                        <h1 class="display-6"><strong>Thi thử lý thuyết hạng {{ $lastWordA }}</strong></h1>
                        <div class="mb-2">
                            <p class="mb-2">Cấu trúc đề thi sát hạch giấy phép lái xe hạng {{ $lastWordA }} bao gồm
                                {{ $license->LicenseTypeQuantity }} câu hỏi, mỗi câu hỏi
                                chỉ có duy nhất một câu trả lời đúng.
                            </p>
                            <h5>Bao gồm</h5>
                            <ul>
                                <li>số lượng câu hỏi: <strong style="color:#ff0000"> {{ $license->LicenseTypeQuantity }}
                                        câu</strong></li>
                                <li>yêu cầu : <strong style="color:#ff0000" id="quantity-passcount"
                                        data-quantity="{{ $license->LicenseTypeQuantity }}"
                                        data-passcount="{{ $license->LicenseTypePassCount }}">đúng
                                        {{ $license->LicenseTypePassCount }}/{{ $license->LicenseTypeQuantity }} câu</strong>
                                </li>
                                <li>Thời gian: <strong style="color:#ff0000">{{ $license->LicenseTypeDuration }} phút</strong>
                                </li>
                            </ul>
                        </div>
                        <p class="mb-4">
                            <span id="short-text"><strong>Lưu ý đặc biệt: </strong>Chọn sai <strong style="color:#ff0000">"CÂU
                                    ĐIỂM LIỆT"</strong> đồng nghĩa với việc <strong style="color:#ff0000">KHÔNG ĐẠT"</strong> dù
                                các câu hỏi khác trả lời đúng</span>
                            <span id="full-text" style="display: none;">
                                Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet
                                diam et eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo
                            </span>
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
            let currentQuestionIndex = 0;
            let questionButtons = [];
            let endCountdownSeconds = 0;
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
                        console.log(selectedAnswer)


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
                const buttons = document.querySelectorAll("question-btn");

                const submitBtnElement = document.getElementById("submit-btn");
                const licenseTypeID = submitBtnElement.dataset.liecenid;
                const examsetID = submitBtnElement.dataset.examsetid;
                ModalOnSubmit()
                fetch(`/quiz-practice/finish/${licenseTypeID}/${examsetID}`, {
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
                        console.log(data)

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
                const iscriticalElemet = document.getElementById("modal-iscritical");
                const correctElemnt = document.getElementById("modal-correct");
                const notcorrectElement = document.getElementById("modal-notCorrect");

                const correctCount = data.correctCount;
                const sumQuestion = data.result[0]?.sumQuestion ?? 0;
                const notcorrect = sumQuestion - correctCount;
                const iscritical = data.iscriticalWrong;

                const quantity = document.getElementById("quantity-passcount").dataset.quantity;
                const passCount = document.getElementById("quantity-passcount").dataset.passcount;

                correctElemnt.innerHTML = `<p><strong>Số câu đúng:</strong> ${correctCount}</p>`;
                notcorrectElement.innerHTML = `<p><strong>Số câu sai:</strong> ${notcorrect}</p>`;

                if (iscritical) {
                    iscriticalElemet.innerHTML = `
                                        <p><strong>Kết quả:</strong> Không đạt - sai câu điểm liệt</p>`;
                } else if (correctCount < passCount) {
                    iscriticalElemet.innerHTML = `
                                        <p><strong>Kết quả:</strong> Không đạt - yêu cầu tối thiểu đúng ${passCount}/${quantity} câu</p>`;
                } else {
                    iscriticalElemet.innerHTML = `
                                        <p><strong>Kết quả:</strong> Đạt</p>`;
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
                console.log(isCorrect)
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