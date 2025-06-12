const API_KEY = "AIzaSyBKsenBMOobTmmlEAAcfxHuO56MlmRd9Mk";
import { GoogleGenAI } from "@google/genai";

const ai = new GoogleGenAI({ apiKey: API_KEY });

let chat;

let file;
async function startChat() {
  const response = await fetch("../assets/chatbot/infomation.pdf"); // Đường dẫn đến file PDF trong public/
  const arrayBuffer = await response.arrayBuffer();
  const base64Data = btoa(String.fromCharCode(...new Uint8Array(arrayBuffer)));
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
        .insertAdjacentHTML("beforeend", `  <div class = "loader"></div>`);

      // Gửi câu hỏi kèm nội dung dữ liệu
      const contents = [
        {
          text: `
Bạn là trợ lý thân thiện, giúp người dùng hiểu rõ về thông tin của Trung Tâm Học Luật Giao Thông Đường Bộ.
Hãy đọc file PDF được cung cấp dưới đây và trả lời câu hỏi sau ngắn gọn, tự nhiên.

Câu hỏi: "${userMessage}"
          `,
        },
        {
          inlineData: {
            mimeType: "application/pdf",
            data: file,
          },
        },
      ];
      const response = await chat.sendMessage({ message: contents });
      const reply = response.text;
      document
        .querySelector(".chat-window .chat")
        .insertAdjacentHTML(
          "beforeend",
          `<div class="model"><p>${reply}</p></div>`
        );

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
document
  .querySelector(".chat-button")
  .addEventListener("click", () => {
    document.querySelector(".chat-bot").classList.add("chat-open")
  });

  document
  .querySelector(".chat-window button.close")
  .addEventListener("click", () => {
    document.querySelector(".chat-bot").classList.remove("chat-open")
  });