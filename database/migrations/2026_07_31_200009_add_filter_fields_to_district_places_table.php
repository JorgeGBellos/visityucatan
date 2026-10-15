<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('district_places', function (Blueprint $table) {
            $table->string('type')->nullable()->after('category');
            $table->string('filter_secondary')->nullable()->after('type');
            $table->string('filter_tertiary')->nullable()->after('filter_secondary');
        });
    }

    public function down(): void
    {
        Schema::table('district_places', function (Blueprint $table) {
            $table->dropColumn(['type', 'filter_secondary', 'filter_tertiary']);
        });
    }
};
