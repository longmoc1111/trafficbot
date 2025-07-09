<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Http;
use Storage;
use Str;
use Illuminate\Support\Facades\Session;
use App\Models\ChatBot;
class AIchatController extends Controller
{

    public function sendMessage(Request $request)
    {
        $dataURL = [];
        // $Pdfs = Chatbot::whereHas("category_Chatbot", function($query){
        //     $query->where("CategoryName", "PDF");
        // })->get();
        // foreach($Pdfs as $pdf){

        // }
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

                    $response = Http::get("http://localhost:3000/crawl", [
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

            1. Nếu người dùng chào (ví dụ: "Chào bạn", "Hi", "Có ai không"):
            → Chỉ cần chào lại ngắn gọn, **duy nhất 1 lần đầu tiên**, ví dụ:
            → *"Chào bạn 👋 Mình có thể giúp gì về luật giao thông hôm nay?"*
            → *"Chào bạn, Mình có thể hổ trợ gì cho bạn"*
            → hay thay đổi liên tục các câu chào k nhất thiết phải theo mẫu ví dụ trên.

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
            
            6. khi người dùng cảm ơn hay nhưng câu kết thúc cuộc hội thoại (ví dụ như: ok, được, tốt...) hãy phản hồi một cách thân thiện. 
            ---

            **Thông tin văn bản pháp lý từ hệ thống:**
            $textFromWeb

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
    private function Pdfcontent($fileName){
        $filePath = "filePDF/".$fileName;
        if(!Storage::disk("public")->exists($filePath)){
            \Log::warning("File PDF không tồn tại");
            return null;
        }
        try{
            $binary = Storage::disk("public")->get($filePath);
            return [
                "data" => base64_encode($binary),
            ];      
        }catch(Exception $e){
            \Log::error("lỗi khi đọc PDF",["message"=>$e->getMessage()]);
            return null;
        }
    }
}