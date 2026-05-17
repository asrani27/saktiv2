<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatConversation;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected ChatService $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    /**
     * Display the chat interface with all conversations
     */
    public function index(Request $request)
    {
        $conversations = ChatConversation::where('user_id', auth()->id())
            ->orderBy('updated_at', 'desc')
            ->get();

        $activeConversation = null;
        $messages = collect();

        if ($request->has('conversation')) {
            $activeConversation = ChatConversation::where('id', $request->conversation)
                ->where('user_id', auth()->id())
                ->first();
            
            if ($activeConversation) {
                $messages = $activeConversation->messages;
            }
        } else {
            // Get the most recent conversation
            $activeConversation = $conversations->first();
            if ($activeConversation) {
                $messages = $activeConversation->messages;
            }
        }

        return view('admin.chat', compact('conversations', 'activeConversation', 'messages'));
    }

    /**
     * Create a new conversation
     */
    public function createConversation()
    {
        $conversation = ChatConversation::create([
            'user_id' => auth()->id(),
            'title' => 'New Chat',
        ]);

        return redirect()->route('admin.chat', ['conversation' => $conversation->id]);
    }

    /**
     * Send a message in a conversation (supports file upload)
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string|max:5000',
            'conversation_id' => 'required|exists:chat_conversations,id',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,webp|max:10240', // max 10MB
        ]);

        // Must have either message or file
        if (empty($request->message) && !$request->hasFile('file')) {
            return response()->json([
                'success' => false,
                'error' => 'Harap isi pesan atau upload file.',
            ], 400);
        }

        $conversation = ChatConversation::where('id', $request->conversation_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (!$this->chatService->isConfigured()) {
            return response()->json([
                'success' => false,
                'error' => 'OpenAI API key belum dikonfigurasi. Silakan hubungi administrator.',
            ], 400);
        }

        // Handle file upload
        $fileData = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileData = [
                'path' => $file->store('chat-files', 'public'),
                'name' => $file->getClientOriginalName(),
                'type' => $file->getMimeType(),
                'size' => $file->getSize(),
            ];
        }

        $result = $this->chatService->sendMessage($conversation, $request->message, $fileData);

        return response()->json($result);
    }

    /**
     * Delete a conversation
     */
    public function deleteConversation(ChatConversation $conversation)
    {
        // Ensure user owns the conversation
        if ($conversation->user_id !== auth()->id()) {
            abort(403);
        }

        $conversation->delete();

        return redirect()->route('admin.chat')->with('success', 'Percakapan berhasil dihapus');
    }

    /**
     * Get messages for a conversation (AJAX)
     */
    public function getMessages(ChatConversation $conversation)
    {
        if ($conversation->user_id !== auth()->id()) {
            abort(403);
        }

        $messages = $conversation->messages;

        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }

    /**
     * Rename a conversation
     */
    public function renameConversation(Request $request, ChatConversation $conversation)
    {
        if ($conversation->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:100',
        ]);

        $conversation->update(['title' => $request->title]);

        return response()->json([
            'success' => true,
            'title' => $conversation->title,
        ]);
    }
}