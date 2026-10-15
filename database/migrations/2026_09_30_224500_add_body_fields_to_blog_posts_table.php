<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('author')->nullable()->after('slug');
            $table->timestamp('published_at')->nullable()->after('author');
            $table->longText('body_es')->nullable()->after('excerpt_en');
            $table->longText('body_en')->nullable()->after('body_es');
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn(['author', 'published_at', 'body_es', 'body_en']);
        });
    }
};
