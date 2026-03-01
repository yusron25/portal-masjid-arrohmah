<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (! Schema::hasColumn('posts', 'thumbnail')) {
                $table->string('thumbnail')->nullable()->after('slug');
            }

            if (! Schema::hasColumn('posts', 'content')) {
                $table->longText('content')->nullable()->after('thumbnail');
            }

            if (! Schema::hasColumn('posts', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('content');
            }

            if (! Schema::hasColumn('posts', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('published_at');
            }

            if (! Schema::hasColumn('posts', 'category_id')) {
                $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete()->after('is_active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'category_id')) {
                $table->dropConstrainedForeignId('category_id');
            }

            if (Schema::hasColumn('posts', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('posts', 'published_at')) {
                $table->dropColumn('published_at');
            }

            if (Schema::hasColumn('posts', 'content')) {
                $table->dropColumn('content');
            }

            if (Schema::hasColumn('posts', 'thumbnail')) {
                $table->dropColumn('thumbnail');
            }
        });
    }
};
