<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();

            $table->string('name_ru');
            $table->string('name_kz')->nullable();
            $table->string('name_en')->nullable();

            $table->text('description_ru')->nullable();
            $table->text('description_kz')->nullable();
            $table->text('description_en')->nullable();

            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->enum('type', ['partner', 'client'])->default('partner');
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
