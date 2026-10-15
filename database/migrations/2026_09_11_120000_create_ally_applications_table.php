<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ally_applications', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('business_type');
            $table->text('description');
            $table->string('phone', 60);
            $table->string('website');
            $table->json('photos')->nullable();
            $table->string('status', 32)->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ally_applications');
    }
};
