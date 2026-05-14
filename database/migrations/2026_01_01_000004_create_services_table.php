<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            $table->string('title_ru');
            $table->string('title_kz')->nullable();
            $table->string('title_en')->nullable();

            $table->string('slug_ru')->unique();
            $table->string('slug_kz')->nullable();
            $table->string('slug_en')->nullable();

            $table->text('description_ru')->nullable();
            $table->text('description_kz')->nullable();
            $table->text('description_en')->nullable();

            $table->longText('content_ru')->nullable();
            $table->longText('content_kz')->nullable();
            $table->longText('content_en')->nullable();

            $table->string('meta_title_ru')->nullable();
            $table->string('meta_title_kz')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->text('meta_description_ru')->nullable();
            $table->text('meta_description_kz')->nullable();
            $table->text('meta_description_en')->nullable();

            $table->string('image')->nullable();
            $table->string('icon')->nullable(); // CSS-класс иконки или SVG
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->integer('sort_order')->default(0);

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
