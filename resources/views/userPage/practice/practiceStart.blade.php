@extends("userPage.layout.layout")
@section("title", "thi thử bằng $lastWordA" )

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
            background-color:rgb(156, 179, 213);
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





        /*  */
    </style>
    <div class="container-lg mt-4 mb-5" style="box-shadow: 0 0 45px rgba(0, 0, 0, .06)">
        <div class="row g-0">
            <div class="col-lg-12 wow fadeIn" data-wow-delay="0.5s">
                <div class="bg-white rounded-top p-5">
                    <h1 class="display-6"><strong>Thi thử lý thuyết hạng {{ $lastWordA }}</strong></h1>
                    <div class="mb-2">
                        <p class="mb-2">Cấu trúc đề thi sát hạch giấy phép lái xe hạng {{ $lastWordA }} bao gồm 25 câu hỏi, mỗi câu hỏi
                            chỉ có duy nhất một câu trả lời đúng.</p>
                        <h5>Bao gồm</h5>
                        <ul>
                            <li>số lượng câu hỏi: <strong style="color:#ff0000"> câu</strong></li>
                            <li>yêu cầu : <strong style="color:#ff0000">đúng 21/25 câu</strong> </li>
                            <li>Thời gian: <strong style="color:#ff0000">19 phút</strong> </li>
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


    <!-- About End -->

    <!-- Page Header End -->


    <!-- practice Start -->
    <!-- <div class="text-center mb-4">
            <button id="start-btn" class="btn btn-success">Bắt đầu làm bài</button>
        </div> -->

    <div class="container-lg d-none" id="exam-section" style="box-shadow: 0 0 45px rgba(0, 0, 0, .06)">

        <div class="d-flex justify-content-between align-items-center mb-3 px-3" data-wow-delay="0.1s">
            <h3 class="display-7 mb-0 mt-2">Thi lý thuyết xe máy hạng {{ $lastWordA }} - {{ $examSet->ExamSetName }}</h3>
            <div class="btn display-7 mb-0 mt-3" id="exam-timmer" style="background-color:#6Fc7e7">10:00</div>
        </div>
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

                                <!-- 
                                                                        @php
                                                                            $answers = [];

                                                                            foreach ($question->answer_Question as $answer) {
                                                                                $key = strtoupper($answer->AnswerLabel); // Đảm bảo là A, B, C, D

                                                                                if (in_array($key, ["A", "B", "C", "D"])) {
                                                                                    $answers[$key . '_ID'] = $answer->AnswerID;     // Gán ID
                                                                                    $answers[$key . '_NAME'] = $answer->AnswerName; // Hiển thị nội dung nếu cần
                                                                                }
                                                                            }
                                                                        @endphp 
                                                                        -->

                                <div class="col-2 col-sm-1 col-md-3  col-lg-2" >
                                    <a href="#" style="color:rgb(43, 39, 39); border-color:red" class="question-btn small"
                                        data-question="{{ $index + 1 }}" data-id={{ $question->QuestionID }}
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

                            <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#endtestModal"
                                data-examsetid="{{ $examSet->ExamSetID }}" id="end-test">Nộp bài</button>
                            <button class="btn btn-primary mt-3" hidden id="preview">Xem kết quả</button>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8  wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item position-relative h-100">
                    <div class="service-text rounded p-3">
                        <div class="d-flex align-items-center">
                            <h4 id="question-title" class="me-2 mb-0"></h4>
                            <p id="question-content" class="mb-0 mt-1"></p>
                        </div>

                          <div class="mt-2">
                            @foreach ($labels as $label)
                                <div class="d-flex align-items-center align-items-start mb-2 answer-item" id="answer-row-{{ $label }}">
                                    <input type="radio" name="answer" id="radio{{ $label }}" value="" class="me-2 mb-0 mt-1">
                                    <p class="mb-0" id="answer{{$label}}"> {{$answers[$label . '_NAME'] ?? ''}} :
                                    </p> 
                                </div>

                            @endforeach
                            <div id="explanation-container" class = "d-none"></div>

                        </div>
                        <button class="btn btn-primary mt-3" id="next-btn">Tiếp theo</button>

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
                        <a href="{{ route("userpage.practiceStart", ["licenseID"=>$license->LicenseTypeID, "examsetID"=>$examSet->ExamSetID])}}"
                            class="btn btn-primary w-30 mx-2 b1">Làm lại</a>
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
                        <button id="submit-btn" class="btn btn-danger w-30 mx-2 ">kết thúc</button>
                        <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-primary w-30 mx-2">tiếp tục
                            thi</button>
                    </div>
                </div>
            </div>
            <!-- end modal -->
        </div>

    </div>


    <!-- script -->
 <script src = "/assets/adminPage/practice/practice_exam.js"></script>

    <!-- end script -->


@endsection