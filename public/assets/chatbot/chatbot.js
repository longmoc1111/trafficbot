//lấy phần tử textra có class là message-input
const API_KEY = "AIzaSyBKsenBMOobTmmlEAAcfxHuO56MlmRd9Mk";
import { GoogleGenAI } from "@google/genai";
const messageInput = document.querySelector(".message-input");
const chatBody = document.querySelector(".chat-body");
const senMessageBtn = document.querySelector("#send-message");
const fileInput = document.querySelector("#file-input");
const chatbotToggler = document.querySelector("#chatbot-toggler");
const closeChatbot = document.querySelector("#close-chatbot");

const ai = new GoogleGenAI({ apiKey: API_KEY });

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
const startChat = async () => {
    chat = ai.chats.create({
        model: "gemini-2.0-flash",
        history: [],
    });
};
await startChat();

const generateBotResponse = async (commingMessageDiv) => {
    console.log(chat.history)
    const messageElement = commingMessageDiv.querySelector(".message-text");
    const pdfPaths = window.pdfs.map(
        (pdf) => `../assets/chatbot/data/${pdf.file}`
    );
    userData.pdfs = await Promise.all(
        pdfPaths.map((path) => loadPdfFile(path))
    );
    userData.signages = window.signagesData || [];
    // const pdfPath = window.pdfs.map(pdf => `../assets/chatbot/${$pdf.file}`);
    try {
        if (!userData.message || userData.message.trim() === "") {
            console.warn("không có nội dung để gửi");
            return;
        }
        if (!chat) {
            console.warn("chưa khởi tạo phiên chat");
            return;
        }
        const parts = [
            {
                text: `
Bạn là trafficBot một trợ lý thân thiện, giúp người dùng hiểu rõ về luật giao thông đường bộ.
Đối với các câu trả lời hãy thêm phần chủ ngữ.
Hãy trả lời câu hỏi sau ngắn gọn, tự nhiên. Không được nhắc đến các cụm từ như theo đoạn văn cung cấp, hay theo văn bản cung cấp hay theo đoạn văn bản.
nếu được yêu câu gửi ảnh thì sẽ chấm hết câu và chỉ hiển thị tên ảnh ở cuối và không hiển thị ảnh mô tả hay title về mô tả ảnh.
đối với câu hỏi chung chung hay giải thích ngắn gọn nhất và không cần thiết phải đưa ra ảnh mô tả nếu người hỏi không hỏi.
nếu người dùng hỏi về ảnh mô tả hãy đưa ra một vidu về nó, không được tạo bất kỳ ảnh nào mà không có trong tài liệu.
đối với các câu hỏi liên quan đến kinh nghiệm thi hay mẹo thi không đưa ra bất kỳ ảnh hinh họa hay mô tả nào.


Câu hỏi: "${userData.message}" `,
            },
            ...userData.pdfs.map((pdf) => ({
                inlineData: {
                    mimeType: "application/pdf",
                    data: pdf,
                },
            })),
            ...userData.signages.map((item) => ({
                text: `Biển báo:${item.SignageName} - giải thích: ${item.SignagesExplanation} -  ảnh mô tả: ${item.SignageImage} `,
            })),
        ];
        const result = await chat.sendMessage({ message: parts });
        const apiReponse = result.text?.trim() || "";
        messageElement.innerText = ""; // Clear để thay thế bằng nội dung có xử lý

        if (apiReponse) {
            const lines = apiReponse
                .split(/\n|\*/)
                .map((line) => line.trim())
                .filter((line) => line);

            for (const line of lines) {
                // Kiểm tra nếu dòng chỉ là danh sách ảnh
                if (
                    /^([^\s]+\.(jpg|png|jpeg|gif))(,\s*[^\s]+\.(jpg|png|jpeg|gif))*$/i.test(
                        line
                    )
                ) {
                    const imageNames = line
                        .split(",")
                        .map((name) => name.trim());
                    for (const imageName of imageNames) {
                        if (imageName) {
                            messageElement.insertAdjacentHTML(
                                "beforeend",
                                `<div class="model">
                            <p>Hình ảnh minh hoạ:</p>
                            <img src="/assets/adminPage/SignagesImage/${imageName}" alt="${imageName}" style="max-width: 150px;" />
                        </div>`
                            );
                        }
                    }
                } else {
                    // Nếu là dòng có mô tả + ảnh mô tả theo định dạng đầy đủ
                    const signageMatch = line.match(
                        /^Biển báo:\s*(.+?)\s+giải thích:\s*(.+?)\s+ảnh mô tả:\s*([^\s]+)$/i
                    );
                    if (signageMatch) {
                        const signageName = signageMatch[1].trim();
                        const explanation = signageMatch[2].trim();
                        const imageName = signageMatch[3].trim();

                        messageElement.insertAdjacentHTML(
                            "beforeend",
                            `<div class="model">
                        <p><strong>${signageName}</strong>: ${explanation}</p>
                        <img src="/assets/adminPage/SignagesImage/${imageName}" alt="${signageName}" style="max-width: 150px; display: block; margin: 10px auto;" />
                    </div>`
                        );
                    } else {
                        // Nếu dòng có mô tả và có thể có ảnh ở cuối
                        const match = line.match(
                            /(.+?)\s+([^\s]+\.(jpg|png|jpeg|gif))$/i
                        );
                        let contentText = line;
                        let imageName = null;
                        if (match) {
                            contentText = match[1].trim();
                            imageName = match[2].trim();
                        }

                        // Nếu có nội dung thực sự thì mới tạo
                        if (contentText || imageName) {
                            messageElement.insertAdjacentHTML(
                                "beforeend",
                                `<div class="model">
                                  <p>${contentText}</p>
                                  ${
                                      imageName
                                          ? `<img src="/assets/adminPage/SignagesImage/${imageName}" alt="${imageName}" style="max-width: 150px;" />`
                                          : ""
                                  }
                              </div>`
                            );
                        }
                    }
                }
            }
        }
        chat.history.push({
            role: "user",
            parts: [{ text: userData.message }],
        });
        chat.history.push({
            role: "model",
            parts: [{ text: apiReponse }],
        });
    } catch (error) {
        messageElement.innerText = "Không thể gửi phản hồi ngay lúc này !";
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

const loadPdfFile = async (pdfPath) => {
    try {
        const response = await fetch(pdfPath);
        const blob = await response.blob();

        return await new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onloadend = () => resolve(reader.result.split(",")[1]); // Lấy phần base64
            reader.onerror = reject;
            reader.readAsDataURL(blob);
        });
    } catch (error) {
        console.error("Failed to load PDF:", pdfPath, error);
    }
};

// fileInput.addEventListener("change", () => {
//   const file = fileInput.files[0];
//   if (!file) {
//     return;
//   }
//   const reader = new FileReader();
//   reader.onload = (e) => {
//     const base64 = e.target.result.split(",")[1];

//     userData.file = {
//       data: base64,
//       mime_type: file.type,
//     };
//   };
//   console.log(userData.file);
//   fileInput.value = "";
//   reader.readAsDataURL(file);
// });

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
