const API_KEY = "AIzaSyBKsenBMOobTmmlEAAcfxHuO56MlmRd9Mk";
import { GoogleGenAI } from "@google/genai";

const ai = new GoogleGenAI({ apiKey: API_KEY });

let chat;

let file;
async function startChat() {
    const response = await fetch("../assets/chatbot/infomation.pdf"); // Đường dẫn đến file PDF trong public/
    const arrayBuffer = await response.arrayBuffer();
    const base64Data = btoa(
        String.fromCharCode(...new Uint8Array(arrayBuffer))
    );
    // console.log(String.fromCharCode(...new Uint8Array(arrayBuffer)))
    file = base64Data;
    // const base64pdf = await buffer.from(infopdf).tostring("base64")
    // console.log( base64pdf);
    chat = ai.chats.create({
        model: "gemini-2.0-flash",
        history: [],
        // contents : contents
        // Không cần systemInstruction nữa, sẽ truyền trực tiếp mỗi lần hỏi
    });
}

await startChat();

async function sendMessage() {
    const userMessage = document.querySelector(".chat-window input").value;
    const signagesData = window.signagesData || [];
    console.log("Dữ liệu biển báo:", window.signagesData);
    if (userMessage.length) {
        try {
            document.querySelector(".chat-window input").value = "";

            document
                .querySelector(".chat-window .chat")
                .insertAdjacentHTML(
                    "beforeend",
                    `<div class="user"><p>${userMessage}</p></div>`
                );
            document
                .querySelector(".chat-window .chat")
                .insertAdjacentHTML(
                    "beforeend",
                    `  <div class = "loader"></div>`
                );

            // Gửi câu hỏi kèm nội dung dữ liệu
            const contents = [
                {
                    text: `
Bạn là trafficBot một trợ lý thân thiện, giúp người dùng hiểu rõ về luật giao thông đường bộ.
Đối với các câu trả lời hãy thêm phần chủ ngữ
Hãy đọc file PDF được cung cấp dưới đây và trả lời câu hỏi sau ngắn gọn, tự nhiên, không được nhắc đến các cụm từ như theo đoạn văn cung cấp, hay theo văn bản cung cấp hay theo đoạn văn bản.
nếu được yêu câu gửi ảnh thì sẽ chấm hết câu và chỉ hiển thị tên ảnh ở cuối và không hiển thị ảnh mô tả hay title về mô tả ảnh

Câu hỏi: "${userMessage}"
          `,
                },
                {
                    inlineData: {
                        mimeType: "application/pdf",
                        data: file,
                    },
                },
                ...signagesData.map((item) => ({
                    text: `Biển báo:${item.SignageName} giải thích: ${item.SignagesExplanation} ảnh mô tả: ${item.SignageImage} `,
                })),
            ];
            const response = await chat.sendMessage({ message: contents });
            const reply = response.text;
            const lines = reply
                .split(/\n|\*/)
                .map((line) => line.trim())
                .filter((line) => line);

            for (const line of lines) {
                if (
                    line.match(
                        /^([^\s]+\.(jpg|png|jpeg|gif))(,\s*[^\s]+\.(jpg|png|jpeg|gif))*$/i
                    )
                ) {
                    const imageNames = line
                        .split(",")
                        .map((name) => name.trim());
                    for (const imageName of imageNames) {
                        document
                            .querySelector(".chat-window .chat")
                            .insertAdjacentHTML(
                                "beforeend",
                                `<div class="model">
                    <p>Hình ảnh minh hoạ:</p>
                    <img src="/assets/adminPage/SignagesImage/${imageName}" alt="${imageName}" style="max-width: 150px;" />
                </div>`
                            );
                    }
                } else {
                    // Nếu dòng có mô tả kèm ảnh
                    const match = line.match(
                        /(.+?)\s+([^\s]+\.(jpg|png|jpeg|gif))/i
                    );
                    let contentText = line;
                    let imageName = null;
                    if (match) {
                        contentText = match[1].trim();
                        imageName = match[2].trim();
                    }

                    document
                        .querySelector(".chat-window .chat")
                        .insertAdjacentHTML(
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

            //Lưu lại lịch sử hội thoại
            chat.history.push({
                role: "user",
                parts: [{ text: userMessage }],
            });
            chat.history.push({
                role: "model",
                parts: [{ text: reply }],
            });
        } catch (error) {
            console.error("Lỗi khi gửi tin nhắn:", error);
            document
                .querySelector(".chat-window .chat")
                .insertAdjacentHTML(
                    "beforeend",
                    `<div class="error"><p>Không thể phản hồi ngay lúc này, vui lòng thử lại sau.</p></div>`
                );
        }
        document.querySelector(".chat-window .chat .loader").remove();
        console.log(chat.history);
    }
}

document
    .querySelector(".chat-window .input-area button")
    .addEventListener("click", () => sendMessage());
document.querySelector(".chat-button").addEventListener("click", () => {
    document.querySelector(".chat-bot").classList.add("chat-open");
});

document
    .querySelector(".chat-window button.close")
    .addEventListener("click", () => {
        document.querySelector(".chat-bot").classList.remove("chat-open");
    });

                    // <img src="https://bizweb.dktcdn.net/100/415/690/files/bien-canh-bao-giao-thong-9.jpg?v=1666925615160" alt="">
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
            const imageNames = line.split(",").map((name) => name.trim());
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
                const match = line.match(/(.+?)\s+([^\s]+\.(jpg|png|jpeg|gif))$/i);
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

// Lưu vào lịch sử (chỉ nếu có nội dung)
if (apiReponse) {
    chat.history.push({
        role: "model",
        parts: [{ text: apiReponse }],
    });
}
