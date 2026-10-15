<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title_es');
            $table->string('title_en');
            $table->string('slug')->unique();
            $table->text('excerpt_es')->nullable();
            $table->text('excerpt_en')->nullable();
            $table->string('image')->nullable();
            $table->string('category')->nullable();
            $table->string('filter_secondary')->nullable();
            $table->string('filter_tertiary')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
