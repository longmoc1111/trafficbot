const messageInput = document.querySelector(".message-input");
const chatBody = document.querySelector(".chat-body");
const senMessageBtn = document.querySelector("#send-message");
const fileInput = document.querySelector("#file-input");
const chatbotToggler = document.querySelector("#chatbot-toggler");
const closeChatbot = document.querySelector("#close-chatbot");

//tạo 1 đối tượng để lưu tin nhắn
const userData = {
    message: null,
    file: {
        data: null,
        mime_type: null,
    },
    pdfs: [],
    signages: null,
};
let chat;

const generateBotResponse = async (commingMessageDiv) => {
    const messageElement = commingMessageDiv.querySelector(".message-text");

    // Lấy file PDF và biển báo từ frontend (nếu có)
    // const pdfPaths = window.pdfs.map(
    //     (pdf) => `../assets/chatbot/data/${pdf.file}`
    // );
    // userData.pdfs = await Promise.all(
    //     pdfPaths.map((path) => loadPdfFile(path))
    // );
    // userData.signages = window.signagesData || [];

    try {
        // Kiểm tra input
        if (!userData.message || userData.message.trim() === "") {
            console.warn("Không có nội dung để gửi.");
            return;
        }

        // Gửi nội dung về Laravel backend (sử dụng route POST /chatbot/send)
        const result = await fetch("/chatbot/send", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({
                message: userData.message,
                // pdfs: userData.pdfs,
                // signages: userData.signages,
            }),
        });

        const data = await result.json();
        console.log(data);

        const apiResponse = data.reply || data.error || "Không có phản hồi.";

        let formatted = apiResponse
            .replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>")
            .split("\n\n")
            .map((paragraph) => `<p>${paragraph.replace(/\n/g, "<br>")}</p>`)
            .join("");
        messageElement.innerHTML = `<div class="model">${formatted}</div>`;
    } catch (error) {
        console.error("Lỗi khi gửi yêu cầu:", error);
        messageElement.innerText = "Không thể gửi phản hồi ngay lúc này!";
        messageElement.style.color = "#ff0000";
    } finally {
        commingMessageDiv.classList.remove("thinking");
        chatBody.scroll({ top: chatBody.scrollHeight, behavior: "smooth" });
    }
};

// tạo hàm thành phần tin nhắn bên trong là content và class
const createMessageElemnt = (content, ...classes) => {
    //tạo 1 div chứa nội dung tin nhắn
    const div = document.createElement("div");
    //thêm class message và class bổ sung(user-message or model message)
    div.classList.add("message", ...classes);
    //gán nội dung bằng inner
    div.innerHTML = content;
    //trả về di v
    return div;
};

//tạo hàm xử lý tin nhắn
const handleOutgoingMessage = (e) => {
    e.preventDefault();
    userData.message = messageInput.value.trim();
    console.log(userData.message);
    messageInput.value = "";
    //tạo nội dung tin nhắn bọc
    const messageContent = `<div class="message-text">${userData.message}</div>`;
    // ${
    //   userData.file.data
    //     ? `<img src = "data:${userData.file.mime_type};base64, ${userData.file.data}" /> `
    //     : ""
    // }`;
    //gọi hàm createElement để tạo phần tử div
    const outGoingMessageDiv = createMessageElemnt(
        messageContent,
        "user-message"
    );
    //gán nội dung thuần thông qua thuộc tính .textContent
    outGoingMessageDiv.querySelector(".message-text").textContent =
        userData.message;
    //thêm thành phần tin nhắn này vào khối chatBody
    chatBody.appendChild(outGoingMessageDiv);
    setTimeout(() => {
        const messageContent = `<svg class="bot-avatar" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 1024 1024">
            <path
              d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z"/></svg>
          <div class="message-text">
            <div class="thinking-indicator">
              <div class="dot"></div>
              <div class="dot"></div>
              <div class="dot"></div>
            </div>
          </div>`;
        //gọi hàm createElement để tạo phần tử div
        const commingMessageDiv = createMessageElemnt(
            messageContent,
            "bot-message",
            "thinking"
        );
        //thêm thành phần tin nhắn này vào khối chatBody
        chatBody.appendChild(commingMessageDiv);
        chatBody.scroll({ top: chatBody.scrollHeight, behavior: "smooth" });
        generateBotResponse(commingMessageDiv);
    }, 600);
};
//tạo sự kiện enter với phần tử texra
messageInput.addEventListener("keydown", (e) => {
    const userMessage = e.target.value.trim();
    if (e.key === "Enter" && userMessage) {
        //gọi hàm xử lý tin nhắn
        handleOutgoingMessage(e);
    }
});


const picker = new EmojiMart.Picker({
    theme: "light",
    skinTonePosition: "none",
    previewPosition: "none",
    onEmojiSelect: (emoji) => {
        const { selectionStart: start, selectionEnd: end } = messageInput;
        messageInput.setRangeText(emoji.native, start, end, "end");
        messageInput.focus();
    },
    onClickOutside: (e) => {
        if (e.target.id === "emoji-picker") {
            document
                .querySelector(".chatbot")
                .classList.toggle("show-emoji-picker");
        } else {
            document
                .querySelector(".chatbot")
                .classList.remove("show-emoji-picker");
        }
    },
});
document.querySelector(".chat-form").appendChild(picker);

//tạo sự kiện lắng nghe (click) cho button
senMessageBtn.addEventListener("click", (e) => handleOutgoingMessage(e));
//tạo sự kiện lắng nghe file-upload
// document.querySelector("#file-upload").addEventListener("click", () => fileInput.click());

chatbotToggler.addEventListener("click", () =>
    document.querySelector(".chatbot").classList.toggle("show-chatbot")
);
closeChatbot.addEventListener("click", () =>
    document.querySelector(".chatbot").classList.remove("show-chatbot")
);
