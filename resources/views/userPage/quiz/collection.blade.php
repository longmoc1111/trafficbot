@extends("userPage.layout.layout")
@section("title", "thi thử bằng ")

@section("main")
    <!-- About Start -->
    <style>
        .question-item {
            font-size: 14px;
            /* Giảm cỡ chữ */
            padding: 10px 10px;
            /* Giảm padding */
            width: 40px;
            height: 40px;
            line-height: 24px;
            margin: auto;
            border: 1px solid rgb(97, 149, 248);
        }

        .question-btn.active .question-item {
            background-color: #6Fc7e7;
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

        /* .selected-question {
                                                background-color: #DCFCE7;
                                                color: black !important;
                                                border-color: #4ade80;
                                            } */

        .index-question.correct {
            background-color: #DCFCE7;
            /* xanh lá */
            color: black;
            border-radius: 50%;
        }

        .index-question.incorrect {
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
            background-color: #fee2e2;
            border-radius: 5px;
            padding: 5px;
        }

        .select-item {
            width: 100%;
            padding: 10px 15px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            color: #333;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='10' height='6' viewBox='0 0 10 6' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L5 5L9 1' stroke='%234761FF' stroke-width='1.5' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 12px;
            transition: border-color 0.3s;
        }

        .select-item :focus {
            outline: none;
            border-color: #4761FF;
            box-shadow: 0 0 0 2px rgba(71, 97, 255, 0.2);
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
        <hr>
        <div class="row g-4 d-flex">
            <div class="col-lg-4 col-md-4 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item position-relative h-100">
                    <div class="service-text rounded p-4">
                        <div class="row g-4 wow fadeInUp" data-wow-delay="0.1s">
                            <!-- Dùng col-1 để mỗi hàng chứa tối đa 12 thẻ -->
                            <!-- Nếu thêm thẻ thứ 13 trở đi, nó tự xuống hàng -->

                            <!-- Ví dụ: 15 thẻ -->
                            @foreach ($questions as $index => $question)
                                @php
                                    $answers = [];

                                    foreach ($question->answer_Question as $answer) {
                                        $key = strtoupper($answer->AnswerLabel); // Đảm bảo là A, B, C, D
                                        if (in_array($key, ["A", "B", "C", "D"])) {
                                            $answers[$key . '_ID'] = $answer->AnswerID;     // Gán ID
                                            $answers[$key . '_NAME'] = $answer->AnswerName; // Hiển thị nội dung nếu cần
                                            $answers[$key . '_CORRECT'] = $answer->IsCorrect;
                                        }
                                    }
                                @endphp
                                <div class="col-2 col-sm-1 col-md-3  col-lg-2">
                                    <a href="#" style="color:rgb(43, 39, 39); border-color:red" class="question-btn small"
                                        data-question="{{ $index + 1 }}" data-id={{ $question->QuestionID }}
                                        data-explanation="{{ $question->QuestionExplain }}"
                                        data-content="{{ $question->QuestionName }}" data-a-id="{{ $answers['A_ID'] ?? ''  }}"
                                        data-b-id="{{ $answers['B_ID'] ?? '' }}" data-c-id="{{ $answers['C_ID'] ?? ''  }}"
                                        data-d-id="{{ $answers['D_ID'] ?? ''  }}" data-a-name="{{ $answers['A_NAME'] ?? ''  }}"
                                        data-b-name="{{ $answers['B_NAME'] ?? '' }}"
                                        data-c-name="{{ $answers['C_NAME'] ?? ''  }}"
                                        data-d-name="{{ $answers['D_NAME'] ?? ''  }}"
                                        data-a-correct="{{ $answers["A_CORRECT"] ?? '' }}"
                                        data-b-correct="{{ $answers["B_CORRECT"] ?? '' }}"
                                        data-c-correct="{{ $answers["C_CORRECT"] ?? '' }}"
                                        data-d-correct="{{ $answers["D_CORRECT"] ?? '' }}">

                                        <p class="index-question question-item rounded text-center"
                                            style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                            {{ $index + 1 }}
                                        </p>
                                    </a>
                                </div>
                            @endforeach

                            <a href="{{ route("userpage.home") }}" class="btn btn-primary mt-3" id="end-test">Thoát</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8  wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item position-relative h-100">
                    <div class="service-text rounded p-3">
                        <div class="d-flex align-items-center">
                            <h6 id="question-title" class="me-2 mb-0"></h6>
                            <p id="question-content" class="mb-0 mt-1"></p>
                        </div>

                        <div class="mt-2">
                            @foreach ($labels as $label)
                                <div class="d-flex align-items-center align-items-start mb-2 answer-item"
                                    id="answer-row-{{ $label }}">
                                    <input type="radio" name="answer" id="radio{{ $label }}" value="" class="me-2 mb-0 mt-1 ">
                                    <p class="mb-0" id="answer{{$label}}"> {{$answers[$label . '_NAME'] ?? ''}} :
                                    </p>
                                </div>
                            @endforeach
                            <div id="explanation-container" class="d-none"></div>



                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <button id="prevButton" class="btn btn-primary">
                                Trước
                            </button>

                            <button id="nextButton" class="btn btn-primary">
                                Sau
                            </button>
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
    document.addEventListener("DOMContentLoaded", function () {
        const buttons = document.querySelectorAll(".question-btn");
        const title = document.getElementById("question-title")
        const content = document.getElementById("question-content")
        const prevButton = document.getElementById("prevButton");
        const nextButton = document.getElementById("nextButton");


        //hàm hiển thị đáp án
        function UpdateAnswerDisplay(buttonElement) {
            const labels = ["A", "B", "C", "D"]
            labels.forEach(label => {
                const name = buttonElement.dataset[`${label.toLowerCase()}Name`]
                const answerText = document.getElementById(`answer${label}`)
                const answerRow = document.getElementById(`answer-row-${label}`)
                if (name && name.trim() !== "") {
                    answerText.innerText = `${label} : ${name}`
                    answerRow.style.display = "flex"
                    answerRow.classList.remove("hidden-question")
                } else {
                    answerText.innerText = ""
                    answerRow.classList.add("hidden-question")
                }
            })
        }
        //hàm hiển thị câu hỏi
        function updateQuestionDisplay(buttonElement) {
            const numberQS = buttonElement.dataset.question
            const contentQS = buttonElement.dataset.content
            console.log(numberQS)
            title.innerText = `Câu ${numberQS} : ${contentQS} `
            // content.innerText = 
        }
        function getCorrectAnswer(buttonELement) {
            const labels = ['a', 'b', 'c', 'd']
            for (let label of labels) {
                const correct = buttonELement.dataset[`${label}Correct`]
                const answerID = buttonELement.dataset[`${label}Id`]
                if (correct == '1' || correct == true) {
                    return answerID
                }
            }
            return null
        }

        function changeColorAnswer(buttonELement) {
            const indexQS = buttonELement.querySelector(".index-question")
            const QuestionID = buttonELement.dataset.id
            const selectedID = selectedAnswer[QuestionID]

            // console.log(selectedID)

            const labels = ["A", "B", "C", "D"]
            labels.forEach(label => {
                const row = document.getElementById(`answer-row-${label}`)
                const answerID = buttonELement.dataset[`${label.toLowerCase()}Id`]
                const correct = buttonELement.dataset[`${label.toLowerCase()}Correct`]

                row.classList.remove("correct-answer", "wrong-answer")

                if (selectedID == answerID) {
                    if (correct == "1" || correct === true) {
                        row.classList.add("correct-answer");
                    } else {
                        row.classList.add("wrong-answer");
                    }
                }
            })
            if (indexQS) {
                indexQS.classList.remove("incorrect", "correct")
                const correctID = getCorrectAnswer(buttonELement)
                console.log("selectedID " + selectedID + "correctID" + correctID)
                if (selectedID == correctID) {
                    indexQS.classList.add("correct")
                } else if (selectedID) {
                    indexQS.classList.add("incorrect")
                }
            }

        }


        //object lưu đáp án 
        selectedAnswer = {}
        document.querySelectorAll('input[name="answer"]').forEach(radio => {
            radio.addEventListener("change", function () {
                const activeBtn = document.querySelector(".question-btn.active")
                if (activeBtn) {
                    const questionID = activeBtn.dataset.id
                    const selectedLabel = this.id.replace("radio", "")
                    const radio = document.getElementById(`radio${selectedLabel}`)
                    const answerID = activeBtn.dataset[`${selectedLabel.toLowerCase()}Id`]
                    radio.value = answerID
                    selectedAnswer[questionID] = answerID
                    showExplanation(activeBtn);
                    changeColorAnswer(activeBtn)

                }
            })
        })
        function showExplanation(buttonElement) {
            const explanationQS = buttonElement.dataset.explanation
            const questionID = buttonElement.dataset.id
            const selectedID = selectedAnswer[questionID]
            const explain = document.getElementById("explanation-container")


            if (!selectedID) {
                explain.classList.add("d-none")
                return
            }
            explain.classList.remove("d-none")
            const correctID = getCorrectAnswer(buttonElement)
            let correctLabel = ""
            const labels = ["A", "B", "C", "D"]
            labels.forEach(label => {
                const answerID = buttonElement.dataset[`${label.toLowerCase()}Id`]
                if (answerID == correctID) {
                    correctLabel = label
                }
            })
            explain.innerText = `Đáp án đúng: ${correctLabel}\n\Giải thích: ${explanationQS}`


        }


        function updateRadioButtons(QuestionID) {
            document.querySelectorAll('input[name="answer"]').forEach(radio => {
                radio.checked = false
                if (radio.value == selectedAnswer[QuestionID]) {
                    radio.checked = true
                }
            })
        }

        // sự kiện đổi câu hỏi qua button
        buttons.forEach(btn => {
            btn.addEventListener("click", function (e) {
                e.preventDefault()
                const questionID = this.dataset.id
                buttons.forEach(b => b.classList.remove("active"))
                this.classList.add("active")
                updateQuestionDisplay(this)
                UpdateAnswerDisplay(this)
                updateRadioButtons(questionID)
                showExplanation(this)
                changeColorAnswer(this)


            })
        })


        prevButton.addEventListener("click", function (e) {
            e.preventDefault();
            const activeBtn = document.querySelector(".question-btn.active");
            if (activeBtn) {
                const currentIndex = Array.from(buttons).indexOf(activeBtn);
                if (currentIndex > 0) {
                    const prevBtn = buttons[currentIndex - 1];
                    buttons.forEach(b => b.classList.remove("active"));
                    prevBtn.classList.add("active");
                    updateQuestionDisplay(prevBtn);
                    UpdateAnswerDisplay(prevBtn);
                    updateRadioButtons(prevBtn.dataset.id);
                    showExplanation(prevBtn)
                    changeColorAnswer(prevBtn)

                }
            }
        });

        nextButton.addEventListener("click", function (e) {
            e.preventDefault();
            const activeBtn = document.querySelector(".question-btn.active");
            if (activeBtn) {
                const currentIndex = Array.from(buttons).indexOf(activeBtn);
                if (currentIndex < buttons.length - 1) {
                    const nextBtn = buttons[currentIndex + 1];
                    buttons.forEach(b => b.classList.remove("active"));
                    nextBtn.classList.add("active");
                    updateQuestionDisplay(nextBtn);
                    UpdateAnswerDisplay(nextBtn);
                    updateRadioButtons(nextBtn.dataset.id);
                    showExplanation(nextBtn)
                    changeColorAnswer(nextBtn)


                }
            }
        });
        //         let isKeyboardNavigation = false;

        // document.addEventListener("keydown", function (e) {
        //     const activeBtn = document.querySelector(".question-btn.active");
        //     if (!activeBtn) return;

        //     const currentIndex = Array.from(buttons).indexOf(activeBtn);

        //     if (e.key === "ArrowLeft") {
        //         if (currentIndex > 0) {
        //             const prevBtn = buttons[currentIndex - 1];
        //             buttons.forEach(b => b.classList.remove("active"));
        //             prevBtn.classList.add("active");
        //             updateQuestionDisplay(prevBtn);
        //             UpdateAnswerDisplay(prevBtn);

        //             // không update radio nếu chuyển bằng keyboard
        //             // updateRadioButtons(prevBtn.dataset.id);
        //         }
        //     } else if (e.key === "ArrowRight") {
        //         if (currentIndex < buttons.length - 1) {
        //             const nextBtn = buttons[currentIndex + 1];
        //             buttons.forEach(b => b.classList.remove("active"));
        //             nextBtn.classList.add("active");
        //             updateQuestionDisplay(nextBtn);
        //             UpdateAnswerDisplay(nextBtn);

        //             // không update radio nếu chuyển bằng keyboard
        //             // updateRadioButtons(nextBtn.dataset.id);
        //         }
        //     }
        // });


        if (buttons.length > 0) {
            buttons[0].classList.add("active")
            updateQuestionDisplay(buttons[0])
            UpdateAnswerDisplay(buttons[0])
        }


    });


</script>