<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('allies', function (Blueprint $table) {
            $table->id();
            $table->string('title_es');
            $table->string('title_en');
            $table->text('description_es')->nullable();
            $table->text('description_en')->nullable();
            $table->string('image')->nullable();
            $table->string('website_url')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string('category')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('allies');
    }
};
