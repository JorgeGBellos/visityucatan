<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('district_places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('district_id')->constrained()->cascadeOnDelete();
            $table->string('category');
            $table->string('title_es');
            $table->string('title_en');
            $table->text('description_es')->nullable();
            $table->text('description_en')->nullable();
            $table->string('image')->nullable();
            $table->string('phone')->nullable();
            $table->string('website_url')->nullable();
            $table->string('location')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index(['district_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('district_places');
    }
};
