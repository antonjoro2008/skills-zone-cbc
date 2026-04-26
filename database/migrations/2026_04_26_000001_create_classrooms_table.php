<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('institution_id')->nullable()->index();
            $table->unsignedBigInteger('teacher_user_id')->nullable()->index();
            $table->string('name'); // e.g. "Grade 5"
            $table->string('grade_level'); // e.g. "Grade 5"
            $table->timestamps();

            $table->foreign('institution_id')->references('id')->on('institutions')->nullOnDelete();
            $table->foreign('teacher_user_id')->references('id')->on('users')->nullOnDelete();
        });

        Schema::create('classroom_user', function (Blueprint $table) {
            $table->unsignedBigInteger('classroom_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->primary(['classroom_id', 'user_id']);
            $table->foreign('classroom_id')->references('id')->on('classrooms')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classroom_user');
        Schema::dropIfExists('classrooms');
    }
};

