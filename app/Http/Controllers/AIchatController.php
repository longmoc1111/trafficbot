<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Http;
use Str;
use Illuminate\Support\Facades\Session;
class AIchatController extends Controller
{

    public function sendMessage(Request $request)
    {
        try {
            \Log::info('sendMessage payload:', $request->all());
            $urls = [
                "https://thuvienphapluat.vn/phap-luat/ho-tro-phap-luat/muc-xu-phat-vi-pham-giao-thong-xe-may-o-to-2025-cac-loi-thuong-gap-moi-nhat-theo-nghi-dinh-168-999966-197118.html",
            ];

            $textFromWeb = '';
            foreach ($urls as $urlToScrape) {
                if (!filter_var($urlToScrape, FILTER_VALIDATE_URL)) {
                    continue;
                }

                $response = Http::get("http://localhost:3000/crawl", [
                    'url' => $urlToScrape
                ]);

                if ($response->successful()) {
                    $content = $response->json('content');
                    \Log::info("Đã lấy nội dung từ $urlToScrape");
                    $textFromWeb .= trim($content) . "\n\n";
                } else {
                    \Log::warning("Lỗi khi crawl $urlToScrape", [
                        'response' => $response->body()
                    ]);
                }
            }

            if (empty($textFromWeb)) {
                return response()->json([
                    'error' => 'Không thể lấy nội dung từ các URL đã cung cấp.'
                ], 500);
            }

            //Giới hạn độ dài
            $textFromWeb = \Str::limit($textFromWeb, 15000);

            // Chuẩn bị prompt
            $userMessage = $request->input('message', 'Giải thích nội dung.');
            $prompt = "Bạn là trợ lý thân thiên .\n\n"
                . "đây là phần thông tin được cung cấp hãy trả lời ngắn gọn và dễ hiểu:\n"
                . "không cần nhắc lại việc đây là thông tin được cũng cấp... hãy trả lời như một con người:\n"
                . "Hãy chào lại một cách thân thiện khi được chào:\n"
                . $textFromWeb . "\n\n"
                . "Câu hỏi: \"$userMessage\"";

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
                'user_message' => $userMessage,
                'ai_reply' => $reply,
            ];
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
}
