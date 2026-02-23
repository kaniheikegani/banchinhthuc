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
        Schema::create('teacher_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->string('type'); // ví dụ: 'nghỉ tiết', 'nghỉ ngày', 'đổi lịch'
            $table->text('reason');
            $table->date('requested_date')->nullable(); // ngày xin nghỉ
            $table->string('session')->nullable(); // 'morning', 'afternoon', hoặc tiết cụ thể
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_requests');
    }
};
