<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Http;
use Laravel\Pail\ValueObjects\Origin\Console;
use Storage;
use Str;
use Illuminate\Support\Facades\Session;
use App\Models\ChatBot;
use Smalot\PdfParser\Parser;
class AIchatController extends Controller
{

    public function sendMessage(Request $request)
    {
        $dataURL = [];
        $dataPDF = [];
        $pdfContent = "";
        $Pdfs = Chatbot::whereHas("category_Chatbot", function ($query) {
            $query->where("CategoryName", "PDF");
        })->get();
        $Urls = ChatBot::whereHas("category_Chatbot", function ($query) {
            $query->where("CategoryName", "URL");
        })->get();
        \Log::info("url", $dataURL);
        try {
            \Log::info('sendMessage:', $request->all());
            $content = '';
            $textFromWeb = '';
            foreach ($Urls as $url) {
                if ($url->Content == null) {
                    $urlToGet = $url->LinkURL;
                    $selector = $url->SelectorURL;
                    if (!filter_var($urlToGet, FILTER_VALIDATE_URL)) {
                        continue;
                    }

                    $response = Http::get("https://node-crawler-gw8b.onrender.com/scrape", [
                        'url' => $urlToGet,
                        'selector' => $selector,
                    ]);

                    if ($response->successful()) {
                        $content = $response->json('content');
                        \Log::info(" nội dung từ $urlToGet");
                        $textFromWeb .= trim($content) . "\n\n";
                        \Log::info("nội dung của văn bản" . $textFromWeb);
                    } else {
                        \Log::warning("Lỗi crawl $urlToGet", [
                            'response' => $response->body()
                        ]);
                    }
                    if (empty($textFromWeb)) {
                        return response()->json([
                            'error' => 'Không thể lấy nội dung từ các URL đã cung cấp.'
                        ], 500);
                    }
                    $ChatDocument = Chatbot::find($url->ChatbotID);
                    $ChatDocument->update([
                        "Content" => $textFromWeb,
                    ]);
                } else {
                    $content = $url->Content;
                }
            }
            foreach ($Pdfs as $pdf) {
                $pdfName = $pdf->DocumentName;
                $pdfcontent = $this->Pdfcontent($pdf->File);
                if ($pdfcontent) {
                    $pdfContent .= "**{$pdfName}**:\n" . trim($pdfcontent["data"]) . "\n\n";
                    \Log::info("Dương dan file:". $pdfContent);
                } else {
                    \Log::warning("Không tồn tại file PDF:", ["file" => $pdfName]);
                }

            }
            //Giới hạn độ dài
            $textFromWeb = \Str::limit($textFromWeb, 15000);

            // Chuẩn bị prompt
            $userMessage = $request->input('message', 'Giải thích nội dung.');
            $prompt = <<<PROMPT
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


            **các nguồn thông tin từ hệ thống:**
            $textFromWeb
            
            **Nguồn thông tin từ PDF**
            $pdfContent

            **Nguồn nội dung bổ sung (nếu có):**
            $content

            ---

             **Câu hỏi của người dùng**: "$userMessage"

            ---

            ✍️ Hãy trả lời như một chuyên gia luật giao thông, **trực tiếp – dễ hiểu – đúng trọng tâm**:
            PROMPT;



            //Gọi Gemini API
            $apiKey = env('GEMINI_API_KEY');
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent";

            $geminiResponse = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-goog-api-key' => $apiKey,
            ])->post($url, [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => $prompt],
                                ],
                            ],
                        ],
                    ]);

            if (!$geminiResponse->successful()) {
                \Log::error('Gemini API error', [
                    'status' => $geminiResponse->status(),
                    'body' => $geminiResponse->body(),
                ]);
                return response()->json([
                    'error' => 'Lỗi khi gọi Gemini API.',
                    'body' => $geminiResponse->body(),
                ], 500);
            }

            //Trả kết quả về
            $data = $geminiResponse->json();
            $reply = data_get($data, 'candidates.0.content.parts.0.text', 'Không có phản hồi.');

            $history = Session::get('chat_history', []);
            $history[] = [
                'user' => $userMessage,
                'model' => $reply,
            ];

            // Giới hạn tối đa 50 đoạn hội thoại
            if (count($history) > 50) {
                $history = array_slice($history, -50);
            }

            session()->put('chat_history', $history);
            \Log::info("Full chat history", $history);
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
    private function Pdfcontent($fileName)
    {
        \Log::info("tên file: " . $fileName);
        if (!Storage::disk("public")->exists("filePDF/".$fileName)) {
            \Log::warning("File PDF không tồn tại");
            return null;
        }
        try {
            $filePath = storage_path("app/public/filePDF/".$fileName);
            $parser = new Parser();
            $pdf = $parser->parseFile($filePath);
            $content = $pdf->getText();
            return [
                "data" => $content,
            ];
        } catch (Exception $e) {
            \Log::error("lỗi khi đọc PDF", ["message" => $e->getMessage()]);
            return null;
        }
    }
}
