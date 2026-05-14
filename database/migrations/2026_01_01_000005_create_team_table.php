<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team', function (Blueprint $table) {
            $table->id();

            $table->string('name_ru');
            $table->string('name_kz')->nullable();
            $table->string('name_en')->nullable();

            $table->string('position_ru')->nullable();
            $table->string('position_kz')->nullable();
            $table->string('position_en')->nullable();

            $table->text('bio_ru')->nullable();
            $table->text('bio_kz')->nullable();
            $table->text('bio_en')->nullable();

            $table->string('photo')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            // Социальные сети
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();

            $table->enum('status', ['draft', 'published'])->default('published');
            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team');
    }
};
