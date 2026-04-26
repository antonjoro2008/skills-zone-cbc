<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learner_user_id')->index();
            $table->unsignedBigInteger('classroom_id')->nullable()->index();
            $table->string('subject')->nullable(); // e.g. Literacy / Numeracy
            $table->string('assessment_title'); // e.g. "Grade 5 Literacy - Level 1"
            $table->unsignedTinyInteger('score_percent'); // 0..100
            $table->timestamp('assessed_at')->nullable();
            $table->timestamps();

            $table->foreign('learner_user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('classroom_id')->references('id')->on('classrooms')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_results');
    }
};

