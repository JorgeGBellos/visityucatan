<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('directory_filters', function (Blueprint $table) {
            $table->id();
            $table->string('group'); // type | secondary | tertiary
            $table->string('slug');
            $table->string('title_es');
            $table->string('title_en');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->unique(['group', 'slug']);
            $table->index(['group', 'is_published', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('directory_filters');
    }
};
