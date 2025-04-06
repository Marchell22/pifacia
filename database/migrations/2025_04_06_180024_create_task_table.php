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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $table->enum('status', ['belum_dimulai', 'dalam_proses', 'selesai'])->default('belum_dimulai');
            $table->date('deadline')->nullable();
            $table->boolean('selesai')->default(false);
            $table->json('metadata')->nullable();
            $table->string('lampiran')->nullable(); // Untuk file PDF
            $table->foreignId('project_id')->constrained();
            $table->foreignId('user_id')->nullable()->constrained(); // Assigned To
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
