<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faq', function (Blueprint $table) {
            $table->id();

            $table->string('question_ru');
            $table->string('question_kz')->nullable();
            $table->string('question_en')->nullable();

            $table->text('answer_ru');
            $table->text('answer_kz')->nullable();
            $table->text('answer_en')->nullable();

            $table->string('category_ru')->nullable();
            $table->string('category_kz')->nullable();
            $table->string('category_en')->nullable();

            $table->enum('status', ['draft', 'published'])->default('published');
            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq');
    }
};
