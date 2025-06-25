@extends("userPage.layout.layout")
@section("title", "Ôn tập tổng hợp")

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

        .explanation-container {
            border: 2px solid #ccc;
            border-radius: 8px;
            padding: 12px 16px;
            margin-top: 16px;
            background-color: #F6FEF9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size: 14px;
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

    <div class="container-lg mt-5 mb-5 " id="exam-section" style="box-shadow: 0 0 45px rgba(0, 0, 0, .06)">
        <div class="row g-4 d-flex">
            <div class="d-flex justify-content-between align-items-center px-3" data-wow-delay="0.1s">
                <select class="select-item display-7 form-select mb-0 mt-2" onchange="location = this.value">
                    @foreach ($chapters as $option)
                        <option value="{{ route('userpage.chapters', ['ID' => $option->CategoryID]) }}" {{ $option->CategoryID == $chapter->CategoryID ? "selected" : "" }}>{{ $option->CategoryName }}</option>
                    @endforeach
                </select>
            </div>
            <hr>
            <div class="col-lg-4 col-md-4 h-100 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item position-relative h-100">
                    <div class="service-text rounded p-4">
                        <div class="scroll-wrapper" style="max-height: 250px; overflow-y: auto;">
                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                  @foreach ($questions as $index => $question)
                                @php
                                    $answers = [];
                                    $labelCorrect = '';

                                    foreach ($question->answer_Question as $answer) {
                                        $key = strtoupper($answer->AnswerLabel); // Đảm bảo là A, B, C, D
                                        if (in_array($key, ["A", "B", "C", "D"])) {
                                            $answers[$key . '_ID'] = $answer->AnswerID;     // Gán ID
                                            $answers[$key . '_NAME'] = $answer->AnswerName; // Hiển thị nội dung nếu cần
                                            $answers[$key . '_CORRECT'] = $answer->IsCorrect;
                                            if ($answer->IsCorrect) {
                                                $labelCorrect = $key;
                                            }
                                        }
                                    }
                                @endphp
                                <div>
                                    <a href="#" style="color:rgb(43, 39, 39); border-color:red" class="question-btn small"
                                        data-question="{{ $index + 1 }}" data-id={{ $question->QuestionID }}
                                        data-explanation="{{ $question->QuestionExplain }}"
                                        data-img="{{ $question->ImageDescription }}"
                                        data-content="{{ $question->QuestionName }}" data-a-id="{{ $answers['A_ID'] ?? ''  }}"
                                        data-b-id="{{ $answers['B_ID'] ?? '' }}" data-c-id="{{ $answers['C_ID'] ?? ''  }}"
                                        data-d-id="{{ $answers['D_ID'] ?? ''  }}" data-a-name="{{ $answers['A_NAME'] ?? ''  }}"
                                        data-b-name="{{ $answers['B_NAME'] ?? '' }}"
                                        data-c-name="{{ $answers['C_NAME'] ?? ''  }}"
                                        data-d-name="{{ $answers['D_NAME'] ?? ''  }}" data-label-correct="{{ $labelCorrect }}">

                                        <p class="index-question question-item rounded text-center"
                                            style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                            {{ $index + 1 }}
                                        </p>
                                    </a>
                                </div>
                            @endforeach

                                <!-- Nút thoát nằm riêng một hàng -->
                                <div class="w-100 mt-3">
                                    <a href="{{ route('userpage.home') }}" class="btn btn-primary w-100"
                                        id="end-test">Thoát</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8  wow fadeInUp" data-wow-delay="0.3s">
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
                             <div class="question-block"
                                style="display: none; min-height: 350px; max-height: 600px; overflow-y: auto;"
                                id="question-block-{{ $question->QuestionID }}" data-question-id="{{ $question->QuestionID }}">
                                <div class="d-flex align-items-center">
                                    <h5 id="question-title" class="me-2 mb-0">Câu {{ $index + 1 }}:
                                        {{ $question->QuestionName }}
                                    </h5>
                                    <!-- <p id="question-content" class="mb-0 mt-1"></p> -->
                                </div>
                                @if($question->ImageDescription)
                                    <div id="div-image" class="mt-2 d-flex align-items-center align-items-start mb-2 answer-item">
                                                                                <img src="{{ asset("storage/uploads/imageQuestion/$question->ImageDescription") }}"
                                            class="img-fluid d-block mx-auto"
                                            style="max-width: 350px; height: auto; object-fit: contain;" alt="">

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
                                    <div class="explanation-container d-none" data-question-id="{{ $question->QuestionID }}">
                                    </div>
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

        </div>



    </div>


    <!-- script -->
    <!-- <script src = "/assets/adminPage/practice/practice_exam.js"></script> -->

    <!-- end script -->


@endsection
<script>
    let currentQuestionIndex = 0;
    let questionButtons = [];
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
        // const countdownMinutes = parseInt(timerElement.dataset.duration || 0);



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
        initQuestionButtons();
        initAnswerSelection();
        showFirstQuestion();
        navigationButtons();

    });

    // hàm xử lý bắt đầu bài thi


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

    const selectedLabel = {}
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
                //cập nhat label đã chọn
                selectedLabel[questionID] = label;
                // Gọi lại hàm tô màu
                selectAnswer(questionID);
                selectQuestion(questionID)
                showExplanation(questionID)



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

    function selectAnswer(questionID) {
        const selected = selectedLabel[questionID];
        if (!selected) return;


        document.querySelectorAll(`.answer-label[data-question-id="${questionID}"]`)
            .forEach((el) => el.classList.remove("correct-answer", "wrong-answer", "select-answer"));

        const selectedRow = document.getElementById(`answer-row-${questionID}-${selected}`);
        const questionBtn = document.querySelector(`.question-btn[data-id="${questionID}"]`);
        const correctLabel = questionBtn?.dataset.labelCorrect;

        if (selected === correctLabel) {
            selectedRow?.classList.add("correct-answer");
        } else {
            selectedRow?.classList.add("wrong-answer");

            const correctRow = document.getElementById(`answer-row-${questionID}-${correctLabel}`);
            correctRow?.classList.add("correct-answer");
        }

        // showExplanation(questionID, correctLabel);
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

    function showExplanation(questionID) {
        const questionBtn = document.querySelector(`.question-btn[data-id="${questionID}"]`);
        const explanation = questionBtn?.dataset.explanation || '';
        const labelCorrect = questionBtn?.dataset.labelCorrect || '';
        console.log(explanation)

        const explanationContainer = document.querySelector(`.explanation-container[data-question-id="${questionID}"]`);
        if (explanationContainer) {
            if (explanation.trim() !== "") {
                explanationContainer.classList.remove("d-none");
                explanationContainer.innerHTML = `<div>
              <p><strong>Đáp án đúng:</strong> ${labelCorrect}</p>
            <strong>Giải thích:</strong> ${explanation}
            </div>`;
            } else {
                explanationContainer.classList.add("d-none");
                explanationContainer.innerHTML = "";
            }
        }

    }
    // ===============================end hàm điều hướng câu hỏi===========================================

</script>