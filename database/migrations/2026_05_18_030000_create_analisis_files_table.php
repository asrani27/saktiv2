<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('analisis_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('analisis_id')->constrained('analisis')->onDelete('cascade');
            $table->string('nama_file');
            $table->string('file_url');
            $table->text('hasil_ocr')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analisis_files');
    }
};