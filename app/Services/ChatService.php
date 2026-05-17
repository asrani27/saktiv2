<?php

namespace App\Services;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ChatService
{
    private string $apiKey;
    private string $model;
    private float $temperature;
    private int $maxTokens;

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY', '');

        $this->model = env('OPENAI_MODEL', 'gpt-5.1');
        $this->temperature = (float) env('OPENAI_TEMPERATURE', 0.7);
        $this->maxTokens = (int) env('OPENAI_MAX_TOKENS', 2000);
    }

    /**
     * Send a message and get a response from OpenAI
     * Supports file upload (images and PDFs)
     */
    public function sendMessage(ChatConversation $conversation, ?string $userMessage, ?array $fileData = null): array
    {
        // Build message content
        $messageContent = $userMessage ?? '';

        // Add user message to conversation with file info
        $userMsg = ChatMessage::create([
            'conversation_id' => $conversation->id ?? null,
            'user_id' => auth()->id(),
            'role' => 'user',
            'content' => $messageContent,
            'file_path' => $fileData['path'] ?? null,
            'file_name' => $fileData['name'] ?? null,
            'file_type' => $fileData['type'] ?? null,
            'file_size' => $fileData['size'] ?? null,
        ]);

        // Update conversation title if it's the first message
        if ($conversation->messages()->count() === 1) {
            $title = $userMessage ?? ($fileData['name'] ?? 'New Chat');
            $conversation->update([
                'title' => substr($title, 0, 50) . (strlen($title) > 50 ? '...' : '')
            ]);
        }

        // Prepare messages for OpenAI
        $messages = $this->prepareMessages($conversation);

        try {
            $response = $this->callOpenAI($messages);
            $assistantContent = $response['choices'][0]['message']['content'] ?? 'Maaf, saya tidak dapat menjawab saat ini.';

            // Save assistant response
            $assistantMsg = ChatMessage::create([
                'conversation_id' => $conversation->id,
                'user_id' => auth()->id(),
                'role' => 'assistant',
                'content' => $assistantContent,
            ]);

            return [
                'success' => true,
                'user_message' => $userMsg,
                'assistant_message' => $assistantMsg,
            ];
        } catch (\Exception $e) {
            Log::error('OpenAI API Error: ' . $e->getMessage());

            return [
                'success' => false,
                'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'user_message' => $userMsg,
            ];
        }
    }

    /**
     * Prepare messages for OpenAI API
     * Handles both text and image content
     */
    private function prepareMessages(ChatConversation $conversation): array
    {
        $systemMessage = [
            'role' => 'system',
            'content' => 'Kamu adalah asisten AI yang helpful, friendly, dan informatif. Jika pengguna mengirim gambar atau PDF, analisis file tersebut dengan baik dan berikan respons yang detail. Gunakan Bahasa Indonesia untuk respons. JANGAN gunakan format Markdown seperti **bold**, *italic*, atau markdown formatting lainnya. Langsung tulis teks biasa saja.',
        ];

        $messages = [$systemMessage];

        foreach ($conversation->messages as $message) {
            if ($message->file_path && $message->role === 'user') {
                // Message with file attachment
                $content = [];

                if (!empty($message->content)) {
                    $content[] = [
                        'type' => 'text',
                        'text' => $message->content,
                    ];
                }

                // Add file content
                $fileContent = $this->getFileContentForAPI($message->file_path, $message->file_type);
                if ($fileContent) {
                    $content[] = $fileContent;
                }

                $messages[] = [
                    'role' => 'user',
                    'content' => $content,
                ];
            } else {
                // Regular text message
                $messages[] = [
                    'role' => $message->role,
                    'content' => $message->content,
                ];
            }
        }

        return $messages;
    }

    /**
     * Get file content for OpenAI API
     * Supports images and PDFs using base64 encoding
     */
    private function getFileContentForAPI(string $filePath, ?string $mimeType): ?array
    {
        try {
            $fullPath = Storage::disk('public')->path($filePath);

            if (!file_exists($fullPath)) {
                Log::warning("File not found: {$fullPath}");
                return null;
            }

            // Handle images
            if ($mimeType && str_starts_with($mimeType, 'image/')) {
                $imageData = base64_encode(file_get_contents($fullPath));
                $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
                $mimeTypeMap = [
                    'jpg' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'webp' => 'image/webp',
                ];
                $apiMimeType = $mimeTypeMap[$extension] ?? $mimeType;

                return [
                    'type' => 'image_url',
                    'image_url' => [
                        'url' => "data:{$apiMimeType};base64,{$imageData}",
                        'detail' => 'high',
                    ],
                ];
            }

            // Handle PDFs - encode as text for vision API
            if ($mimeType === 'application/pdf') {
                $pdfContent = file_get_contents($fullPath);
                $base64Pdf = base64_encode($pdfContent);
                $filename = basename($fullPath);

                // For PDFs, we include it as part of the message content
                return [
                    'type' => 'text',
                    'text' => "[PDF File: {$filename} - Base64 encoded content available]",
                ];
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Error reading file for API: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Call OpenAI API
     */
    private function callOpenAI(array $messages): array
    {
        $body = [
            'model' => $this->model,
            'messages' => $messages,
            'temperature' => $this->temperature,
            'max_completion_tokens' => $this->maxTokens,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->timeout(120)->post('https://api.openai.com/v1/chat/completions', $body);

        if (!$response->successful()) {
            $error = $response->json();
            throw new \Exception($error['error']['message'] ?? 'API request failed');
        }

        return $response->json();
    }

    /**
     * Check if API key is configured
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey);
    }
}
