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
        Schema::create('pelajarans', function (Blueprint $table) {
            $table->id();
            $table->string('day');
            $table->string('subject_name');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('teacher')->nullable();
            $table->string('room')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['day', 'start_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelajarans');
    }
};
