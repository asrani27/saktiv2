<!-- Analisis Modal -->
<div id="analisis-modal" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" onclick="closeAnalisisModal()"></div>
    
    <!-- Modal Content -->
    <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-2xl transform rounded-2xl bg-white shadow-2xl transition-all">
                <!-- Header -->
                <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Analisis dengan AI</h3>
                        <p class="text-sm text-gray-500 mt-0.5">Ajukan pertanyaan tentang hasil OCR dokumen</p>
                    </div>
                    <button type="button" onclick="closeAnalisisModal()" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <!-- Body -->
                <div class="px-6 py-4 max-h-[60vh] overflow-y-auto">
                    <!-- OCR Preview -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hasil OCR</label>
                        <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-600 max-h-40 overflow-y-auto border border-gray-200">
                            <pre id="ocr-preview" class="whitespace-pre-wrap font-sans"></pre>
                        </div>
                    </div>
                    
                    <!-- Prompt Input -->
                    <form id="analisis-form">
                        @csrf
                        <input type="hidden" id="analisis-id" name="analisis_id">
                        <div class="mb-4">
                            <label for="prompt" class="block text-sm font-medium text-gray-700 mb-2">Prompt / Pertanyaan</label>
                            <textarea 
                                id="prompt" 
                                name="prompt" 
                                rows="4" 
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all resize-none"
                                placeholder="Contoh: Analisis dokumen ini dan jelaskan hal-hal penting yang perlu diperhatikan dalam SPJ..."
                                required
                            ></textarea>
                        </div>
                        
                        <!-- AI Response -->
                        <div id="ai-response-container" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Respon AI</label>
                            <div id="ai-response" class="bg-purple-50 rounded-xl p-4 text-sm text-gray-700 max-h-60 overflow-y-auto border border-purple-100">
                                <pre class="whitespace-pre-wrap font-sans"></pre>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Loading State -->
                    <div id="analisis-loading" class="hidden text-center py-6">
                        <div class="inline-flex items-center gap-3">
                            <svg class="w-6 h-6 animate-spin text-purple-600" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-gray-600">Menganalisis dengan AI...</span>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="flex items-center justify-end gap-3 border-t border-gray-100 px-6 py-4">
                    <button 
                        type="button" 
                        onclick="closeAnalisisModal()" 
                        class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-all duration-150"
                    >
                        Tutup
                    </button>
                    <button 
                        type="button" 
                        id="btn-submit-analisis"
                        onclick="submitAnalisis()"
                        class="px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-medium shadow-lg shadow-purple-600/30 transition-all duration-150 flex items-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        <span>Analisis</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentAnalisisId = null;

    function openAnalisisModal(analisisId, ocrText) {
        currentAnalisisId = analisisId;
        document.getElementById('analisis-id').value = analisisId;
        document.getElementById('ocr-preview').textContent = ocrText || 'Tidak ada hasil OCR';
        document.getElementById('prompt').value = '';
        document.getElementById('ai-response-container').classList.add('hidden');
        document.getElementById('analisis-loading').classList.add('hidden');
        document.getElementById('btn-submit-analisis').disabled = false;
        
        document.getElementById('analisis-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeAnalisisModal() {
        document.getElementById('analisis-modal').classList.add('hidden');
        document.body.style.overflow = '';
        currentAnalisisId = null;
    }

    async function submitAnalisis() {
        const prompt = document.getElementById('prompt').value.trim();
        
        if (!prompt) {
            alert('Silakan isi prompt/pertanyaan terlebih dahulu');
            return;
        }

        if (!currentAnalisisId) {
            alert('Terjadi kesalahan. Silakan coba lagi.');
            return;
        }

        // Show loading
        document.getElementById('analisis-loading').classList.remove('hidden');
        document.getElementById('btn-submit-analisis').disabled = true;

        try {
            const formData = new FormData();
            formData.append('prompt', prompt);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value);

            const response = await fetch(`/user/analisis/${currentAnalisisId}/analisis`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            });

            const result = await response.json();

            if (result.success) {
                // Show response
                document.getElementById('ai-response').querySelector('pre').textContent = result.hasil_analisis;
                document.getElementById('ai-response-container').classList.remove('hidden');
                
                // Show success message
                showToast('Analisis berhasil dilakukan!', 'success');
            } else {
                alert('Error: ' + (result.error || 'Terjadi kesalahan'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengirim请求. Silakan coba lagi.');
        } finally {
            document.getElementById('analisis-loading').classList.add('hidden');
            document.getElementById('btn-submit-analisis').disabled = false;
        }
    }

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAnalisisModal();
        }
    });

    // Toast notification helper
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-xl shadow-lg z-50 transition-all transform translate-y-full opacity-0 ${type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'} text-white font-medium`;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-y-full', 'opacity-0');
        }, 10);
        
        // Animate out and remove
        setTimeout(() => {
            toast.classList.add('translate-y-full', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
</script>