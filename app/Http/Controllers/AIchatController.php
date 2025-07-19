<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Http;
use Laravel\Pail\ValueObjects\Origin\Console;
use Storage;
use Str;
use Illuminate\Support\Facades\Session;
use App\Models\ChatBot;
use Smalot\PdfParser\Parser;
use App\Models\Question;
class AIchatController extends Controller
{

    public function sendMessage(Request $request)
    {
        $dataURL = [];
        $chatHistory = [];
        $pdfContent = "";
        $dataQuestions = "";

        $total = Question::count();
        $limit = ceil($total / 6);
        $questions = Question::take($limit)->get();
        foreach ($questions as $index => $question) {
            $dataQuestions .= "câu " . ($index + 1) . ":" . $question->QuestionName . "\n";
            $answers = $question->answer_Question;
            $labelCorrect = "";
            foreach ($answers as $answer) {
                $dataQuestions .= $answer->AnswerLabel . ": " . $answer->AnswerName . "\n";
                if ($answer->IsCorrect == true) {
                    $labelCorrect = $answer->AnswerLabel;
                }
            }
            $dataQuestions .= "đáp án đúng là: " . $labelCorrect . "\n" . "Giải thích: " . $question->QuestionExplain . "\n\n";

        }
       


        $Pdfs = Chatbot::whereHas("category_Chatbot", function ($query) {
            $query->where("CategoryName", "PDF");
        })->get();
        $Urls = ChatBot::whereHas("category_Chatbot", function ($query) {
            $query->where("CategoryName", "URL");
        })->get();

        try {
            $contents = '';
            $textFromWeb = '';
            //duyệt url để lấy name và file
            $textFromWeb = $this->GetContentFromURL($Urls);
            $pdfContent = $this->getContentPDF($Pdfs);
            $userMessage = $request->input('message', 'Giải thích nội dung.');
            // Chuẩn bị prompt
            $prompt = $this->buildPrompt($userMessage, $textFromWeb, $pdfContent, $dataQuestions);
            foreach (Session::get("chat_history", []) as $item) {
                $chatHistory[] = [
                    "role" => "user",
                    "parts" => [["text" => $item["user"]]]
                ];
                $chatHistory[] = [
                    "role" => "model",
                    "parts" => [["text" => $item["model"]]]
                ];
            }
            //chuan bị noi dung
            $contents = $this->buildContent($chatHistory, $prompt);
            //Gọi Gemini API
            // $apiKey = env('GEMINI_API_KEY');
            // $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent";

            $geminiResponse = $this->callGeminiApi($contents);

            $reply = $this->processResponse($geminiResponse);

            $history = $this->UpdateChatHistory($userMessage, $reply);
            return response()->json(['reply' => $reply]);
        } catch (\Throwable $e) {
            \Log::error('sendMessage Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'error' => 'Lỗi nội bộ server.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    private function GetContentFromURL(Collection $Urls): string
    {
        $textFormWeb = "";
        foreach ($Urls as $url) {
            if ($url->Content === null) {
                $urlToget = $url->LinkURL;
                $selector = $url->SelectorURL;

                if (!filter_var($urlToget, FILTER_VALIDATE_URL)) {
                    continue;
                }
                $response = Http::get("https://node-crawler-gw8b.onrender.com/scrape", [
                    "url" => $urlToget,
                    "selector" => $selector
                ]);
                if ($response->successful()) {
                    $content = $response->json("content");
                    $textFormWeb .= trim($content) . "\n\n";

                    ChatBot::find($url->ChatbotID)?->update([
                        "content" => $content
                    ]);
                }
            } else {
                $textFormWeb .= $url->Content;
            }
        }
        return $textFormWeb;
    }

    private function getContentPDF(Collection $pdfs): string
    {
        $contentPDF = "";
        foreach ($pdfs as $pdf) {
            $content = $this->Pdfcontent($pdf->File);
            if ($content) {
                $contentPDF .= trim($content["data"]) . "\n\n";
            }
        }
        return $contentPDF;
    }
    // Chuẩn bị prompt
    private function buildPrompt($userMessage, $textFromWeb, $pdfContent, $dataQuestions): string
    {
        return <<<PROMPT
            Bạn là trafficbot một trợ lý ảo thân thiện, được tích hợp trên website cung cấp thông tin về **Luật Giao thông Đường bộ Việt Nam**.

            **Nhiệm vụ của bạn**:
            - Giải thích luật rõ ràng, chính xác, dễ hiểu cho người dân.
            - Trả lời ngắn gọn, đúng trọng tâm, tránh lặp lại nội dung nguồn.

            **Hướng dẫn trả lời**:

            1. Khi người dùng gửi lời chào (ví dụ: "Chào bạn", "Hi", "Có ai không"):
            → Chỉ cần chào lại ngắn gọn, **duy nhất 1 lần đầu tiên**,
            -  khi người dùng đi thằng vào câu hỏi không liên quan đến việc chào hỏi 
            → hãy chào một cách ngắn gọn nhất và đi thẳng vào vấn đề câu hỏi

            2. Nếu người dùng hỏi thẳng về luật:
            → Bỏ qua phần chào, **đi thẳng vào trả lời**.

            3. Trả lời ngắn gọn, rõ ràng:
            - Dùng gạch đầu dòng nếu cần chia ý.
            - Hạn chế lặp lại toàn bộ văn bản luật.
            - Không cần dẫn lại nguồn, không dùng “dưới đây là…” hay “theo bạn cung cấp…”.

            4. Nếu câu hỏi liên quan đến **xử phạt, điểm bằng lái**:
            - Ghi rõ mức phạt theo từng loại phương tiện.
            - Nếu có mức phạt cao hơn khi gây tai nạn, cần phân biệt rõ.

            5. Không phán xét người dùng:
            - Không nói “Bạn đã vi phạm”, thay vào đó: “Hành vi này bị xem là vi phạm theo quy định hiện hành…”
            
            6. Khi người dùng cảm ơn hay nói những câu kết thúc cuộc hội thoại (ví dụ: "ok", "được", "tốt", "cảm ơn", "tạm biệt", "bye", "thế nhé"...), hãy phản hồi một cách thân thiện và gần gũi, dưới đây là một số ví dụ và hãy thay theo ngữ cảnh:

            → *"Cảm ơn bạn đã trò chuyện! Chúc bạn lái xe an toàn nhé 🚗💨"*

            → *"Rất vui được hỗ trợ bạn. Hẹn gặp lại! 👋"*

            → *"OK, nếu cần hỗ trợ thêm, cứ nhắn mình nhé!"*

            → *"Tạm biệt nhé, mình luôn sẵn sàng nếu bạn cần!"*

            → *"Chúc bạn một ngày tốt lành! Có thắc mắc gì cứ quay lại hỏi nhé 😊"*

            ---


            7. trả lời các câu  hỏi liên quan đến mẹo ôn thi giấy phép
            - Chỉ chia sẻ **một phần các mẹo thông dụng**, gợi ý người học nên đọc luật kỹ để hiểu rõ.
            - Nếu có thể, chia nội dung bằng các dấu gạch đầu dòng để người đọc dễ nhớ.
            - chia sẽ 3 đến 4 mẹo và nếu người dùng muốn biết thêm thì hãy cho người dùng biết.
            ---
            **Lưu ý trong prompt**:
            - Không dùng từ như "chọn luôn" một cách cứng nhắc.
            - Không liệt kê hết tất cả các mẹo để tránh dài và khô cứng.
            - Nên khuyến khích người học đọc luật.

            8. Không được phép lấy các nguồn thông tin bên ngoài, chỉ được lấy thông tin từ các nguồn mà tôi đã cung cấp dưới đây để tránh gây sai lệch về thông tin
            
            9 Khi tôi cung cấp một câu hỏi và các đáp án, bạn hãy:
            - Xác định đáp án đúng.
            - Viết câu trả lời một cách rõ ràng, thân thiện, giống như đang hướng dẫn người học.
            - Tránh trả lời khô khan hoặc chỉ nói "Đáp án đúng là C".

            **các nguồn thông tin từ hệ thống:**
            $textFromWeb
            
            **Nguồn thông tin từ PDF**
            $pdfContent
            ---

            **Nguồn thông tin về các câu hỏi về luật giao thông đường bộ**
            $dataQuestions

             **Câu hỏi của người dùng**: "$userMessage"

            ---

             Hãy trả lời như một chuyên gia luật giao thông, **trực tiếp – dễ hiểu – đúng trọng tâm**:
            PROMPT;

    }
    private function Pdfcontent($fileName)
    {
        $filePath = storage_path("app/public/filePDF/" . $fileName);
        if (!file_exists($filePath)) {
            return null;
        }
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($filePath);
            $content = $pdf->getText();
            return [
                "data" => $content,
            ];
        } catch (Exception $e) {
            return null;
        }
    }

    function buildContent($chatHistory, $prompt)
    {
        return array_merge($chatHistory, [
            [
                "role" => "user",
                "parts" => [
                    ["text" => $prompt]
                ]
            ]
        ]);
    }
    function callGeminiApi($content)
    {
        $apiKey = env("GEMINI_API_KEY");
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent";
        return Http::withHeaders([
            "Content-Type" => "application/json",
            "X-goog-api-key" => $apiKey,
        ])->post($url, ["contents" => $content]);
    }

    function processResponse($geminiResponse)
    {
        if (!$geminiResponse->successful()) {
            \Log::error('Gemini API error', [
                'status' => $geminiResponse->status(),
                'body' => $geminiResponse->body(),
            ]);
            return response()->json([
                "error" => "Lỗi khi gọi Gemini API",
                "body" => $geminiResponse->body()
            ], 500);
        }
        $data = $geminiResponse->json();
        return data_get($data, 'candidates.0.content.parts.0.text', 'Không có phản hồi.');
    }
    function UpdateChatHistory($userMessage, $reply)
    {
        $history = Session::get("chat_history", []);
        $history[] = [
            "user" => $userMessage,
            "model" => $reply
        ];
        if (count($history) > 50) {
            $history = array_slice($history, -50);
        }
        Session::put("chat_history", $history);
        return $history;
    }
}
