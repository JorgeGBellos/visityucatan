<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title_es');
            $table->string('title_en');
            $table->string('slug')->unique();
            $table->string('category_es')->nullable();
            $table->string('category_en')->nullable();
            $table->string('date_label_es')->nullable();
            $table->string('date_label_en')->nullable();
            $table->string('location_es')->nullable();
            $table->string('location_en')->nullable();
            $table->string('image')->nullable();
            $table->date('starts_at')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
