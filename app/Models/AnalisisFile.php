<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalisisFile extends Model
{
    use HasFactory;

    protected $table = 'analisis_files';

    protected $fillable = ['analisis_id', 'nama_file', 'file_url', 'hasil_ocr'];
    
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the analisis that owns the file.
     */
    public function analisis(): BelongsTo
    {
        return $this->belongsTo(Analisis::class);
    }
}