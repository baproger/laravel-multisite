<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            // Заголовки
            $table->string('title_ru');
            $table->string('title_kz')->nullable();
            $table->string('title_en')->nullable();

            // Слаги
            $table->string('slug_ru')->unique();
            $table->string('slug_kz')->nullable();
            $table->string('slug_en')->nullable();

            // Краткое описание
            $table->text('description_ru')->nullable();
            $table->text('description_kz')->nullable();
            $table->text('description_en')->nullable();

            // Основной контент
            $table->longText('content_ru')->nullable();
            $table->longText('content_kz')->nullable();
            $table->longText('content_en')->nullable();

            // SEO
            $table->string('meta_title_ru')->nullable();
            $table->string('meta_title_kz')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->text('meta_description_ru')->nullable();
            $table->text('meta_description_kz')->nullable();
            $table->text('meta_description_en')->nullable();

            // Изображение
            $table->string('image')->nullable();

            // Публикация
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->integer('sort_order')->default(0);
            $table->boolean('show_in_menu')->default(false);

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
