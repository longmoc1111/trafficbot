// document.getElementById("toggle-btn").addEventListener("click", function () {
//     var fullText = document.getElementById("full-text");
//     var shortText = document.getElementById("short-text");
//     var btn = this;

//     if (fullText.style.display === "none") {
//         fullText.style.display = "inline";
//         shortText.style.display = "none";
//         btn.innerText = "Thu gọn";
//     } else {
//         fullText.style.display = "none";
//         shortText.style.display = "inline";
//         btn.innerText = "Xem thêm";
//     }
// });

document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".question-btn");
    const title = document.getElementById("question-title");
    const content = document.getElementById("question-content");
    const nextBtn = document.getElementById("next-btn");
    const answerA = document.getElementById("answerA");
    const answerB = document.getElementById("answerB");
    const answerC = document.getElementById("answerC");
    const answerD = document.getElementById("answerD");

    // lấy toàn bộ data được gửi lại
    let allExplanation = [];
    document.getElementById("start-btn").addEventListener("click", function () {
        // Ẩn nút bắt đầu
        this.style.display = "none";
        document.getElementById("exam-section").classList.remove("d-none");
        startCountdown();

        // Gọi click vào câu hỏi đầu tiên nếu muốn
        const firstQuestionBtn = document.querySelector(".question-btn");
        if (firstQuestionBtn) {
            firstQuestionBtn.click();
        }
    });

    //

    //set thời gian làm bài
    let countdownSeconds = 1140;
    let timeInterval;
    function startCountdown() {
        updatateTimeDisplay(countdownSeconds);
        timeInterval = setInterval(() => {
            if (countdownSeconds <= 0) {
                clearInterval(timeInterval);
                document.getElementById("exam-timmer").innerText = `00:00`;
                alert("bai làm đã kết thúc");
                submitExam();
            } else {
                countdownSeconds--;
                updatateTimeDisplay(countdownSeconds);
            }
        }, 1000);
    }

    function stopCountDown() {
        clearInterval(timeInterval);
    }

    function updatateTimeDisplay(seconds) {
        const minutes = String(Math.floor(seconds / 60)).padStart(2, "0");
        const secs = String(seconds % 60).padStart(2, "0");
        document.getElementById("exam-timmer").innerText = `${minutes}:${secs}`;
    }
    //end set thời gian làm bài

    function getCurrentQuestion() {
        const btn = document.querySelector(".question-btn.active");
        if (!btn) return null;
        return {
            id: btn.dataset.id,
        };
    }

    function showExplanation(questionID, data) {
        const explainElement = document.getElementById("explanation-container");
        const showEpl = data.find((item) => item.QuestionID == questionID);
        explainElement.innerHTML = "";

        if (showEpl) {
            const block = document.createElement("div");
            block.classList.add("preview-explanation");
            explainElement.classList.remove("d-none");
            block.innerHTML = `
                          <p>Đáp án đúng: ${showEpl.labelCorrect}</p>
                          <p>Giải thích: ${showEpl.explanation}</p>
                                                 `;
            explainElement.appendChild(block);
        }
    }
    //hàm đổi màu câu hỏi đúng sai
   function changeColorResult(resultArr) {
    resultArr.forEach((item) => {
        const questionID = item.QuestionID;
        const isCorrect = item.isCorrect;
        const selectedAnswerID = item.AnswerID;
        const correctAnswerID = item.answerCorrect;
        const labels = ["A", "B", "C", "D"];

        const questionBtn = document.querySelector(`.question-btn[data-id='${questionID}']`);
        if (!questionBtn) return;

        labels.forEach((label) => {
            const row = document.getElementById(`answer-row-${label}`);
            const radio = document.getElementById(`radio${label}`);
            if (!row || !radio) return;

            const answerID = radio.value;
            console.log(answerID)

            // Reset class trước
            row.classList.remove("answer-correct", "answer-wrong");

            // Đáp án đúng
            if ( radio.value === correctAnswerID) {
                row.classList.add("answer-correct");
            }

            // Nếu người dùng chọn sai đáp án
            if (!isCorrect && selectedAnswerID != null && parseInt(answerID) === selectedAnswerID) {
                row.classList.add("answer-wrong");
            }
        });

        // Đổi màu chỉ số câu hỏi
        const indexBox = questionBtn.querySelector(".index-question");
        if (indexBox) {
            indexBox.classList.remove("selected-question", "testimonial-item", "correct", "incorrect");
            indexBox.classList.add(isCorrect ? "correct" : "incorrect");
        }
    });
}


    //hàm hiển thị câu hỏi
    function updateAnswerDisplay(buttonElement) {
        const labels = ["A", "B", "C", "D"];

        labels.forEach((label) => {
            const name = buttonElement.dataset[`${label.toLowerCase()}Name`];
            const answerText = document.getElementById(`answer${label}`);
            const answerRow = document.getElementById(`answer-row-${label}`);

            if (name && name.trim() !== "") {
                answerText.innerText = `${label} : ${name}`;
                answerRow.style.display = "flex";
                answerRow.classList.remove("hidden-question");
            } else {
                answerText.innerText = "";
                answerRow.classList.add("hidden-question");
            }
        });
    }
    function updateQuestionDisplay(buttonElement) {
        const numberQS = buttonElement.dataset.question;
        const contentQS = buttonElement.dataset.content;
        title.innerText = `Câu ${numberQS} : `;
        content.innerText = contentQS;    
    }

    function updateValueRadio(buttonElement){
        const labels = ["A","B","C","D"]
        labels.forEach(label => {
            const answerID = buttonElement.dataset[`${label.toLowerCase()}Id`]
            const radio = document.getElementById(`radio${label}`)
            if(answerID && radio){
                radio.value = answerID
            }else{
                radio.value = ''
            }
        })
    }

    //hàm submit
    function submitExam() {
        stopCountDown();
        const submitBtnElement = document.getElementById("submit-btn");
        const endTtestBtn = document.getElementById("end-test");
        const modalElement = document.getElementById("endtestModal");
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) modal.hide();
        endTtestBtn.hidden = true;
        previewBtn.hidden = false;
        const examsetID = submitBtnElement.dataset.examsetid;
        const allAnswers = {};
        buttons.forEach((btn) => {
            const questionID = btn.dataset.id;
            if (selectedAnswer[questionID]) {
                allAnswers[questionID] = selectedAnswer[questionID];
            } else {
                allAnswers[questionID] = null;  
            }
        });
        fetch(`/practice/finish/${examsetID}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-token": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({
                answers: allAnswers,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                console.log("phan hoi", data);
                // const modal = document.getElementById("resultModal");
                // const summary = document.getElementById("modal-summary")

                allExplanation = data.result;
                const iscriticalElemet =
                    document.getElementById("modal-iscritical");
                const correctElemnt = document.getElementById("modal-correct");
                const notcorrectElement =
                    document.getElementById("modal-notCorrect");
                const previewBtnElement = document.getElementById("preview");
                const explainElement = document.getElementById("explain");
                const correctCount = data.correctCount;
                const sumQuestion = data.result[0]?.sumQuestion ?? 0;
                const notcorrect = sumQuestion - correctCount;
                const iscritical = data.iscriticalWrong;

                correctElemnt.innerHTML = `
                                                                                                            <p><strong>Số câu đúng:</strong> ${correctCount}</p>
                                                                                                            `;
                notcorrectElement.innerHTML = `
                                                                                                                <p><strong>Số câu sai:</strong>   ${notcorrect}</p>
                                                                                                            `;
                if (iscritical == true) {
                    iscriticalElemet.innerHTML = `
                                                                                                                <p><strong>Kết quả:</strong>  Không đạt - sai câu điểm liệt</p>
                                                                                                            `;
                } else if (iscritical == false && correctCount < 21) {
                    iscriticalElemet.innerHTML = `
                                                                                                            <p><strong>Kết quả:</strong>  không đạt - yêu cầu tối thiểu đúng 21/25 câu</p>
                                                                                                            `;
                } else if (iscritical == false && correctCount >= 21) {
                    iscriticalElemet.innerHTML = `
                                                                                                            <p><strong>Kết quả:</strong>  đạt</strong></p>
                                                                                                            `;
                }
                $("#modalResults").modal("show");
                previewBtn.addEventListener("click", function () {
                    $("#modalResults").modal("show");
                });
                const currentID = getCurrentQuestion().id;
                if (currentID) {
                    showExplanation(currentID, allExplanation);
                }
                changeColorResult(data.result);
                document
                    .querySelectorAll('input[type="radio"]')
                    .forEach((radio) => {
                        radio.disabled = true;
                    });
            });
    }

    //end submmit

    //obj lưu đáp ấn
    const selectedAnswer = {};
    document.querySelectorAll('input[name="answer"]').forEach((radio) => {
        radio.addEventListener("change", function () {
            const activebtn = document.querySelector(".question-btn.active");
            if (activebtn) {
                const indexQuestion =
                    activebtn.querySelector(".index-question");
                if (indexQuestion) {
                    indexQuestion.classList.add("selected-question");
                    indexQuestion.classList.remove("testimonial-item");
                }
                const questionID = activebtn.dataset.id;
                const selectedLabel = this.id.replace("radio", "");
                const radio = document.getElementById(`radio${selectedLabel}`);
                const answerID = activebtn.dataset[`${selectedLabel.toLowerCase()}Id`];
                radio.value = answerID;
                selectedAnswer[questionID] = answerID;
                console.log(selectedAnswer)
               
            }
        });
    });

    buttons.forEach((btn) => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            //bỏ active khỏi tất cả
            buttons.forEach((b) => b.classList.remove("active"));
            //gán vào nút hiện tại
            this.classList.add("active");
            //cập nhật nội dung
            updateQuestionDisplay(this);
            updateAnswerDisplay(this);
            updateValueRadio(this)


            document
                .querySelectorAll('input[name="answer"]')
                .forEach((radio) => {
                    radio.checked = false;
                    const questionID = this.dataset.id;

                    if (radio.value === selectedAnswer[questionID]) {
                        radio.checked = true;
                    }
                });
                 
            const currentID = getCurrentQuestion().id;
            if (currentID) {
                console.log(
                    "exxplan" + JSON.stringify(allExplanation, null, 2)
                );
                console.log("id hien tai" + currentID);
                showExplanation(currentID, allExplanation);
            }
        });
    });
    nextBtn.addEventListener("click", function () {
        // Tìm nút đang active
        let activeIndex = Array.from(buttons).findIndex((btn) =>
            btn.classList.contains("active")
        );
        // Tính nút kế tiếp
        if (activeIndex === -1) {
            buttons[0].classList.add("active");
            updateQuestionDisplay(buttons[0]);
            updateAnswerDisplay(buttons[0]);
            return;
        }
        let nextIndex = (activeIndex + 1) % buttons.length; // nếu hết thì quay lại 0
        buttons[activeIndex].classList.remove("active");
        buttons[nextIndex].classList.add("active");

        // Cập nhật nội dung câu hỏi tiếp theo
        const nextbuttons = buttons[nextIndex];
        const number = buttons[nextIndex].dataset.question;
        const text = buttons[nextIndex].dataset.content;
        title.innerText = `Câu ${number}`;
        content.innerText = text;
        updateQuestionDisplay(nextbuttons);
        updateAnswerDisplay(nextbuttons);
        console.log(selectedAnswer);
            updateValueRadio(nextbuttons)

        document.querySelectorAll('input[name="answer"]').forEach((radio) => {
            radio.checked = false;
            const questionID = nextbuttons.dataset.id;
            console.log(radio.value, selectedAnswer[questionID]);
            if (radio.value === selectedAnswer[questionID]) {
                radio.checked = true;
            }
        });
        const currentID = getCurrentQuestion().id;
        if (currentID) {
            console.log("exxplan" + JSON.stringify(allExplanation, null, 2));
            console.log("id hien tai" + currentID);
            showExplanation(currentID, allExplanation);
        }
    });
    if (buttons.length > 0) {
        buttons[0].classList.add("active");
        updateQuestionDisplay(buttons[0]);
        updateAnswerDisplay(buttons[0]);
    }
    const submitBtn = document.getElementById("submit-btn");
    const previewBtn = document.getElementById("preview");

    if (submitBtn) {
        submitBtn.addEventListener("click", function (e) {
            e.preventDefault();
            submitExam(this);
        });
    }
});
