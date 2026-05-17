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
        Schema::table('analisis', function (Blueprint $table) {
            $table->text('hasil_analisis')->nullable()->after('hasil_ocr');
            $table->enum('status_analisis', ['pending', 'processing', 'completed', 'failed'])->default('pending')->after('status_ocr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('analisis', function (Blueprint $table) {
            $table->dropColumn(['hasil_analisis', 'status_analisis']);
        });
    }
};