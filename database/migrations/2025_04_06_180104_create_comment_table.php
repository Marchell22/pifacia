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
          Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->text('isi');
            $table->boolean('internal')->default(false); // apakah komentar hanya untuk tim internal
            $table->json('metadata')->nullable();
            $table->foreignId('task_id')->constrained();
            $table->foreignId('user_id')->constrained(); // Comment Author
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment');
    }
};
