<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalisisSpj extends Model
{
    use HasFactory;

    protected $table = 'analisis';

    protected $fillable = ['user_id', 'judul', 'file_spj', 'hasil_ocr', 'status_ocr', 'hasil_analisis', 'status_analisis'];
    
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the analisis SPJ.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get status badge color for OCR.
     */
    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status_ocr) {
            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'label' => 'Pending'],
            'processing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => 'Processing'],
            'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Completed'],
            'failed' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Failed'],
            default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => 'Unknown'],
        };
    }

    /**
     * Get status badge color for AI Analysis.
     */
    public function getAnalisisBadgeAttribute(): array
    {
        return match ($this->status_analisis) {
            'pending' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'label' => 'Pending'],
            'processing' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-700', 'label' => 'Processing'],
            'completed' => ['bg' => 'bg-teal-100', 'text' => 'text-teal-700', 'label' => 'Completed'],
            'failed' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-700', 'label' => 'Failed'],
            default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => 'Unknown'],
        };
    }
}
