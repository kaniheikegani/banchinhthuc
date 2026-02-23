<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->float('oral')->nullable();
            $table->float('attitude')->nullable();
            $table->float('midterm')->nullable();
            $table->float('final')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->foreignId('teacher_id')->nullable()->constrained('users');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scores', function (Blueprint $table) {
            //
        });
    }
};
