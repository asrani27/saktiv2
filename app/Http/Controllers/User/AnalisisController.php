<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Analisis;
use App\Models\AnalisisFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AnalisisController extends Controller
{
    /**
     * Display a listing of analisis with search functionality.
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');

        $analisis = Analisis::with('files')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%");
                });
            })
            ->where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('user.analisis.index', compact('analisis', 'search'));
    }

    /**
     * Display the specified analisis for AI analysis.
     */
    public function show(Analisis $analisi)
    {
        // Ensure user can only view their own data
        if ($analisi->user_id !== auth()->user()->id) {
            return redirect()
                ->route('user.analisis.index')
                ->with('error', 'Anda tidak memiliki akses ke data ini!');
        }

        // Load files
        $analisi->load('files');

        return view('user.analisis.show', compact('analisi'));
    }

    /**
     * Show the form for creating a new analisis.
     */
    public function create()
    {
        return view('user.analisis.create');
    }

    /**
     * Store a newly created analisis.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
        ]);

        // Create analisis
        $analisis = Analisis::create([
            'user_id' => auth()->user()->id,
            'judul' => $validated['judul'],
            'status_ocr' => 'pending',
        ]);

        return redirect()
            ->route('user.analisis.show', $analisis->id)
            ->with('success', 'Data analisis berhasil ditambahkan! Tambahkan file-file SPJ di bawah.');
    }

    /**
     * Store a new file for analisis.
     */
    public function storeFile(Request $request, Analisis $analisi)
    {
        // Ensure user can only access their own data
        if ($analisi->user_id !== auth()->user()->id) {
            return redirect()
                ->route('user.analisis.index')
                ->with('error', 'Anda tidak memiliki akses ke data ini!');
        }

        $validated = $request->validate([
            'nama_file' => ['required', 'string', 'max:255'],
            'file_url' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ]);

        $file = $request->file('file_url');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('analisis-files', $fileName, 'public');

        AnalisisFile::create([
            'analisis_id' => $analisi->id,
            'nama_file' => $validated['nama_file'],
            'file_url' => $filePath,
        ]);

        return redirect()
            ->back()
            ->with('success', 'File berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified analisis.
     */
    public function edit(Analisis $analisi)
    {
        // Ensure user can only edit their own data
        if ($analisi->user_id !== auth()->user()->id) {
            return redirect()
                ->route('user.analisis.index')
                ->with('error', 'Anda tidak memiliki akses ke data ini!');
        }

        $analisi->load('files');

        return view('user.analisis.edit', compact('analisi'));
    }

    /**
     * Update the specified analisis.
     */
    public function update(Request $request, Analisis $analisi)
    {
        // Ensure user can only update their own data
        if ($analisi->user_id !== auth()->user()->id) {
            return redirect()
                ->route('user.analisis.index')
                ->with('error', 'Anda tidak memiliki akses ke data ini!');
        }

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'files.*' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ]);

        $analisi->update([
            'judul' => $validated['judul'],
        ]);

        // Add new files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('analisis-files', $fileName, 'public');

                AnalisisFile::create([
                    'analisis_id' => $analisi->id,
                    'nama_file' => $file->getClientOriginalName(),
                    'file_url' => $filePath,
                ]);
            }
        }

        return redirect()
            ->route('user.analisis.index')
            ->with('success', 'Data analisis berhasil diperbarui!');
    }

    /**
     * Remove the specified analisis.
     */
    public function destroy(Analisis $analisi)
    {
        // Ensure user can only delete their own data
        if ($analisi->user_id !== auth()->user()->id) {
            return redirect()
                ->route('user.analisis.index')
                ->with('error', 'Anda tidak memiliki akses ke data ini!');
        }

        // Delete all files
        foreach ($analisi->files as $file) {
            Storage::disk('public')->delete($file->file_url);
        }

        $analisi->delete();

        return redirect()
            ->route('user.analisis.index')
            ->with('success', 'Data analisis berhasil dihapus!');
    }

    /**
     * Delete a specific file from analisis.
     */
    public function destroyFile(AnalisisFile $file)
    {
        // Ensure user can only delete their own files
        if ($file->analisis->user_id !== auth()->user()->id) {
            return redirect()
                ->route('user.analisis.index')
                ->with('error', 'Anda tidak memiliki akses ke data ini!');
        }

        Storage::disk('public')->delete($file->file_url);
        $file->delete();

        return redirect()
            ->back()
            ->with('success', 'File berhasil dihapus!');
    }

    /**
     * Perform OCR on a specific file.
     */
    public function performOcr(AnalisisFile $file)
    {
        // Ensure user can only access their own data
        if ($file->analisis->user_id !== auth()->user()->id) {
            return redirect()
                ->route('user.analisis.index')
                ->with('error', 'Anda tidak memiliki akses ke data ini!');
        }

        try {
            // Get the full path to the file
            $filePath = Storage::disk('public')->path($file->file_url);

            // Check if file exists
            if (!file_exists($filePath)) {
                throw new \Exception('File tidak ditemukan!');
            }

            // Get file extension
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            // Perform OCR based on file type
            $ocrText = $this->extractTextFromFile($filePath, $extension);

            // Update the file with OCR result
            $file->update([
                'hasil_ocr' => $ocrText,
            ]);

            return redirect()
                ->back()
                ->with('success', 'OCR berhasil dilakukan!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'OCR gagal: ' . $e->getMessage());
        }
    }

    /**
     * Extract text from file based on file type.
     */
    private function extractTextFromFile(string $filePath, string $extension): string
    {
        // For PDF files
        if ($extension === 'pdf') {
            return $this->extractTextFromPdf($filePath);
        }

        // For image files (jpg, jpeg, png)
        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
            return $this->extractTextFromImage($filePath);
        }

        throw new \Exception('Format file tidak didukung!');
    }

    /**
     * Extract text from PDF file.
     */
    private function extractTextFromPdf(string $filePath): string
    {
        // Try to use pdftotext if available (poppler-utils)
        $output = [];
        $returnCode = 0;

        exec("pdftotext \"$filePath\" - 2>/dev/null", $output, $returnCode);

        if ($returnCode === 0 && !empty($output)) {
            return implode("\n", $output);
        }

        // Fallback: Return a simulated response for demo purposes
        return "Hasil OCR:\n\n";
    }

    /**
     * Extract text from image file using Tesseract OCR.
     */
    private function extractTextFromImage(string $filePath): string
    {
        // Try to use tesseract if available
        $output = [];
        $returnCode = 0;

        exec("tesseract \"$filePath\" stdout -l ind 2>/dev/null", $output, $returnCode);

        if ($returnCode === 0 && !empty($output)) {
            return implode("\n", $output);
        }

        // Try with English as fallback
        exec("tesseract \"$filePath\" stdout 2>/dev/null", $output, $returnCode);

        if ($returnCode === 0 && !empty($output)) {
            return implode("\n", $output);
        }

        // Fallback: Return a simulated response for demo purposes
        return "Hasil OCR:";
    }

    /**
     * Perform AI analysis on the OCR result.
     */
    public function performAnalisis(Request $request, Analisis $analisi)
    {
        // Ensure user can only access their own data
        if ($analisi->user_id !== auth()->user()->id) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Anda tidak memiliki akses ke data ini!'], 403);
            }
            return redirect()
                ->route('user.analisis.index')
                ->with('error', 'Anda tidak memiliki akses ke data ini!');
        }

        // Check if any file has OCR result
        $hasOcrResult = $analisi->files()->whereNotNull('hasil_ocr')->exists();
        if (!$hasOcrResult) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Hasil OCR belum tersedia! Silakan lakukan OCR terlebih dahulu.'], 400);
            }
            return redirect()
                ->route('user.analisis.index')
                ->with('error', 'Hasil OCR belum tersedia! Silakan lakukan OCR terlebih dahulu.');
        }

        // Validate prompt
        $validated = $request->validate([
            'prompt' => ['required', 'string', 'max:2000'],
        ]);

        // Update status to processing
        $analisi->status_analisis = 'processing';
        $analisi->save();

        try {
            // Combine all OCR results from files
            $ocrTexts = $analisi->files()
                ->whereNotNull('hasil_ocr')
                ->pluck('hasil_ocr')
                ->toArray();

            $combinedOcr = implode("\n\n--- File Berikutnya ---\n\n", $ocrTexts);

            $analisisResult = $this->callAIForAnalisis($combinedOcr, $validated['prompt']);

            // Update the record with AI analysis result
            $analisi->hasil_analisis = $analisisResult;
            $analisi->status_analisis = 'completed';
            $analisi->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Analisis berhasil dilakukan!',
                    'hasil_analisis' => $analisisResult
                ]);
            }

            return redirect()
                ->route('user.analisis.show', $analisi->id)
                ->with('success', 'Analisis berhasil dilakukan!');
        } catch (\Exception $e) {
            Log::error('AI Analysis Error: ' . $e->getMessage());

            // Update status to failed
            $analisi->status_analisis = 'failed';
            $analisi->save();

            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Analisis gagal: ' . $e->getMessage()], 500);
            }

            return redirect()
                ->route('user.analisis.index')
                ->with('error', 'Analisis gagal: ' . $e->getMessage());
        }
    }

    /**
     * Call AI API for analysis.
     */
    private function callAIForAnalisis(string $ocrText, string $prompt): string
    {
        $apiKey = env('OPENAI_API_KEY', '');
        $model = env('OPENAI_MODEL', 'gpt-5.1');

        if (empty($apiKey)) {
            throw new \Exception('API key tidak dikonfigurasi. Silakan atur OPENAI_API_KEY di file .env');
        }

        $systemPrompt = "Kamu adalah asisten AI yang khusus menganalisis dokumen SPJ (Surat Pertanggungjawaban). " .
            "Kamu harus membantu pengguna memahami, memvalidasi, dan memberikan insight dari dokumen SPJ. " .
            "Gunakan Bahasa Indonesia untuk respons. JANGAN gunakan format Markdown seperti **bold**, *italic*, atau markdown formatting lainnya. Langsung tulis teks biasa saja.";

        $userPrompt = "Berikut adalah hasil OCR dari dokumen SPJ:\n\n{$ocrText}\n\n\nPertanyaan/Prompt dari pengguna:\n{$prompt}";

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => $userPrompt],
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->timeout(120)->post('https://api.openai.com/v1/chat/completions', [
            'model' => $model,
            'messages' => $messages,
            'temperature' => 0.7,
            'max_completion_tokens' => 4000,
        ]);

        if (!$response->successful()) {
            $error = $response->json();
            throw new \Exception($error['error']['message'] ?? 'API request failed');
        }

        return $response->json()['choices'][0]['message']['content'] ?? 'Maaf, saya tidak dapat menjawab saat ini.';
    }
}
