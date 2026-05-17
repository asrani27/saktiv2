@extends('layouts.master')

@section('title', 'Chat AI - Saktiv')
@section('page_title', 'Chat AI')

@push('styles')
<style>
    .messages-container {
        flex: 1;
        overflow-y: auto;
        scroll-behavior: smooth;
    }

    .messages-container::-webkit-scrollbar {
        width: 6px;
    }

    .messages-container::-webkit-scrollbar-track {
        background: transparent;
    }

    .messages-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    .typing-indicator span {
        animation: typing 1.4s infinite;
        display: inline-block;
    }

    .typing-indicator span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-indicator span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typing {

        0%,
        60%,
        100% {
            transform: translateY(0);
        }

        30% {
            transform: translateY(-4px);
        }
    }
</style>
@endpush

@section('content')
<div class="mx-auto">
    <div class="flex flex-col lg:flex-row h-full gap-4" style="height: calc(100vh - 140px);">
        {{-- Sidebar Chat List --}}
        <div class="hidden lg:block w-80 flex-shrink-0 bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
            <div class="p-4 border-b border-gray-100">
                <a href="{{ route('user.chat.create') }}"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-all duration-150">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>New Chat</span>
                </a>
            </div>

            <div class="flex-1 overflow-y-auto">
                @forelse ($conversations as $conv)
                <a href="{{ route('user.chat.index', ['conversation' => $conv->id]) }}"
                    class="flex items-center justify-between p-4 border-b border-gray-50 hover:bg-gray-50 transition-colors {{ $activeConversation && $activeConversation->id === $conv->id ? 'bg-blue-50 border-l-4 border-l-blue-500' : '' }}">
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-800 truncate text-sm">{{ $conv->title }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $conv->updated_at->diffForHumans() }}</p>
                    </div>
                    <form action="{{ route('user.chat.delete', $conv->id) }}" method="POST" class="ml-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Hapus percakapan ini?')"
                            class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </a>
                @empty
                <div class="p-8 text-center">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <p class="text-gray-500 text-sm">Belum ada percakapan</p>
                    <p class="text-gray-400 text-xs mt-1">Klik "New Chat" untuk memulai</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Chat Area --}}
        <div class="flex-1 bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
            @if ($activeConversation)
            {{-- Chat Header --}}
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-gray-800">{{ $activeConversation->title }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5"><span id="messageCount">{{ $messages->count() }}</span>
                        pesan</p>
                </div>
            </div>

            {{-- Messages --}}
            <div class="flex-1 messages-container p-6 space-y-4 overflow-y-auto" id="messagesContainer">
                @if($messages->count() > 0)
                @foreach ($messages as $message)
                @if ($message->role === 'user')
                <div class="flex justify-end">
                    <div class="max-w-[70%]">
                        <div class="bg-blue-600 text-white px-4 py-3 rounded-2xl rounded-br-md">
                            @if($message->content)
                            <p class="text-sm">{!! nl2br(e($message->content)) !!}</p>
                            @endif
                            @if($message->file_path)
                            @if($message->file_type && Str::startsWith($message->file_type, 'image/'))
                            <div class="mt-2 rounded-lg overflow-hidden max-w-[200px]">
                                <img src="{{ asset('storage/' . $message->file_path) }}" alt="{{ $message->file_name }}"
                                    class="max-w-full h-auto rounded-lg">
                                <p class="text-xs mt-1 opacity-75">{{ $message->file_name }}</p>
                            </div>
                            @else
                            <div class="mt-2 flex items-center gap-2 p-2 bg-white/20 rounded-lg">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span class="text-xs truncate">{{ $message->file_name }}</span>
                            </div>
                            @endif
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 mt-1 text-right">{{ $message->created_at->format('H:i') }}</p>
                    </div>
                </div>
                @else
                <div class="flex justify-start">
                    <div class="max-w-[70%]">
                        <div class="bg-gray-100 text-gray-800 px-4 py-3 rounded-2xl rounded-bl-md">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm whitespace-pre-wrap">{!! nl2br(e($message->content)) !!}</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">{{ $message->created_at->format('H:i') }}</p>
                    </div>
                </div>
                @endif
                @endforeach
                @else
                <div id="emptyState" class="flex items-center justify-center h-full">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Mulai Percakapan</h3>
                        <p class="text-gray-500 text-sm max-w-xs">Tanyakan apapun dan saya akan membantu sebaik mungkin!
                        </p>
                    </div>
                </div>
                @endif
            </div>

            {{-- Input Area --}}
            <div class="p-4 border-t border-gray-100">
                {{-- File Preview --}}
                <div id="filePreview" class="mb-3 hidden">
                    <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-xl border border-blue-100">
                        <div id="filePreviewIcon"
                            class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p id="fileName" class="text-sm font-medium text-gray-800 truncate"></p>
                            <p id="fileSize" class="text-xs text-gray-500"></p>
                        </div>
                        <button type="button" onclick="removeFile()"
                            class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <form id="chatForm" enctype="multipart/form-data" class="flex items-center gap-3">
                    @csrf
                    <input type="hidden" name="conversation_id" value="{{ $activeConversation->id }}">

                    {{-- File Upload Button --}}
                    <label
                        class="p-3 bg-gray-100 hover:bg-gray-200 rounded-xl cursor-pointer transition-colors flex-shrink-0"
                        title="Upload file (PDF/Gambar)">
                        <input type="file" id="fileInput" name="file" accept=".pdf,.jpg,.jpeg,.png,.gif,.webp"
                            class="hidden" onchange="handleFileSelect(this)">
                        <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </label>

                    {{-- Message Input --}}
                    <div class="flex-1 relative">
                        <textarea name="message" id="messageInput" rows="1"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none"
                            placeholder="Ketik pesan atau attach file..." onkeydown="handleKeyDown(event)"
                            autofocus></textarea>
                    </div>
                    <button type="submit" id="sendButton"
                        class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-all duration-150 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        <span class="hidden sm:inline">Kirim</span>
                    </button>
                </form>
            </div>
            @else
            {{-- Empty State --}}
            <div class="flex-1 flex items-center justify-center">
                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Selamat Datang di Chat AI</h3>
                    <p class="text-gray-500 mb-6">Pilih percakapan atau mulai yang baru</p>
                    <a href="{{ route('user.chat.create') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-all duration-150">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>New Chat</span>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const form = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.getElementById('sendButton');
    const messagesContainer = document.getElementById('messagesContainer');
    const emptyState = document.getElementById('emptyState');
    const messageCountEl = document.getElementById('messageCount');
    const conversationId = '{{ $activeConversation ? $activeConversation->id : "" }}';
    let messageCount = {{ $messages->count() }};

    // Auto-resize textarea
    if (messageInput) {
        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 150) + 'px';
        });
    }

    // Handle Enter key
    function handleKeyDown(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if (form) form.dispatchEvent(new Event('submit'));
        }
    }

    // Scroll to bottom
    function scrollToBottom() {
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }

    // Hide empty state
    function hideEmptyState() {
        if (emptyState) {
            emptyState.style.display = 'none';
        }
    }

    // Update message count
    function updateMessageCount() {
        if (messageCountEl) {
            messageCountEl.textContent = messageCount;
        }
    }

    // Add message to UI
    function addMessage(role, content, time, fileData = null) {
        hideEmptyState();
        const isUser = role === 'user';
        const div = document.createElement('div');
        div.className = `flex ${isUser ? 'justify-end' : 'justify-start'}`;
        
        let filePreview = '';
        if (fileData) {
            const isImage = fileData.file_type && fileData.file_type.startsWith('image/');
            if (isImage) {
                filePreview = `
                    <div class="mt-2 rounded-lg overflow-hidden max-w-[200px]">
                        <img src="/storage/${fileData.file_path}" alt="${fileData.file_name}" class="max-w-full h-auto rounded-lg">
                        <p class="text-xs mt-1 opacity-75">${fileData.file_name}</p>
                    </div>
                `;
            } else {
                filePreview = `
                    <div class="mt-2 flex items-center gap-2 p-2 bg-white/20 rounded-lg">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="text-xs truncate">${fileData.file_name}</span>
                    </div>
                `;
            }
        }
        
        div.innerHTML = `
            <div class="max-w-[70%]">
                <div class="${isUser ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800'} px-4 py-3 rounded-2xl ${isUser ? 'rounded-br-md' : 'rounded-bl-md'}">
                    ${content ? `<p class="text-sm whitespace-pre-wrap">${content.replace(/\n/g, '<br>')}</p>` : ''}
                    ${filePreview}
                </div>
                <p class="text-xs text-gray-400 mt-1 ${isUser ? 'text-right' : ''}">${time}</p>
            </div>
        `;
        
        messagesContainer.appendChild(div);
        messageCount++;
        updateMessageCount();
        scrollToBottom();
    }

    // Show typing indicator
    function showTyping() {
        const div = document.createElement('div');
        div.id = 'typingIndicator';
        div.className = 'flex justify-start';
        div.innerHTML = `
            <div class="max-w-[70%]">
                <div class="bg-gray-100 text-gray-800 px-4 py-3 rounded-2xl rounded-bl-md">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <div class="typing-indicator">
                            <span style="animation: typing 1.4s infinite; display: inline-block;">.</span><span style="animation: typing 1.4s infinite; animation-delay: 0.2s; display: inline-block;">.</span><span style="animation: typing 1.4s infinite; animation-delay: 0.4s; display: inline-block;">.</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
        messagesContainer.appendChild(div);
        scrollToBottom();
    }

    // Remove typing indicator
    function removeTyping() {
        const typing = document.getElementById('typingIndicator');
        if (typing) typing.remove();
    }

    // File handling
    const fileInput = document.getElementById('fileInput');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const filePreviewIcon = document.getElementById('filePreviewIcon');
    let selectedFile = null;

    function handleFileSelect(input) {
        const file = input.files[0];
        if (!file) return;

        // Validate file type
        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            alert('Hanya file PDF dan gambar (JPG, PNG, GIF, WEBP) yang diizinkan.');
            input.value = '';
            return;
        }

        // Validate file size (10MB)
        if (file.size > 10 * 1024 * 1024) {
            alert('Ukuran file maksimal 10MB.');
            input.value = '';
            return;
        }

        selectedFile = file;
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);

        // Update icon based on file type
        if (file.type === 'application/pdf') {
            filePreviewIcon.innerHTML = `
                <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            `;
        } else {
            filePreviewIcon.innerHTML = `
                <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            `;
        }

        filePreview.classList.remove('hidden');
        messageInput.focus();
    }

    function removeFile() {
        if (fileInput) fileInput.value = '';
        selectedFile = null;
        filePreview.classList.add('hidden');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Submit form
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const message = messageInput.value.trim();
            
            // Must have either message or file
            if (!message && !selectedFile) {
                alert('Harap isi pesan atau upload file.');
                return;
            }

            // Disable form
            messageInput.disabled = true;
            sendButton.disabled = true;
            if (fileInput) fileInput.disabled = true;
            sendButton.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

            // Create form data for file upload
            const formData = new FormData();
            formData.append('message', message);
            formData.append('conversation_id', conversationId);
            if (selectedFile) {
                formData.append('file', selectedFile);
            }

            // Add user message to UI
            const fileData = selectedFile ? {
                file_path: '',
                file_name: selectedFile.name,
                file_type: selectedFile.type
            } : null;
            addMessage('user', message, new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}), fileData);
            
            messageInput.value = '';
            messageInput.style.height = 'auto';
            removeFile();

            // Show typing
            showTyping();

            try {
                const response = await fetch('{{ route('user.chat.send') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                const data = await response.json();
                removeTyping();

                if (data.success && data.assistant_message) {
                    addMessage('assistant', data.assistant_message.content, new Date(data.assistant_message.created_at).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}));
                } else {
                    addMessage('assistant', data.error || 'Terjadi kesalahan. Silakan coba lagi.', new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}));
                }
            } catch (error) {
                removeTyping();
                addMessage('assistant', 'Terjadi kesalahan koneksi. Silakan coba lagi.', new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}));
            }

            // Re-enable form
            messageInput.disabled = false;
            sendButton.disabled = false;
            if (fileInput) fileInput.disabled = false;
            sendButton.innerHTML = '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg><span class="hidden sm:inline">Kirim</span>';
            messageInput.focus();
        });
    }

    // Scroll to bottom on load
    scrollToBottom();
</script>
@endpush